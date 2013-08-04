<?php

class m130804_032040_big_price extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE  `mp_product` CHANGE  `price`  `price` BIGINT NOT NULL ;'); 
	}

	public function down()
	{
		echo "m130804_032040_big_price does not support migration down.\n";
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