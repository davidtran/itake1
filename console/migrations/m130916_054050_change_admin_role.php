<?php

class m130916_054050_change_admin_role extends CDbMigration
{
	public function up()
	{
        $admin = User::model()->find('username="admin"');
        if($admin!=null){
            $admin->role = 2;
            return $admin->save();            
        }
        return false;
	}

	public function down()
	{		
		return false;
	} 
}