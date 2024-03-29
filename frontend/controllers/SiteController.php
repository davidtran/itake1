<?php
class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }
    public function init() {        
        return parent::init();
    }
    public function filters() {
        return array(
            array(
                'frontend.components.FacebookAccessCheckerFilter + index,facebook,landing'
            )
        );
    }

    public function behaviors() {
        return array(
            'seo' => array('class' => 'frontend.extensions.seo.components.SeoControllerBehavior')
        );
    }

    public function actionCity($city) {    
        CityUtil::setSelectedCityId($city);        
        $this->actionIndex();
    }

    public function actionSuggest($term) {
        $adapter = new SuggestAdapter();
        $adapter->setKeyword($term);
        $suggests = $adapter->getSuggestion();
        echo json_encode($suggests);
    }

    public function actionSortType($type) {
        SolrSortTypeUtil::getInstance()->setSortType($type);
        $city = UserRegistry::getInstance()->getValue('City');
        $category = Yii::app()->session->get('LastCategory', null);
        $keyword = Yii::app()->session->get('LastKeyword', null);
        $this->redirect($this->createUrl('index', array(
                    'keyword' => null,
                    'category' => $category,
                    'page' => 0
        )));
    }

    public function actionFacebook() {
        $url = $this->createUrl('index', array(
            'keyword' => null,
            'category' => Yii::app()->session['LastCategory'],
            'facebook' => 1,
            'page' => 0,
            'status' => Product::STATUS_ACTIVE
        ));
        $this->redirect($url);
    }

    public function actionSold() {
        $url = $this->createUrl('index', array(
            'keyword' => null,
            'category' => Yii::app()->session['LastCategory'],
            'facebook' => 0,
            'page' => 0,
            'status' => Product::STATUS_SOLD
        ));
        $this->redirect($url);
    }
    
    public function actionCategory($category,$city = null){                      
        if($city){            
            CityUtil::setSelectedCityId($city);
        }
        
        $this->actionIndex(null,$category);
    }

    public function actionIndex($keyword = null, $category = null, $facebook = 0, $page = 0, $status = Product::STATUS_ACTIVE) {              
        //echo StringUtil::replaceRepeatCharacter('baf---_---a', '-', '');exit;
        if (Yii::app()->user->isGuest && isset(Yii::app()->request->cookies['usercity_ck'])) {
            CityUtil::setSelectedCityId(Yii::app()->request->cookies['usercity_ck']->value);
        }
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
        } else if ($categoryModel != null) {
            $this->pageTitle = Yii::app()->name . ' - Danh mục ' . $categoryModel->name;
        } else if ($facebook) {
            $this->pageTitle = Yii::app()->name . ' - Sản phẩm được đăng từ bạn bè của bạn';
        }


        $city = CityUtil::getSelectedCityId();
        $empty = true;
        $nextPageLink = false;
        $productList = array();
        $requiredFacebookLogin = false;
        $numFound = 0;
        $locationAddress = null;
        $locationCity = null;
        if ($facebook && !FacebookUtil::getInstance()->doUserHaveEnoughUploadPermission()) {
            $requiredFacebookLogin = true;
        } else {
            $solrAdapter = new SolrSearchAdapter();
            $solrAdapter->setSortType(SolrSortTypeUtil::getInstance()->getCurrentSortType());
            $solrAdapter->categoryId = $category;
            $solrAdapter->cityId = $city;
            $solrAdapter->page = $page;
            $solrAdapter->pageSize = 12;
            $solrAdapter->country = Yii::app()->country->getId();
            $solrAdapter->keyword = $keyword;
            $solrAdapter->status = $status;
            $solrAdapter->facebookFriend = $facebook;


            if ($solrAdapter->getSortType() == SolrSearchAdapter::TYPE_LOCATION) {
                $lat = UserLocationUtil::getInstance()->lat;
                $lng = UserLocationUtil::getInstance()->lng;
                $locationAddress = UserLocationUtil::getInstance()->address;
                $locationCity = UserLocationUtil::getInstance()->city;
                if ($lat != null && $lng != null) {
                    $solrAdapter->setLocation($lat, $lng);
                }
            }
            Yii::beginProfile('search');
            $resultSet = $solrAdapter->search();
            Yii::endProfile('search');

            $productList = $resultSet->productList;
            $numFound = $resultSet->numFound;
            $empty = $page * $solrAdapter->pageSize > $resultSet->numFound;
            $params = array(
                'keyword' => $keyword,
                'category' => $category,
                'facebook' => $facebook,
                'page' => $page + 2,
                'status' => $status
            );
            $nextPageUrl = $this->createNextUrl($params);
            $nextPageLink = CHtml::link('Next', $nextPageUrl, array(
                        'class' => 'nextPageLink',
            ));
        }
        $canShowRequireVerifyEmail = false;
        if(Yii::app()->user->isGuest == false && false == UserEmail::isEmailVerified(Yii::app()->user->model->email)){
            $canShowRequireVerifyEmail = true;
        }
        if (!Yii::app()->request->isAjaxRequest) {
            $this->render('index', array(
                'numFound' => $numFound,
                'canShowRequireVerifyEmail'=>$canShowRequireVerifyEmail,
                'productList' => $productList,
                'nextPageLink' => $nextPageLink,
                'keyword' => $keyword,
                'categoryModel' => $categoryModel,
                'category' => $category,
                'status' => $status,
                'facebook' => $facebook,
                'empty' => $empty,
                'locationAddress' => $locationAddress,
                'locationCity' => $locationCity,
                'city' => $city,
                'requiredFacebookLogin' => $requiredFacebookLogin
            ));
        } else {
            $html = '';
            if ($empty == false) {
                foreach ($productList as $product) {
                    $html.=$product->renderHtml('home-', false);
                }
                $this->renderAjaxResult(true, array(
                    'items' => $html,
                    'count' => count($productList)
                ));
            } else {
                $this->renderAjaxResult(true, array(
                    'count' => 0
                ));
            }
        }
    }

    protected function createNextUrl($params) {
        return Yii::app()->controller->createAbsoluteUrl('/site/index', $params);
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
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
    public function actionContact() {
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
    public function actionLogin() {
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
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionDetail() {
        $this->render('detail_view');
    }

    public function actionTerms() {
        if (Yii::app()->language == 'en')
            $this->render('pages/term_en');
        else
            $this->render('pages/term');
    }

    public function actionIntroduction() {
        $this->layout = '//layouts/noMenu';
        if (Yii::app()->language == 'en')
            $this->render('pages/intro_en');
        else
            $this->render('pages/intro');
    }

    public function actionEnLang() {
        $currentUrl = Yii::app()->request->urlReferrer;
        UserRegistry::getInstance()->setValue('itake_lang', 'en');
        $this->redirect($currentUrl);
    }

    public function actionViLang() {
        $currentUrl = Yii::app()->request->urlReferrer;
        UserRegistry::getInstance()->setValue('itake_lang', 'vi');
        $this->redirect($currentUrl);
    }

    public function actionLanding() {
        $this->layout = '//layouts/noMenu';        
        $listProducts = Product::model()->findAll(array('limit'=>28,'order'=>'create_date DESC'));
        if (Yii::app()->language == 'en')
            $this->render('landing',array('listProducts'=>$listProducts));
        else
            $this->render('landing_vi',array('listProducts'=>$listProducts));
    }

    public function actionFAQ() {
        //waiting for KHOA
    }

    public function actionLocationDialog() {
        $location = new LocationForm();
        $location->city = CityUtil::getSelectedCityId();
        $lat = UserLocationUtil::getInstance()->lat;
        $lng = UserLocationUtil::getInstance()->lng;
        if ($lat && $lng) {
            $url = $this->createUrl('/site/sortType', array('type' => SolrSearchAdapter::TYPE_LOCATION));
            $this->renderAjaxResult(true, array(
                'alreadyHaveLocation' => true,
                'url' => $url
            ));
        } else {
            $html = $this->renderPartial('/site/partial/selectLocationDialog', array(
                'location' => $location
                    ), true, false);
            $this->renderAjaxResult(true, array(
                'html' => $html,
                'alreadyHaveLocation' => false
            ));
        }
    }

    public function actionSaveLocation() {
        $lat = Yii::app()->request->getPost('lat');
        $lng = Yii::app()->request->getPost('lng');
        $address = Yii::app()->request->getPost('address');
        $city = Yii::app()->request->getPost('city');
        if ($lat != null && $lng != null) {
            UserLocationUtil::getInstance()->address = $address;
            UserLocationUtil::getInstance()->lat = $lat;
            UserLocationUtil::getInstance()->lng = $lng;
            UserLocationUtil::getInstance()->city = $city;
            $url = $this->createUrl('/site/sortType', array('type' => SolrSearchAdapter::TYPE_LOCATION));
            $this->renderAjaxResult(true, array('url' => $url));
        } else {
            $this->renderAjaxResult(false, 'Invalid data');
        }
    }

    public function actionRemoveLocation() {
        UserLocationUtil::getInstance()->removeLocation();
        $this->redirect($this->createUrl('/site/sortType', array(
                    'type' => SolrSearchAdapter::TYPE_CREATE_DATE
        )));
    }

}