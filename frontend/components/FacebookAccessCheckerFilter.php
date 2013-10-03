<?php

class FacebookAccessCheckerFilter extends CFilter
{

    public function preFilter($filterChain)
    {
        unset($_SESSION['Registry_FacebookAccessToken']);
        unset($_SESSION['CheckedAccessToken']);
        Yii::beginProfile('FacebookFilter');
        //only check if User is connected with Facebook and it's not a ajax request                  
        if (Yii::app()->user->isFacebookUser && !Yii::app()->request->isAjaxRequest) {
            $fbUtil = FacebookUtil::getInstance();
            $userId = Yii::app()->user->getId();
            if (Yii::app()->session->get('CheckedAccessToken', null) == null) {
                Yii::app()->session->add('CheckedAccessToken', true);

                $lastAccessToken = $fbUtil->getSavedUserToken($userId);
                try {
                    $fbUtil->setAccessToken($lastAccessToken, true);
                    Yii::app()->session->add('FacebookAccessToken', $lastAccessToken);
                    Yii::app()->session->add('FacebookConnectFailed',false);
                }
                catch (Exception $e) {
                    Yii::app()->session->add('FacebookConnectFailed',true);
                    Yii::app()->user->logout();
                }
            }
            if (false !== $accessToken = Yii::app()->session->get('FacebookAccessToken', false)) {
                //dont check for valid, just silent                
                $fbUtil->setAccessToken($accessToken, false);
            }
            else {
                //at here, we fail to check access token, use the old token anyway.
                $accessToken = $fbUtil->getSavedUserToken($userId);
                $fbUtil->setAccessToken($accessToken, false);
            }
        }
        Yii::endProfile('FacebookFilter');
        $filterChain->run();
    }

    protected function isSaved()
    {
        if (Yii::app()->session->get('CheckedFacebookAccessToken', null) !== null) {
            return true;
        }
        return false;
    }

    protected function redirectToFacebookLoginPage()
    {
        $currentUrl = UrlUtil::getAbsoluteUrl();
        Yii::app()->controller->setReturnUrl($currentUrl);

        $loginUrl = FacebookUtil::makeFacebookLoginUrl();
        Yii::app()->controller->redirect($loginUrl);
    }

}

/**
 * Old code at here
 */
//  if (Yii::app()->user->isFacebookUser && !Yii::app()->request->isAjaxRequest) {
//            //we only check the token once
//            $fbUtil = FacebookUtil::getInstance();
//            $userId = Yii::app()->user->getId();
//            if (Yii::app()->session->get('CheckedAccessToken', false) == false) {                
//                //set the flag on, so we won't check it again
//                Yii::app()->session->add('CheckedAccessToken', true);
//                //just logout so they have to login again by facebook, facebook is too buggy
//                Yii::app()->user->logout();                                                               
//            }
//            
//            if (false !== $accessToken = Yii::app()->session->get('FacebookAccessToken', false)) {
//                //dont check for valid, just silent                
//                $fbUtil->setAccessToken($accessToken, false);
//            }
//            else {
//                //at here, we fail to check access token, use the old token anyway.
//                $accessToken = $fbUtil->getSavedUserToken($userId);
//                $fbUtil->setAccessToken($accessToken, false);
//            }