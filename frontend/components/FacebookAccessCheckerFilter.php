<?php

class FacebookAccessCheckerFilter extends CFilter
{

    public function preFilter($filterChain)
    {
        if ($this->isCheckedRoute() 
                && Yii::app()->user->isFacebookUser
                &&  ! $this->isSaved())
        {

            try
            {
                $fbUtil = FacebookUtil::getInstance();
                $accessToken = Yii::app()->facebook->getAccessToken();
                $fbUtil->setAccessToken($accessToken);                
                Yii::app()->session['CheckedFacebookAccessToken'] = true;          
            }
            catch (Exception $e)
            {
                $this->redirectToFacebookLoginPage();
            }
        }          
        $filterChain->run();
    }
    
    
    
    protected function isSaved(){
        if(Yii::app()->session->get('CheckedFacebookAccessToken',false)!==false){
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

    protected function isCheckedRoute()
    {
        $checkList = array(
            'site/index',
            'upload/index',            
        );
        $route = Yii::app()->controller->route;        
        if (in_array($route, $checkList, true))
        {
            return true;
        }
        return false;
    }

}