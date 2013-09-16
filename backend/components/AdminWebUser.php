<?php

class AdminWebUser extends CWebUser{
    private $_model;

    public function getModel()
    {
        if ($this->_model == null)
        {
            $this->_model = User::model()->findByPk($this->getId());
        }

        return $this->_model;
    }
    public function checkAccess($operation, $params = array(), $allowCaching = true)
    {
        $rs = parent::checkAccess($operation, $params, $allowCaching);
        if( ! $rs){
            throw new CHttpException(403,'You do not have permission for this section');
        }
        return $rs;
    }
}