<?php

class MobileController extends Controller{   
  
    protected function getPayloadData()
    {
        return $_REQUEST;
    }
    
    protected function logRequest(){
     
        $log = serialize($_REQUEST);
        Yii::log(CVarDumper::dumpAsString($log),  CLogger::LEVEL_INFO,'mobile');
    
    }
}