<?php

class UserRoleConstant{
    const NOTHING = 0;
    const MOD = 1;
    const ADMIN = 2;
    const GOD = 3;
    
    const CREATE_USER_TASK = 'createUser';
    const UPDATE_USER_TASK = 'updateUser';
    const DELETE_USER_TASK = 'deleteUser';
    const VIEW_USER_TASK = 'viewUser';
    const VIEW_PRODUCT = 'viewProduct';
    const DELETE_PRODUCT = 'deleteProduct';        
    
    public static function getRoleList(){
        return array(
            self::NOTHING=>'User',
            self::MOD=>'Mod',
            self::ADMIN=>'Admin'
        );
    }
    
    public static function getRoleName($role){
        $list = self::getRoleList();
        if(isset($list[$role])){
            return $list[$role];
        }else{
            return null;
        }
    }
    
    public static function getAdminRoleList(){
        return array(self::MOD,self::ADMIN);
    }
    
    public static function getAdminUserList(){
        $adminList = implode(',',self::getAdminRoleList());        
        $sql = 'select email from {{user}} where role in ('.$adminList.')';
        $list = Yii::app()->db->createCommand($sql)                                
                ->queryAll();
        
        $rs = array();
        foreach($list as $row){
            $rs[] = $row['email'];
        }
        return $rs;
    }
}