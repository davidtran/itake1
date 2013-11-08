<?php

class ProductUrlRule extends CBaseUrlRule{
    public $connectionID = 'db';
    public function createUrl($manager, $route, $params, $ampersand) {
        if($route == 'product/index'){
            if(isset($params['category'],$params['product'])){
                return $params['category'].'/'.$params['product'];
            }else{
                return $params['category'];
            }
        }
        exit;
        return false;
    }
    
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        
        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches))
		{
            var_dump($matches);exit;
            $categoryName = $matches[1];
            $productName = $matches[3];
            //$category = Category::model()->findByPk($)
			// check $matches[1] and $matches[3] to see
			// if they match a manufacturer and a model in the database
			// If so, set $_GET['manufacturer'] and/or $_GET['model']
			// and return 'car/index'
		}
		return false;  // this rule does not apply
    }
}
