<?php

class CheckLoginFilter extends CFilter
{

    public function preFilter($filterChain)
    {
        if (Yii::app()->user->isGuest)
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                Yii::app()->controller->renderAjaxResult(false, 'Vui lòng đăng nhập trước khi sử dụng tính năng này');
            }
            else
            {
                //throw new CHttpException(401,'Vui lòng đăng nhập trước khi sử dụng tính năng này');
                Yii::app()->controller->redirect(array('/site/login'));
            }
        }
        $filterChain->run();
    }

}
