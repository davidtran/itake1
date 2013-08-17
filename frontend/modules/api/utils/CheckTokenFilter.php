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

    public function preFilter($filterChain)
    {

        if(Yii::app()->params['api.checkToken'] && ApiUser::getInstance()->isGuest != false){
            Yii::app()->controller->renderAjaxResult(false, 'Invalid token, need to login again');
        }else{
            $filterChain->run();
        }
        
    }

}

?>
