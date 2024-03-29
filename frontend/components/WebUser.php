<?php

class WebUser extends CWebUser
{

    private $_model;

    public function getModel()
    {
        if ($this->_model == null) {
            $this->_model = User::model()->findByPk($this->getId());
        }

        return $this->_model;
    }

    public function getIsFacebookUser()
    {
        if ($this->_model != null && $this->_model->fbId != null && trim($this->_model->fbId) != '') {
            return true;
        }
        return false;
    }

    public function init()
    {
        //check for login
        if ($this->model != null) {
            if (Yii::app()->clientScript != null) {
                $loginUser = json_encode($this->model->getData());
                Yii::app()->clientScript->registerScript('LoginUserData', "var loginUser = $loginUser;", CClientScript::POS_HEAD);
            }
        }
        return parent::init();
    }

    public function logout($destroySession = true)
    {
        Yii::app()->session->remove('FilterFriendList');
        return parent::logout($destroySession);
    }

}