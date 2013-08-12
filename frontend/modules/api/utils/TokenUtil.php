<?php

class TokenUtil
{

    public static function createTokenModel($user_id)
    {       
        $model = new LoginToken();
        $model->token = self::generateToken($user_id);
        $model->user_id = $user_id;
        $model->create_date = date('Y-m-d H:i:s');
        $model->ip = Yii::app()->request->getUserHostAddress();
        return $model;
    }

    public static function generateToken($user_id)
    {
        return md5(md5($user_id) . uniqid('secret'));
    }

    public static function loadToken()
    {

        if (isset($_POST['token']))
        {
            $token = TokenUtil::findTokenModel($_POST['token']);
            if ($token != null)
            {
                return $token;
            }
        }
        return false;
    }

    public static function findTokenModel($token)
    {
        $model = LoginToken::model()->find(array(
            'condition' => 'token=:token',
            'params' => array(
                'token' => $token,
                'order' => 'create_date desc'
            )
        ));
        if ($model != null)
        {
            $tokenTime = strtotime($model->create_date);
            $elapse = time() - $tokenTime;
            if ($elapse < 60 * 60 * 24)
            {
                return $model;
            }
        }
        return false;
    }

}

?>
