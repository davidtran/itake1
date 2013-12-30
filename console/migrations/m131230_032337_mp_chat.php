<?php

class m131230_032337_mp_chat extends CDbMigration
{
	public function up()
	{
		$this->createTable('mp_chat', array(
            'id' => 'pk',
            'sender_id' => 'INT(11) NOT NULL',
            'receiver_id' => 'INT(11) NOT NULL',
            'body' => 'VARCHAR(256)',
            'is_read' => 'TINYINT(1) DEFAULT 0',
            'date' => 'DATETIME',
        ));
	}

	public function down()
	{
		echo "m131230_032337_mp_chat does not support migration down.\n";
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