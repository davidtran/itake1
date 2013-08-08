<?php

class m130808_093042_add_country_column extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `mp_product` ADD  `country` INT NOT NULL DEFAULT  '0';");
	}

	public function down()
	{
		$this->dropColumn('{{product}}', 'country');
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