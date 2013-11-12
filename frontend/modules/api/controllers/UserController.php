<?php

class UserController extends MobileController {

    public function filters() {
        return array(
            array(
                'CheckTokenFilter + detail'
            ),
            
        );
    }
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->renderAjaxResult(true);
    }

    public function actionRegister() {
        $data = $this->getPayloadData();
        $user = new User();
        if (isset($_POST)) {
            $user->email = $_POST['email'];            
            $password = $_POST['User']['password'];
            $user->password = $_POST['password'];
            //$user->setScenario('register');
            if ($user->save()) {
                Yii::app()->user->setFlash('success', 'Chúc mừng bạn đã đăng ký thành công');
                $loginForm = new LoginForm();
                $loginForm->username = $user->email;
                $loginForm->password = $password;
                $loginForm->validate();
                if($loginForm->login()){
                    $this->renderAjaxResult(true);
                }else{
                    $this->renderAjaxResult(false,array(
                        'errors'=>$loginForm->errors
                    ));
                }                
            }else{
                $this->renderAjaxResult(false,array(
                    'errors'=>$user->errors
                ));
            }
        }
        $this->renderAjaxResult(false,'Invalid parameter');
    }

    public function actionLogin() {
        $data = $this->getPayloadData();
        $login = new LoginForm();
        if (isset($data['email']) && isset($data['password'])) {
            $login->username = $data['email'];
            $login->password = $data['password'];

            if ($login->login()) {
                $user = UserUtil::getUserByEmail($data['email']);
                if ($user != null) {
                    $token = TokenUtil::createTokenModel($user->id);
                    if ($token->save()) {
                        $this->renderAjaxResult(true, array(
                            'id' => $user->id,
                            'token' => $token->token
                        ));
                    } else {
                        $this->renderAjaxResult(false, array(
                            'errors' => $token->errors
                        ));
                    }
                }
            } else {
                $this->renderAjaxResult(false, 'Can not login');
            }
        } else {
            $this->renderAjaxResult(false, 'Invalid parameter');
        }
    }

    protected function getPayloadData() {
        return $_REQUEST;
    }

    public function actionFacebookLogin() {
        $data = $this->getPayloadData();
        if (isset($data['access_token'])) {
            try {
                $profile = Yii::app()->facebook->api('/me?access_token=' . $data['access_token']);
               
                if (isset($profile['email'])) {
                    $user = UserUtil::getUserByEmail($profile['email']);
                    if ($user == null) {
                        $user = new User();
                        $user->email = $profile['email'];
                        $user->password = StringUtil::generateRandomString(25);
                        $original = $profile['first_name'] . ' ' . $profile['last_name'];
                        $username = $original;
                        $increment = 1;
                        while (UserUtil::isUserNameExist($username)) {
                            $username = $original . '.' . $increment;
                            $increment++;
                        }
                        $user->username = $username;
                        //render login form/ redirect to returnUrl
                        //  FacebookUtil::getInstance()->saveUserToken($user->id, Yii::app()->facebook->getAccessToken());
                        Yii::app()->session['LastFbId'] = $profile['id'];
                        $user->fbId = $profile['id'];
                        $user->isFbUser = 1;
                    } else {
                        $user->fbId = $profile['id'];
                        $user->isFbUser = 1;
                    }
                    //$user->allowUpdateWithoutCaptcha = true;
                    if ($user->save()) {
                        FacebookUtil::getInstance()->saveUserToken($user->id, Yii::app()->facebook->getAccessToken());
                        FacebookUtil::getInstance()->setExtendedAccessToken();
                        $loginForm = new FacebookLoginForm();
                        $loginForm->username = $user->email;
                        $loginForm->validate();

                        $token = TokenUtil::createTokenModel($user->id);
                        if ($token->save()) {
                            $this->renderAjaxResult(true, array(
                                'id' => $user->id,
                                'token' => $token->token
                            ));
                        } else {
                            $this->renderAjaxResult(false, array(
                                'errors' => $token->errors
                            ));
                        }
                    }else{
                        var_dump($user->errors);
                    }
                }
            } catch (FacebookApiException $e) {
                $this->renderAjaxResult(false,'Error connect to Facebook');                
            }
        }
        $this->renderAjaxResult(false,'Invalid parameter');
    }
    public function actionProfile($id){
        $user = User::model()->findByPK($id);
        $productdata = $user->searchProduct(null, 20, 0);
        $productlist = $productdata->getData();
        $list = array();
        foreach ($productlist as $product) {
            array_push($list, JsonRenderAdapter::renderProduct($product));
        }
        $this->renderAjaxResult(true,array(
                'list'=>$list,
                'user'=> JsonRenderAdapter::renderUser($user) 
                ));
    }
}
