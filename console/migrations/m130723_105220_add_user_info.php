<?php

class m130723_105220_add_user_info extends CDbMigration
{
	public function up()
	{
        $this->createTable('mp_hello', array(
            'id'=>'pk',
            'title'=>'string not null',
            'content'=>'text'
        ));
        return true;
	}

	public function down()
	{
		$this->dropTable('mp_hello');
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