<?php

class m131109_105601_add_user_slug extends CDbMigration
{
	public function up()
	{
   //     $this->execute('alter table {{user}} add column slug varchar(100) null;');
        $userList = User::model()->findAll();   
        $slugMaker = new SlugMakerUtil();
        foreach($userList as $user){
            $slug = $slugMaker->makeDefaultSlug($user->username);
            if($slug!==false){
                $user->slug = $slug;
                $user->save();
            }
        }
	}

	public function down()
	{
		echo "m131109_105601_add_user_slug does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}