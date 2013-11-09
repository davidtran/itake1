<?php

class ProductUrlRule extends CBaseUrlRule {

    public $connectionID = 'db';

    public function createUrl($manager, $route, $params, $ampersand) {
        switch($route){
            case 'product/details':
                if(isset($params['categorySlug'],
                        $params['id'],$params['title'],
                        $params['citySlug'])){
                    return $params['citySlug'].'/'.
                            $params['categorySlug'].'/'.
                            $params['id'].'_'.$params['title'];
                            
                }                
            break;
            case 'site/category':
                if(isset($params['categorySlug'],
                        $params['citySlug'])){
                    return $params['citySlug'].'/'.$params['categorySlug'];
                }
            break;
            CASE 'site/city':
                if(isset($params['citySlug'])){
                    return $params['citySlug'];
                }
            break;                                        
        }      
        return false;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        
        if (preg_match('%^((\S+)/(\S+)/(\S+))?$%', $pathInfo, $matches)) {
            if(count($matches) == 5){
                $citySlug = $matches[2];
                $categorySlug = $matches[3];
                $productName = $matches[4];
                if ( (false !== $cityId = $this->searchCity($citySlug))
                        && (false !== $categoryId = $this->searchCategory($categorySlug))
                        && (false !== $productId = $this->searchProduct($productName))) {
                    $_GET['city'] = $cityId;
                    $_GET['category'] = $categoryId;
                    $_GET['id'] = $productId;
                    return 'product/details';
                }
            }
            
            
        } else if (preg_match('%^((\S+)/(\S+))?$%', $pathInfo, $matches)) {
            $citySlug = $matches[2];
            $categorySlug = $matches[3];
            if ((false !== $cityId = $this->searchCity($citySlug))
                    && (false !== $categoryId = $this->searchCategory($categorySlug))) {               
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

    protected function searchCategory($slug) {
        
        
        $row = Yii::app()
                ->db
                ->createCommand('select id from {{category}} where slug=:slug')
                ->bindValues(array(
                    'slug' => $slug
                ))
                ->queryRow();
        if ($row !== false) {
            return $row['id'];
        }
        
        return false;
    }

    protected function searchCity($slug) {
        
        $row = Yii::app()
                ->db
                ->createCommand('select id from {{city}} where slug =:slug')
                ->bindValues(array(
                    'slug' => $slug
                ))
                ->queryRow();
        if ($row!==false) {
            return $row['id'];
        }
        
        return false;
    }

}
