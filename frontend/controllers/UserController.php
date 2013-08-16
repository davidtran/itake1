<?php

class UserController extends Controller
{

    protected $_user;

    public function behaviors()
    {
        return array(
            'seo'=>array('class'=> 'frontend.extensions.seo.components.SeoControllerBehavior')
        );
    }
    
//    public function filters()
//    {
//        return array(
//            array('frontend.components.ForceHttpsFilter + login,register,changePassword,forgetPassword')
//        );
//    }
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => '0xFFFFFF',
                'transparent' => true,
                'testLimit' => 5
            )
        );
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('/site'));
    }

    public function actionLogin()
    {
        $loginForm = new LoginForm();            
        if (isset($_POST['LoginForm']))
        {
            $loginForm->username = $_POST['LoginForm']['username'];
            $loginForm->password = $_POST['LoginForm']['password'];
            if ($loginForm->validate() && $loginForm->login())
            {
                $siteUrl = $this->createUrl('/site/index');
                if($this->hasReturnUrl()){
                    $this->redirectToReturnUrl();
                }else{
                    $this->redirect($siteUrl);
                }                
            }
            $loginForm->password = '';
        }
        $this->render('login', array(
            'model' => $loginForm,
            'returnUrl'=>$this->returnUrl,
        ));
    }

    public function actionFbProfile()
    {
        
    }

    public function actionRegister()
    {
        $user = new User();
        if (isset($_GET['code']))
        {
            try
            {
                $profile = Yii::app()->facebook->api('/me');
                if (isset($profile['email']))
                {
                    $user = UserUtil::getUserByEmail($profile['email']);
                    if ($user == null)
                    {
                        $user = new User();
                        $user->email = $profile['email'];

                        $original = $profile['first_name'] . ' ' . $profile['last_name'];
                        $username = $original;
                        $increment = 1;
                        while (UserUtil::isUserNameExist($username))
                        {
                            $username = $original . '.' . $increment;
                            $increment++;
                        }
                        $user->username = $username;
                        //render login form/ redirect to returnUrl
                        FacebookUtil::getInstance()->saveUserToken($user->id, Yii::app()->facebook->getAccessToken());
                        Yii::app()->session['LastFbId'] = $profile['id'];
                        Yii::app()->user->setFlash('success', 'Kết nối với Facebook thành công. Bạn có thể tiếp tục hoàn tất đăng ký.');
                    }
                    else
                    {
                        if ($user->fbId == null)
                        {
                            $user->fbid = $profile['id'];
                        }
                        $user->isFbUser = 1;
                        $user->save();
                        $loginForm = new FacebookLoginForm();
                        $loginForm->username = $user->email;
                        $loginForm->validate();
                        $loginForm->login();
                        FacebookUtil::getInstance()->saveUserToken($user->id, Yii::app()->facebook->getAccessToken());
                        $siteUrl = $this->createUrl('/site/index');         
                        $this->redirect($siteUrl);                
                    }
                }
            }
            catch (FacebookApiException $e)
            {
                //do nothing
            }
        }        

        if (isset($_POST['User']))
        {
            $user->attributes = $_POST['User'];
            if (isset(Yii::app()->session['LastFbId']))
            {
                $user->fbId = Yii::app()->session['LastFbId'];
            }
            $password = $_POST['User']['password'];
            if ($user->save())
            {
                Yii::app()->user->setFlash('success', 'Chúc mừng bạn đã đăng ký thành công');
                $loginForm = new LoginForm();
                $loginForm->username = $user->email;
                $loginForm->password = $password;
                $loginForm->validate();
                $loginForm->login();
                $siteUrl = $this->createUrl('/site/index');         
                $this->redirect($siteUrl);                
            }
        }
        $user->password = '';
        $this->render('register', array(
            'user' => $user
        ));
    }

    public function actionProfile($id)
    {
        $user = $this->loadUser($id);
        //load product,sort by time
        $productDataProvider = $user->searchProduct(null, 20, 0);
        $this->render('profile', array(
            'productDataProvider' => $productDataProvider,
            'page' => 0,
            'category' => null,
            'user' => $user
        ));
    }

    public function actionUserProductList($userId, $page = 0)
    {
        $user = $this->loadUser($userId);
        $dataProvider = $user->searchProduct(null, 20, $page);
        $productList = $dataProvider->getData();
        $empty = $page >= $dataProvider->pagination->pageCount;
        if (!$empty)
        {
            echo $this->renderPartial('_userProductBoard', array(
                'user' => $user,
                'page' => $page,
                'productList' => $productList
            ));
            Yii::app()->end();
        }
    }

    protected function loadUser($id)
    {
        if ($this->_user == null)
        {
            $this->_user = User::model()->findByPk($id);
            if ($this->_user == null)
            {
                throw new CHttpException(404, 'User not found');
            }
        }
        return $this->_user;
    }

    public function actionUploadProfileImage()
    {
        if (Yii::app()->user->isGuest == false)
        {
            $user = Yii::app()->user->model;
            $result = UserUtil::uploadProfile($user);
            if ($result)
            {
                $this->renderAjaxResult(true, Yii::app()->baseUrl . '/' . $user->image);
            }
            $this->renderAjaxResult(false, array('error' => $user->getError('image')));
        }
    }

    public function actionUploadBannerImage()
    {
        if (Yii::app()->user->isGuest == false)
        {
            $user = Yii::app()->user->model;
            if (UserUtil::uploadBanner($user))
            {
                $this->renderAjaxResult(true, Yii::app()->baseUrl . '/' . $user->getBanner());
            }
            else
            {
                $this->renderAjaxResult(false, array('errors' => $user->getError('banner')));
            }
        }
    }

    public function actionForgetPassword()
    {
        $model = new ForgetPassword();
        if (isset($_POST['ForgetPassword']))
        {

            $model->attributes = $_POST['ForgetPassword'];
            if ($model->resolveForgetPassword())
            {
                $this->render('forgetPassword', array(
                    'model' => $model,
                    'sent' => true
                ));
                Yii::app()->end();
            }
        }
        $this->render('forgetPassword', array(
            'model' => $model
        ));
    }

    public function actionUpdateContactInfo()
    {
        if (Yii::app()->user->isGuest == false)
        {
            $user = Yii::app()->user->model;
            if (isset($_POST['phone']) && isset($_POST['locationText']) && $_POST['lon'] && $_POST['lat'] && $_POST['city'])
            {
                $user->phone = $_POST['phone'];
                $user->locationText = $_POST['locationText'];
                $user->lon = $_POST['lon'];
                $user->lat = $_POST['lat'];
                $user->city = $_POST['city'];
                if ($user->save())
                {
                    echo 'save success';
                }
                else
                    echo 'save fail';
            }
            else
                echo 'save fail';
        }
    }
    
    public function actionChangePassword()
    {
        $this->canonical = $this->createAbsoluteUrl('/user/changePassword');
        if (Yii::app()->user->isGuest == false)
        {
            $model = new ChangePasswordForm();
            $model->user_id = Yii::app()->user->getId();
            if (isset($_POST['ChangePasswordForm']))
            {            
                $model->attributes = $_POST['ChangePasswordForm'];
                if ($model->changePassword())
                {
                    $model->password         = null;
                    $model->retypePassword  = null;
                    $model->oldPassword     = null;
                    Yii::app()->user->setFlash('success', 'Đổi mật khẩu thành công');
                }
                else
                {
                    Yii::app()->user->setFlash('error', 'Không thể đổi mật khẩu, vui lòng kiểm tra lại mật khẩu cũ và mật khẩu mới của bạn.');
                }
            }
            $model->unsetAttributes();
            $this->render('changePassword', array(
                'model' => $model
            ));
        }
        else
        {
            $this->redirect(array('login'));
        }
    }
        

}