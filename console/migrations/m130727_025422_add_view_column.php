<?php

class m130727_025422_add_view_column extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `mp_product` CHANGE  `view`  `view` INT( 11 ) NULL DEFAULT  '0';");
	}

	public function down()
	{
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