<?php

class ProductUrlRule extends CBaseUrlRule {

    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand) {
        switch($route){
            case 'product/details':
                if(isset($params['category'],$params['categoryName'],
                        $params['id'],$params['title'],
                        $params['city'],$params['cityName'])){
                    return $params['city'].'_'.$params['cityName'].'/'.
                            $params['category'].'_'.$params['categoryName'].'/'.
                            $params['id'].'_'.$params['title'];
                            
                }                
            break;
            case 'site/category':
                if(isset($params['category'],$params['categoryName'],
                        $params['city'],$params['cityName'])){
                    return $params['city'].'_'.$params['cityName'].'/'.
                            $params['category'].'_'.$params['categoryName'];
                }
            break;
            CASE 'site/city':
                if(isset($params['city'],$params['cityName'])){
                    return $params['city'].'_'.$params['cityName'];
                }
            break;                                        
        }      
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        
        if (preg_match('%^((\S+)/(\S+)/(\S+))?$%', $pathInfo, $matches)) {

            $cityName = $matches[2];
            $categoryName = $matches[3];
            $productName = $matches[4];
            if ( (false !== $cityId = $this->searchCity($cityName))
                    && (false !== $categoryId = $this->searchCategory($categoryName))
                    && (false !== $productId = $this->searchProduct($productName))) {
                $_GET['city'] = $cityId;
                $_GET['category'] = $categoryId;
                $_GET['id'] = $productId;
                return 'product/details';
            }
            return false;
            
            
        } else if (preg_match('%^((\S+)/(\S+))?$%', $pathInfo, $matches)) {
            $cityName = $matches[2];
            $categoryName = $matches[3];
            if ((false !== $cityId = $this->searchCity($cityName))
                    && (false !== $categoryId = $this->searchCategory($categoryName))) {               
                $_GET['city'] = $cityId;
                $_GET['category'] = $categoryId;
                return 'site/category';
            }
            return false;
            
        } else if (preg_match('%^((\S+))?$%', $pathInfo, $matches)) {
            $cityName = $matches[2];
            if (false !== $cityId = $this->searchCity($cityName)) {
                $_GET['city'] = $cityId;
                return 'site/city';
            }
            
        }
        return false;  // this rule does not apply
    }

    protected function searchProduct($name) {
        $nameArray = explode('_', $name);
        if (count($nameArray) >= 2) {
            $row = Yii::app()
                    ->db
                    ->createCommand('select id from {{product}} where id=:id')
                    ->bindValues(array(
                        'id' => $nameArray[0]
                    ))
                    ->queryRow();
            if ($row !== false) {
                return $row['id'];
            }
        }
        return false;
    }

    protected function searchCategory($name) {
        $nameArray = explode('_', $name);
        if (count($nameArray) >= 2) {
            $row = Yii::app()
                    ->db
                    ->createCommand('select id from {{category}} where id=:id')
                    ->bindValues(array(
                        'id' => $nameArray[0]
                    ))
                    ->queryRow();
            if ($row !== false) {
                return $row['id'];
            }
        }
        return false;
    }

    protected function searchCity($name) {
        $nameArray = explode('_', $name);
        if (count($nameArray) >= 2) {
            $row = Yii::app()
                    ->db
                    ->createCommand('select id from {{city}} where id =:id')
                    ->bindValues(array(
                        'id' => $nameArray[0]
                    ))
                    ->queryRow();
            if ($row!==false) {
                return $row['id'];
            }
        }
        return false;
    }

}
