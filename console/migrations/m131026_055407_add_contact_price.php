<?php

class m131026_055407_add_contact_price extends CDbMigration
{
	public function up()
	{
        $sql = 'alter table mp_product add column `no_price` tinyint null';
        $this->execute($sql);
        return true;
	}

	public function down()
	{
        $sql = 'alter table mp_product drop column `no_price`';
        $this->execute($sql);
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