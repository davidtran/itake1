<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
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