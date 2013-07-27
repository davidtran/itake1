<?php

class m130727_160037_upload_address extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{address}}', 'phone', 'varchar(20)');
        return true;
	}

	public function down()
	{
		$this->dropColumn('{{address}}', 'phone');
        return true;
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