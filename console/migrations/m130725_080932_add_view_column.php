<?php

class m130725_080932_add_view_column extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{product}}', 'view', 'int');
	}

	public function down()
	{
		$this->dropColumn('{{product}}', 'view');
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