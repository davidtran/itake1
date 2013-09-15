<?php

class AdminWebUser extends CWebUser{
    public function checkAccess($operation, $params = array(), $allowCaching = true)
    {
        $rs = parent::checkAccess($operation, $params, $allowCaching);
        if( ! $rs){
            throw new CHttpException(403,'You do not have permission for this section');
        }
        return $rs;
    }
}