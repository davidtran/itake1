<?php

class m131003_101449_add_status_field_to_address_table extends CDbMigration
{
	public function up()
	{	
		$this->execute('ALTER TABLE `mp_address` ADD COLUMN `status` TINYINT NULL AFTER `phone`;');
        return true;
	}

	public function down()
	{
		echo "m131003_101449_add_status_field_to_address_table does not support migration down.\n";
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