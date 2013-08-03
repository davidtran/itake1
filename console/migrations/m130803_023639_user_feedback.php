<?php

class m130803_023639_user_feedback extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{feedback}}', 'user_id', 'int');
	}

	public function down()
	{
		$this->dropColumn('{{feedback}}', 'user_id');
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