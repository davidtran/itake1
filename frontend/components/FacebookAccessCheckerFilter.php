<?php

class FacebookAccessCheckerFilter extends CFilter
{

    public function preFilter($filterChain)
    {
        if (Yii::app()->user->isFacebookUser && !Yii::app()->request->isAjaxRequest)
        {             
            try
            {
          
                $userId = Yii::app()->user->getId();
                $fbUtil = FacebookUtil::getInstance();
                $accessToken = $fbUtil->getSavedUserToken($userId);                
                if ($accessToken != null)
                {
                    $fbUtil->setAccessToken($accessToken);                    
                    Yii::app()->session['CheckedFacebookAccessToken'] = true;                    
                }else{                    
                    Yii::app()->user->logout();
                    Yii::app()->controller->redirect('/market');
                }
            }
            catch (Exception $e)
            {
                Yii::app()->user->logout();
                Yii::app()->controller->redirect('/market');
            }
        }
         
        $filterChain->run();
    }

    protected function isSaved()
    {
        if (Yii::app()->session->get('CheckedFacebookAccessToken', false) !== false)
        {
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