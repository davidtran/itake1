<?php

class FacebookAccessCheckerFilter extends CFilter
{

    public function preFilter($filterChain)
    {
        if ($this->isCheckedRoute() && Yii::app()->user->isFacebookUser)
        {

            try
            {
                $fbUtil = FacebookUtil::getInstance();
                $lastToken = $fbUtil->getSavedUserToken(Yii::app()->user->getId());
                if ($lastToken != null)
                {

                    $fbUtil->setAccessToken($lastToken);
                    
                }
                else
                {
                    $this->redirectToFacebookLoginPage();
                }
                //redirect
            }
            catch (Exception $e)
            {
                $this->redirectToFacebookLoginPage();
            }
        }

        $filterChain->run();
    }

    protected function redirectToFacebookLoginPage()
    {
        $currentUrl = UrlUtil::getAbsoluteUrl();
        Yii::app()->controller->setRedirectUrl($currentUrl);
        $loginUrl = UserUtil::makeFacebookLoginUrl();       
        Yii::app()->controller->redirect($loginUrl);
    }

    protected function isCheckedRoute()
    {
        $checkList = array(
            'site/index',
            'video/view',
            'site/category',
            'site/home',
        );
        $route = Yii::app()->controller->route;
        if (in_array($route, $checkList, true))
        {
            return true;
        }
        return false;
    }

}