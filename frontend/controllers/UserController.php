<?php

class UserController extends Controller
{

    protected $_user;

    public function behaviors()
    {
        return array(
            'seo' => array('class' => 'frontend.extensions.seo.components.SeoControllerBehavior')
        );
    }

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

    public function actionLogin($returnUrl = null)
    {
        if (Yii::app()->user->isGuest == false) {
            //$this->redirect('/site/index');
        }
        $loginForm = new LoginForm();
        if (isset($_POST['LoginForm'])) {
            $loginForm->username = $_POST['LoginForm']['username'];
            $loginForm->password = $_POST['LoginForm']['password'];
            if ($loginForm->validate() && $loginForm->login()) {
                //a login user by email can still be a facebook user
               
                    
                    if ($this->hasReturnUrl()) {
                        $this->redirectToReturnUrl();
                    }
                    else {
                        $siteUrl = $this->createUrl('/site/index');
                        $this->redirect($siteUrl);
                    }
                
                
            }
            $loginForm->password = '';
        }
        $this->render('login', array(
            'model' => $loginForm,
            'returnUrl' => $this->returnUrl,
        ));
    }

    public function actionFacebookLogin()
    {
        $this->render('facebookLogin', array(
            'returnUrl' => $this->returnUrl,
        ));
    }

    public function actionFbProfile()
    {
        
    }

    public function actionBindAccountFacebook()
    {
        if (isset($_GET['code'])) {
            try {
                $profile = Yii::app()->facebook->api('/me');
                if (Yii::app()->user->isGuest == false) {
                    $currentUser = Yii::app()->user->model;
                    $currentUser->fbId = $profile['id'];
                    $currentUser->save();
                    Yii::app()->controller->redirect(Yii::app()->controller->getReturnUrl());
                }
            }
            catch (FacebookApiException $e) {
                // in here you can look at the Exception $e, and determine if it's an expired
                // access token error, and if it is, you can redirect your user somewhere to
                // re-authenticate if you want - either by redirecting them to the login page,
                // or by showing a Flash message with the JavaScript Login button, etc
                //echo $e->getMessage();
                Yii::app()->controller->redirect(FacebookUtil::getInstance()->makeFacebookLoginUrlNew(Yii::app()->controller->getReturnUrl()));
            }
        }
    }

    public function actionRegister()
    {       
        if (isset($_GET['code'])) {
            try {
                $accessToken = Yii::app()->facebook->getAccessToken();
                $profile = Yii::app()->facebook->api('/me'); 
                
                if (isset($profile['email'])) {
                    $newFacebookuser = false;
                    if (Yii::app()->user->isGuest == false) {
                        $user = Yii::app()->user->getModel();                        
                    }
                    else {
                        $user = UserUtil::getUserByEmail($profile['email']);
                    }
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
                        Yii::app()->session['LastFbId'] = $profile['id'];
                        $user->fbId = $profile['id'];
                        $user->isFbUser = 1;
                        $newFacebookuser = true;
                    }
                    else {
                        
                        $user->fbId = $profile['id'];
                        $user->isFbUser = 1;
                    }

                    $user->save();
                    FacebookUtil::getInstance()->saveUserToken($user->id, $accessToken);
                    FacebookUtil::getInstance()->setExtendedAccessToken();
                    Yii::app()->session['CheckedAccessToken'] = true;
                    $loginForm = new FacebookLoginForm();
                    $loginForm->username = $user->email;
                    $loginForm->validate();
                    $loginForm->login();
                    Yii::app()->user->setFlash('success','Kết nối với Facebook thành công.');
                    $siteUrl = $this->createUrl('/site',array('id'=>$user->id,'newUser'=>true));                    
                    if($newFacebookuser){
                        $this->redirect($siteUrl);
                    }else{
                        if($this->hasReturnUrl()){
                            $this->redirectToReturnUrl();                        
                        }
                    }                    
                }
            }
            catch (FacebookApiException $e) {               
                Yii::app()->user->setFlash('error','Kết nối với Facebook bị lỗi, vui lòng thử lại sau.');
                $this->redirect($this->createUrl('/user/login'));
            }
        }
        $user = new User('register');
        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            if (isset(Yii::app()->session['LastFbId'])) {
                $user->fbId = Yii::app()->session['LastFbId'];
            }
            $password = $_POST['User']['password'];
            $user->setScenario('register');
            if ($user->save()) {
                Yii::app()->user->setFlash('success', 'Chúc mừng bạn đã đăng ký thành công');
                $loginForm = new LoginForm();
                $loginForm->username = $user->email;
                $loginForm->password = $password;
                $loginForm->validate();
                $loginForm->login();
                $siteUrl = $this->createUrl('/site');
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
        if($user->phone==NULL && $user->address!=NULl ){
            $phone = $user->address[0]->phone;
            Yii::app()->db->createCommand()->update('mp_user', array(
                'phone'=>$phone,
            ), 'id=:id', array(':id'=>$id));
        }
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
        $dataProvider = $user->searchProduct(null, 10, $page);
        $productList = $dataProvider->getData();
        $empty = $page >= $dataProvider->pagination->pageCount;        
        if (!$empty) {
            $html = '';
            foreach($productList as $product){
                $html.=$product->renderHtml('',true);
            }
            $this->renderAjaxResult(true,array(
                'items'=>$html,
                'count'=>count($productList)
            ));
            Yii::app()->end();
        }else{
            $this->renderAjaxResult(true,array(
                'items'=>'',
                'count'=>0
            ));
        }
    }

    protected function loadUser($id)
    {
        if ($this->_user == null) {
            $this->_user = User::model()->findByPk($id);
            if ($this->_user == null) {
                throw new CHttpException(404, 'User not found');
            }
        }
        return $this->_user;
    }

    public function actionUploadProfileImage()
    {
        if (Yii::app()->user->isGuest == false) {
            $user = Yii::app()->user->model;
            $result = UserUtil::uploadProfile($user);
            if ($result) {
                $this->renderAjaxResult(true, Yii::app()->baseUrl . '/' . $user->image);
            }
            $this->renderAjaxResult(false, array('error' => $user->getErrors()));
        }
    }

    public function actionUploadBannerImage()
    {
        if (Yii::app()->user->isGuest == false) {
            $user = Yii::app()->user->model;
            if (UserUtil::uploadBanner($user)) {
                $this->renderAjaxResult(true, Yii::app()->baseUrl . '/' . $user->getBanner());
            }
            else {
                $this->renderAjaxResult(false, array('errors' => $user->getError('banner')));
            }
        }
    }

    public function actionForgetPassword()
    {
        if (Yii::app()->user->isGuest == false) {
            $this->redirect('/site/index');
        }
        $model = new ForgetPassword();
        if (isset($_POST['ForgetPassword'])) {

            $model->attributes = $_POST['ForgetPassword'];
            if ($model->resolveForgetPassword()) {
                $this->render('forgetPassword', array(
                    'model' => $model,
                    'sent' => 1
                ));
            }
            else {
                $this->render('forgetPassword', array(
                    'model' => $model,
                    'sent' => -1
                ));
            }
        }
        else {
            $this->render('forgetPassword', array(
                'model' => $model,
                'sent' => 0
            ));
        }
    }

    public function actionUpdateContactInfo()
    {
        if (Yii::app()->user->isGuest == false) {
            $user = Yii::app()->user->model;
            if (isset($_POST['phone']) && isset($_POST['locationText']) && $_POST['lon'] && $_POST['lat'] && $_POST['city']) {
                $user->phone = $_POST['phone'];
                $user->locationText = $_POST['locationText'];
                $user->lon = $_POST['lon'];
                $user->lat = $_POST['lat'];
                $user->city = $_POST['city'];
                if ($user->save()) {
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
        if (Yii::app()->user->isGuest == false) {
            $model = new ChangePasswordForm();
            $model->user_id = Yii::app()->user->getId();
            if (isset($_POST['ChangePasswordForm'])) {
                $model->attributes = $_POST['ChangePasswordForm'];

                if ($model->changePassword()) {

                    UserRegistry::getInstance()->setValue('HaveChangedPassword', true);
                    Yii::app()->user->setFlash('success', 'Đổi mật khẩu thành công');
                }
                else {
                    Yii::app()->user->setFlash('error', 'Không thể đổi mật khẩu, vui lòng kiểm tra lại mật khẩu cũ và mật khẩu mới của bạn.');
                }
                $model->password = null;
                $model->retypePassword = null;
                $model->oldPassword = null;
            }
            //$model->unsetAttributes();

            $this->render('changePassword', array(
                'model' => $model,
            ));
        }
        else {
            $this->redirect(array('login'));
        }
    }

    public function actionChat()
    {
        $this->render('chat');
    }

    public function actionUpdate(){
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('User');
        $es->update();
    }
    
    public function actionChangeSlug(){
        $slug = Yii::app()->request->getPost("slug");
        if(trim($slug)!='' && Yii::app()->user->isGuest == false){
            $rs = Yii::app()->user->model->changeSlug($slug);
            if($rs){
                $this->renderAjaxResult(true,'Thay đổi địa chỉ thành công');
            }else{
                $this->renderAjaxResult(false,'Địa chỉ này đã được sử dụng');
            }
        }
        $this->renderAjaxResult(false,'Không thể thay đổi địa chỉ');
    }
    
    public function actionEditProfile($id,$newUser = false){
        if( Yii::app()->user->isGuest == false && Yii::app()->user->getId() == $id){
            $canChangeSlug = false;
            $model = Yii::app()->user->model;
            $model->scenario = 'editProfile';
            if(isset($_POST['User']))
            {
                $model->allowUpdateWithoutCaptcha = true;
                $model->attributes=$_POST['User'];
                if($model->save()){
                    if($this->hasReturnUrl()){
                        $this->redirectToReturnUrl();                        
                    }else{
                        $this->redirect($this->createUrl('profile',array('id' => $model->id,'username'=>$model->username)));
                    }
                    
                }
                 else
                {
                    $this->render('editProfile', array(
                        'model'=>$model,
                        'canChangeSlug'=>false,
                        'newUser'=>$newUser
                    ));
                }
            }
            else
            {
                $canChangeSlug = $model->canChangeSlug();
                $defaultSlug = null;
                if($canChangeSlug){
                    $slugMaker = new SlugMakerUtil();
                    $defaultSlug = $slugMaker->makeDefaultSlug($model->username);
                }
                $this->render('editProfile', array(''
                    . 'model' => $model,
                      'canChangeSlug' => $canChangeSlug,
                      'defaultSlug' => $defaultSlug,
                      'newUser'=>$newUser

                ));
            }
        }else{
            $this->redirect($this->createUrl('/site'));
        }
        
        
    }
    
    public function actionClearFacebookSession(){
        $nextUrl = Yii::app()->session->get('FacebookLoginUrl');
        $this->redirect($nextUrl);
        Yii::app()->end();
    }

    public function actionVerifyEmail($email,$code){
        $verifyResult = UserEmail::verifyEmailAndCode($email, $code);        
        //if user is login: redirect to homepage
        //if not: redirect to login page
        //set flash message
        $this->render('verifyEmail',array(
            'verifyResult'=>$verifyResult
        ));
        
     
        
    }
    
    public function actionSendVerifyEmail(){
        if(Yii::app()->user->isGuest ){
            throw new CHttpException(500,'Vui lòng đăng nhập trước khi sử dụng tính năng này');
        }
        $user = Yii::app()->user->model;
        if(true == UserEmail::isEmailVerified($user->email)){
            Yii::app()->user->setFlash('danger','Địa chỉ email của bạn đã được xác thực.');
            $this->redirect($this->createUrl('/site'));
        }
        
        $model = new ConfirmEmailForm();
        $model->user_id = $user->id;
        $success = false;
        if(isset($_POST['ConfirmEmailForm'])){
            $model->attributes = $_POST['ConfirmEmailForm'];
            $success = $model->sendConfirmEmail();
        }        
                
        $this->render('sendVerifyEmail',array(
            'success'=>$success,
            'user'=>$user,
            'model'=>$model
        ));
    }
}