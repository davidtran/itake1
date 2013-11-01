<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->renderAjaxResult(true,array(
            'sessionID'=>Yii::app()->session->sessionID
        ));
	}
    
    public function actionCategoryList(){
        $categoryList = Category::model()->findAll();
        $result = array();
        foreach($categoryList as $category){
            $result[] = $category->attributes;
        }
        echo CJSON::encode($result);
    }
    
}