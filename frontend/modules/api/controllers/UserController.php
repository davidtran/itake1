<?php

class UserController extends Controller
{

    public function filters()
    {
        return array(
            array(
                'CheckTokenFilter + detail'
            )            
        );
    }     

    public function actionRegister()
    {
        $data = $this->getPayloadData();
        $user = new User();
        if (isset($data['email']) && isset($data['password']) && isset($data['username']))
        {
            $user->attributes = $data;
            if ($user->save())
            {
                $this->renderAjaxResult(true,'Register suuccess');
            }
            else
            {
                $this->renderAjaxResult(
                    false, array(
                        'errors' => $user->getErrors()
                    )
                );
            }
        }
        else
        {
            $this->renderAjaxResult(false, 'Invalid parameter');
        }
    }

    public function actionLogin()
    {
        $data = $this->getPayloadData();
        $login = new LoginForm();
        if (isset($data['email']) && isset($data['password']))
        {
            $login->username = $data['email'];
            $login->password = $data['password'];

            if ($login->login())
            {
                
                $user = UserUtil::getUserByEmail($data['email']);
                if($user!=null){
                    $token = TokenUtil::createTokenModel($user->id);
                    if($token->save()){
                        $this->renderAjaxResult(true, array(                            
                            'token' => $token->token
                        ));
                    }
                }else{
                    $this->renderAjaxResult(false,'Error while get login token');
                }
                
                
            }
            else
            {
                $this->renderAjaxResult(false, 'Can not login');
            }
        }
        else
        {
            $this->renderAjaxResult(false, 'Invalid parameter');
        }
    }
    
    public function actionDetail($userId){
        $user = User::model()->findByPk($userId);
        if($user!=null){
            $data = $user->attributes;
            unset($data['password']);
            unset($data['create_date']);
            unset($data['salt']);
            $this->renderAjaxResult(true,$data);
        }else{
            $this->renderAjaxResult(false,'Không tìm thấy người dùng');
        }
            
        
    }
    protected function getPayloadData()
    {
        return $_REQUEST;
    }

    public function actionFacebookLogin()
    {
        $profile = $this->getPayloadData();
        //check user exist
      

        if (isset($profile['email']))
        {
            $user = UserUtil::getUserByEmail($profile['email']);
            if ($user == null)
            {
                $user = new User();
                $user->email = $profile['email'];
                $user->fbprofile = serialize($profile);                
                $user->password = StringUtil::generateRandomString(20);
                
                $original = $profile['first_name'].' '.$profile['last_name'];
                $username = $original;
                $increment = 1;
                while (UserUtil::isUserNameExist($username))
                {
                    $username = $original . '.' . $increment;
                    $increment++;
                }
                $user->username = $username;                
            }
            $user->fbId = $profile['id'];
            $user->isFbUser = 1;     
            $user->save();      
            if ($user != null)
            {
                $token = TokenUtil::createTokenModel($user->id);
                if ($token->save())
                {
                    $this->renderAjaxResult(true, array(
                        'id' => $user->id,                     
                        'token' => $token->token
                    ));
                }
                else
                {
                    $this->renderAjaxResult(false, array(
                        'errors' => $token->errors
                    ));
                }
            }          
        }
        $this->renderAjaxResult(false);
       
    }

}
