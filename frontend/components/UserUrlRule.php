<?php

class UserUrlRule extends CBaseUrlRule{
    public $connectionID = 'db';
    public function createUrl($manager, $route, $params, $ampersand) {
        switch($route){
            case 'user/profile':
                if(isset($params['slug'])){
                    return $params['slug'];
                }               
                break;            
        }
        return false;
    }
    
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        if (preg_match('%^((\S+))?$%', $pathInfo, $matches)) {
            $slug = $matches[0];
            $id = $this->getUserIdBySlug($slug);
            if($id!==false){
                $_GET['id'] = $id;
                return 'user/profile';
            }
        }
        return false;
    }
    
    protected function getUserIdBySlug($slug){
        $id = Yii::app()->db->createCommand('select id from {{user}} where slug=:slug')
                ->bindValue('slug',$slug)
                ->queryScalar();
        return $id;
    }
}