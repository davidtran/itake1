<?php

class m130907_113330_ip_feedback extends CDbMigration
{
	public function up()
	{
        $this->execute('alter table {{feedback}} add ip varchar(20);');
	}

	public function down()
	{
		$this->execute('alter table mp_feedback drop column ip');
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