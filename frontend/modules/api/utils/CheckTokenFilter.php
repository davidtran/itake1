<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CheckTokenFilter
 *
 * @author David Tran
 */


class CheckTokenFilter extends CFilter
{
    const SECRET = 'c6558217e31b5ca9ab672d0d1d566a4752369021442531.88915611';
    public function preFilter($filterChain)
    {
        //send operating system name, send phone name
        

        if(Yii::app()->params['api.checkToken'] ){
            if(isset($_REQUEST['os']) && isset($_REQUEST['phone']) && isset($_REQUEST['random']) && isset($_REQUEST['code'])){
                $code = md5(md5(self::SECRET).(md5($_REQUEST['os'].md5($_REQUEST['phone']))));
                if($code != $_REQUEST['code']){
                    Yii::app()->controller->renderAjaxResult(false, 'Invalid token.');
                }
            }else{
                Yii::app()->controller->renderAjaxResult(false, 'Invalid token.');
            }
            if(ApiUser::getInstance()->isGuest != false){
                Yii::app()->controller->renderAjaxResult(false, 'Invalid token, need to login again');
            }
            
        }else{
            $filterChain->run();
        }
        
    }

}

?>
