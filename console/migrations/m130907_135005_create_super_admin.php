<?php

class m130907_135005_create_super_admin extends CDbMigration
{
	
	public function safeUp()
	{
        $admin = new User();
        $admin->email = 'admin@itake.me';
        $admin->username = 'admin';
        $admin->password = 'goodmorning2013';
        
        $rs= $admin->save();
        if(!$rs){
            var_dump($admin->getErrors());
        }
        return $rs;
        
	}

	public function safeDown()
	{
        return false;
	}

}