<?php

class m130909_222616_add_admin_right extends CDbMigration
{
	
	public function safeUp()
	{
        $admin = User::model()->find('username="admin"');
        if($admin!=null){
            Yii::app()->db->createCommand()->insert('AuthAssignment', array(
                'itemname'=>'admin',
                'userid'=>$admin->id,
                'bizrule'=>NULL,
                'data'=>'N;'
            ));                        
            echo 'Finish assign right to admin'.PHP_EOL;
        }
        Yii::app()->db->createCommand()->update(
                'AuthItem',
                array('bizrule'=>NULL,'data'=>'N;'),
                'name like "admin" or name like "mod"'
        );
        return true;
        
	}

	public function safeDown()
	{
        return false;
	}
	
}