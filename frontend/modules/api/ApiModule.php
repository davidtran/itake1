<?php

class ApiModule extends CWebModule
{
	public function init()
	{		
		$this->setImport(array(
			'api.models.*',
			'api.utils.*',  
            'api.components.*',
		));
        $apiUser = new ApiUser();
        Yii::app()->setComponent('user', $apiUser);
        AutoUserApiLogin::autoLogin();
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
