<?php

class SiteController extends Controller
{

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function filters()
    {
        return array(
            array(
                'frontend.components.FacebookAccessCheckerFilter + index'
            )
        );
    }

    public function behaviors()
    {
        return array(
            'seo' => array('class' => 'frontend.extensions.seo.components.SeoControllerBehavior')
        );
    }

    public function actionCity($id)
    {
        //change city
        //redirect to index with selected category
        Yii::app()->session['LastCity'] = $id;
        $redirectUrl = Yii::app()->controller->createAbsoluteUrl('/site/list');
        $this->redirect($redirectUrl);
    }

    public function actionSuggest($term)
    {
        $adapter = new SuggestAdapter();
        $adapter->setKeyword($term);
        $suggests = $adapter->getSuggestion();
        echo json_encode($suggests);
    }

    public function actionSortType($type)
    {        
        SolrSortTypeUtil::getInstance()->setSortType($type);

        if (isset(Yii::app()->session['LastCity'])) {
            $city = Yii::app()->session['LastCity'];
        }
        $category = Yii::app()->session->get('LastCategory', null);
        $keyword = Yii::app()->session->get('LastKeyword', null);

        $this->redirect($this->createUrl('list', array(
                    'keyword' => $keyword,
                    'category' => $category,
                    'page' => 0
        )));
    }

    public function actionList($keyword = null, $category = null, $facebook = false, $page = 0)
    {                
        $keyword = trim(filter_var($keyword, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES));
        Yii::app()->session['LastPageNumber'] = $page;
        Yii::app()->session['LastCategory'] = $category;
        Yii::app()->session['LastKeyword'] = $keyword;
        $categoryModel = null;
        if ($category != null) {
            $categoryModel = Category::model()->findByPk($category);
        }
        if ($keyword != '') {
            $this->pageTitle = Yii::app()->name . ' - Kết quả tìm kiếm cho từ khóa ' . $keyword;
        }
        else if ($categoryModel != null) {
            $this->pageTitle = Yii::app()->name . ' - Danh mục ' . $categoryModel->name;
        }
        else if ($facebook) {
            $this->pageTitle = Yii::app()->name . ' - Sản phẩm được đăng từ bạn bè của bạn';
        }

        $city = 0;
        if (isset(Yii::app()->session['LastCity'])) {
            $city = Yii::app()->session['LastCity'];
        }

        $solrAdapter = new SolrSearchAdapter();
        $solrAdapter->setSortType(SolrSortTypeUtil::getInstance()->getCurrentSortType());
        $solrAdapter->categoryId = $category;
        $solrAdapter->cityId = $city;
        $solrAdapter->page = $page;
        $solrAdapter->pageSize = 12;
        $solrAdapter->country = Yii::app()->country->getId();
        $solrAdapter->keyword = $keyword;
        if($solrAdapter->getSortType() == SolrSearchAdapter::TYPE_LOCATION){
            $locationArray = UserLocationUtil::getInstance()->getLocation();
            if($locationArray !== false){
                $solrAdapter->setLocation($locationArray[0],$locationArray[1]);
            }
            
        }
        Yii::beginProfile('search');
        $resultSet = $solrAdapter->search();
        Yii::endProfile('search');

        $productList = $resultSet->productList;

        $empty = $page * $solrAdapter->pageSize + $solrAdapter->pageSize > $resultSet->numFound;
        $params = array(
            'keyword' => $keyword,
            'category' => $category,
            'facebook' => $facebook,
            'page' => $page + 2
        );
        $nextPageUrl = $this->createNextUrl($params);
        $nextPageLink = CHtml::link('Next', $nextPageUrl, array(
                    'class' => 'nextPageLink',
        ));

        if (!Yii::app()->request->isAjaxRequest) {
            $this->render('category', array(
                'numFound' => $resultSet->numFound,
                'productList' => $productList,
                'nextPageLink' => $nextPageLink,
                'keyword' => $keyword,
                'categoryModel' => $categoryModel,
                'facebook' => $facebook,
                'empty' => $empty
            ));
        }
        else {
            $html = '';
            if ($empty == false) {
                $html = $this->renderPartial('/site/_board', array(
                    'productList' => $productList,
                    'nextPageLink' => $nextPageLink
                ));
            }

            echo $html;
            Yii::app()->end();
        }
    }               

    public function actionIndex()
    {
        if (Yii::app()->user->isGuest == true && !isset(Yii::app()->session['VisitLanding'])) {
            Yii::app()->session['VisitLanding'] = true;
            $this->redirect($this->createUrl('landing'));
        }
        $categoryList = Category::model()->findAll();
        $this->render('index',array(
            'categoryList'=>$categoryList
        ));
    }

    protected function createNextUrl($params)
    {
        return Yii::app()->controller->createAbsoluteUrl('/site/list', $params);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                $this->renderAjaxResult(false, array(
                    'code' => $error['code'],
                    'message' => $error['message']
                ));
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionDetail()
    {
        $this->render('detail_view');
    }

    public function actionTerms()
    {
        if (Yii::app()->language == 'en')
            $this->render('pages/term_en');
        else
            $this->render('pages/term');
    }

    public function actionIntroduction()
    {
        $this->layout = '//layouts/noMenu';
        if (Yii::app()->language == 'en')
            $this->render('pages/intro_en');
        else
            $this->render('pages/intro');
    }

    public function actionEnLang()
    {
        $currentUrl = Yii::app()->request->urlReferrer;
        Yii::app()->session['itake_lang'] = 'en';
        $this->redirect($currentUrl);
    }

    public function actionViLang()
    {
        $currentUrl = Yii::app()->request->urlReferrer;
        Yii::app()->session['itake_lang'] = 'vi';
        $this->redirect($currentUrl);
    }

    public function actionLanding()
    {
        $this->layout = '//layouts/noMenu';
        if (Yii::app()->language == 'en')
            $this->render('landing');
        else
            $this->render('landing_vi');
    }

    public function actionFAQ()
    {
        //waiting for KHOA
    }

    public function actionLocationDialog()
    {
        $location = new LocationForm();
        $location->city = CityUtil::getSelectedCityId();
        $userLocation = UserLocationUtil::getInstance()->getLocation();
        if($userLocation!==false){
            $url = $this->createUrl('/site/sortType',array('type'=>  SolrSearchAdapter::TYPE_LOCATION));
            $this->renderAjaxResult(true,array(
                'alreadyHaveLocation'=>true,
                'url'=>$url
            ));
        }else{
            $html = $this->renderPartial('/site/partial/selectLocationDialog', array(
                'location' => $location
                    ), true, false);
            $this->renderAjaxResult(true, array(
                'html' => $html,
                'alreadyHaveLocation'=>false
            ));
        }
        
    }

    public function actionSaveLocation()
    {
        $lat = Yii::app()->request->getPost('lat');
        $lng = Yii::app()->request->getPost('lng');
        if($lat!=null && $lng!=null){
            UserLocationUtil::getInstance()->setLocation(array($lat,$lng));
            $url = $this->createUrl('/site/sortType',array('type'=>  SolrSearchAdapter::TYPE_LOCATION));
            $this->renderAjaxResult(true,array('url'=>$url));
        }else{
            $this->renderAjaxResult(false,'Invalid data');
        }        
    }
    
    

}