<?php

class m130916_054050_change_admin_role extends CDbMigration
{
	public function up()
	{
        $admin = User::model()->find('username="admin"');
        if($admin!=null){
            $admin->role = UserRoleConstant::ADMIN;
            return $admin->save();            
        }
        return false;
	}

	public function down()
	{		
		return false;
	} 
}