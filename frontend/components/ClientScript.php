<?php

class ClientScript extends CClientScript
{

    public function registerScriptFile($url, $position = null,$modify = true)
    {
        if($modify){
            $url = $this->makeIncrementUrl($url);
        }        
        return parent::registerScriptFile($url, $position);
    }

    public function registerCssFile($url, $media = '',$modify = true)
    {
        if($modify){
            $url = $this->makeIncrementUrl($url);
        }
        return parent::registerCssFile($url, $media);
    }

    protected function makeIncrementUrl($url)
    {
        if (isset(Yii::app()->params['clientScript.incrementNumber']) && Yii::app()->params['clientScript.incrementNumber'] !== false) {
            return $url . '?id=' . Yii::app()->params['clientScript.incrementNumber'];
        }
        return $url;
    }

}