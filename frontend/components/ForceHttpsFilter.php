<?php

class ForceHttpsFilter extends CFilter{
    public function preFilter($filterChain)
    {
        if( Yii::app()->request->isSecureConnection == false){
            $url = UrlUtil::getAbsoluteUrl();
            $url = substr($url,4);
            $httpsUrl = 'https'.$url;
     //       Yii::app()->controller->redirect($httpsUrl);
        }
        $filterChain->run();
    }
}