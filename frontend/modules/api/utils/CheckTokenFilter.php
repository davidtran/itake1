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


        if (ApiUser::getInstance()->isGuest != false)
        {
            $filterChain->run();
        }
        else
        {
            Yii::app()->controller->renderAjaxResult(false, 'Invalid token, need to login again');
        }
    }

}

?>
