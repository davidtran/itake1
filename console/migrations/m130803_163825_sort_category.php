<?php

class m130803_163825_sort_category extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE  `mp_category` ADD  `sort` INT NOT NULL ;');
	}

	public function down()
	{
		$this->dropColumn('{{category}}', 'sort');
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