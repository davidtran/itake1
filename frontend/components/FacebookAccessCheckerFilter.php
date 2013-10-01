<?php

class FacebookAccessCheckerFilter extends CFilter
{

    public function preFilter($filterChain)
    {
        Yii::beginProfile('FacebookFilter');
        //only check if User is connected with Facebook and it's not a ajax request
        if (Yii::app()->user->isFacebookUser && !Yii::app()->request->isAjaxRequest) {
            //we only check the token once
            $fbUtil = FacebookUtil::getInstance();
            $userId = Yii::app()->user->getId();
            if (Yii::app()->session->get('CheckedAccessToken', false) == false) {                
                $accessToken = $fbUtil->getSavedUserToken($userId);
                if ($accessToken != null) {
                    try {
                        //set the flag on, so we won't check it again
                        Yii::app()->session->add('CheckedAccessToken', true);
                        //set the access token and check it's valid. If it's not throw the exception
                        $fbUtil->setAccessToken($accessToken, true);
                        //now we store the access token in session
                        Yii::app()->session->add('FacebookAccessToken', $accessToken);
                    }
                    catch (Exception $e) {
                        //remember our flag, we only logout once
                        Yii::app()->user->logout();
                        Yii::app()->controller->redirect('/site/index');
                    }
                }
                //if we already have the access token, user it
            }
            else if (false !== $accessToken = Yii::app()->session->get('FacebookAccessToken', false)) {
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