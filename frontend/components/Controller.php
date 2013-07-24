<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    public $showHeader = true;

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $notShowUserMenu = false;

    public function init()
    {
        chdir(Yii::getPathOfAlias('www'));
        return parent::init();
    }

    public function renderJsonResult($success = false, $message = '')
    {
        assert('is_bool($success)');
        $message = Yii::app()->sanitizer->sanitize($message);
        $str = json_encode(array(
            'success' => $success,
            'msg' => $message
        ));

        if (isset($_REQUEST['callback']))
        {
            $callback = $_REQUEST['callback'];
            header('Content-Type: text/javascript');
            echo $callback . '(' . $str . ');';
        }
        else
        {
            header('Content-Type: application/x-json');
            echo json_encode($str);
        }
        Yii::app()->end();
    }

    public function renderJsonArray($array)
    {
        //$array = Yii::app()->sanitizer->sanitize($array);
        if (isset($_REQUEST['callback']))
        {
            $callback = $_REQUEST['callback'];
            header('Content-Type: text/javascript');
            echo $callback . '(' . json_encode($array) . ');';
        }
        else
        {
            header('Content-Type: application/x-json');
            echo json_encode($array);
        }
        Yii::app()->end();
    }

    public function renderAjaxArray($array)
    {
     
        
        echo json_encode($array);
        Yii::app()->end();
    }

    public function renderAjaxResult($success = false, $message = '')
    {
        assert('is_bool($success)');
        //$message = Yii::app()->sanitizer->sanitize($message);        
        header('Content-Type: application/x-json');
        echo json_encode(
        array(
            'success' => $success,
            'msg' => $message
        )
        );
        Yii::app()->end();
    }

    public function getImageUrl($filename)
    {
        return Yii::app()->request->getBaseUrl(true) . '/images/' . $filename;
    }

    public function checkLogin($requireLoginMessage = null, $returnUrl = null)
    {
        if (Yii::app()->user->isGuest)
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                Yii::app()->controller->renderAjaxResult(false, 'Please login before use this feature');
            }
            else
            {

                $this->setReturnUrl($returnUrl);
                
                Yii::app()->controller->redirect(array('/user/login', 'message' => $requireLoginMessage));
            }
        }
    }

    const POST_ERROR = 0;
    const SERVER_ERROR = 1;
    const SUCCESS = 2;

    public function renderXmlResult($success, $returnMsg = '', $items = array())
    {
        $mnb = array(
            'records' => array(
                'returnCode' => $success,
                'returnMsg' => $returnMsg,
                'items' => array(
                    'item' => $items
                )
            )
        );
        echo Array2XML::createXML('ltm', $mnb)->saveXML();
        Yii::app()->end();
    }

    public function checkFacebookLogin()
    {
        if (Yii::app()->facebook->getUser() == null)
        {
            $facebookLoginUrl = Yii::app()->facebook->getLoginUrl(array(
                'scope' => 'email,publish_stream,user_status,publish_stream,user_photos',
                'redirect_uri' => Yii::app()->createAbsoluteUrl('/site')
            ));
            $this->redirect($facebookLoginUrl);
        }
    }
    
    public function setReturnUrl($url){
        Yii::app()->session['ReturnUrl'] = $url;
    }
    
    public function redirectToReturnUrl($default = null){
        if(isset(Yii::app()->session['ReturnUrl'])){
            $this->redirect(Yii::app()->session['ReturnUrl']);
        }else{
            if($default == null) $default = $this->createUrl('/site');
            $this->redirect($default);
        }
    }
    
    public function hasReturnUrl(){
        if(isset(Yii::app()->session['ReturnUrl'])){
            return true;
        }
        return false;
    }
}