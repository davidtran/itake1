<?php

class m130811_160913_multi_image extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{product_image}}', 'number', 'integer');
	}

	public function down()
	{
		$this->dropColumn('{{product_image}}', 'number');
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