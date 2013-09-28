<?php

class FacebookAccessCheckerFilter extends CFilter
{

    public function preFilter($filterChain)
    {
        Yii::beginProfile('FacebookFilter');
        if (Yii::app()->user->isFacebookUser && !Yii::app()->request->isAjaxRequest && !$this->isSaved())
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
                    //Yii::app()->user->logout();
                    Yii::app()->session['CheckedFacebookAccessToken'] = false;                    
                    Yii::app()->controller->redirect('/site/index');
                }
            }
            catch (Exception $e)
            {
                //Yii::app()->user->logout();
                Yii::app()->session['CheckedFacebookAccessToken'] = false;                    
                Yii::app()->controller->redirect('/market');
            }
        }
        Yii::endProfile('FacebookFilter');
         
        $filterChain->run();
    }

    protected function isSaved()
    {
        if (Yii::app()->session->get('CheckedFacebookAccessToken', null) !== null)
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