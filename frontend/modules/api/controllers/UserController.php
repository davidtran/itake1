<?php

class UserController extends MobileController
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
                $this->renderAjaxResult(true,'Register success');
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
    
    protected function getPayloadData()
    {
        return $_REQUEST;
    }

    public function actionFacebookLogin()
    {
        $profile = $this->getPayloadData();   
        if (isset($profile['email']) && isset($profile['access_token']) && isset($profile['id']))
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
            FacebookUtil::getInstance()->saveUserToken($user->id, $profile['access_token']);
                  
            if ($user->save())
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
            }else{
                $this->renderAjaxResult(false,array(
                    'errors'=>$user->errors
                ));
            }          
        }
        $this->renderAjaxResult(false,'Invalid parameter');
       
    }

}
