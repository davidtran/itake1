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
        
        if(isset($_REQUEST['sessionID'])){
            $newSessionId = $_REQUEST['sessionID'];
            $session = &Yii::app()->session;
            if ($session->sessionID !== $newSessionId)
			{
				// Keep track of whether the session was already started or not
				$wasStarted = $session->getIsStarted();
				if ($wasStarted)
				{
					// Can't change the session ID while the session is open
					$session->close();
				}

				// Change the current session ID
				$session->sessionID = $newSessionId;

				if ($wasStarted)
				{
					// We should open the session again after closing it
					$session->open();
				}
			}
        }
        
//        var_dump($_SESSION);
//        echo Yii::app()->session->sessionID;
//        $apiUser = new ApiUser();
//        Yii::app()->setComponent('user', $apiUser);
//        ApiUser::checkTokenAndLogin();
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
