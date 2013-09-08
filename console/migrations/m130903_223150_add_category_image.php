<?php

class m130903_223150_add_category_image extends CDbMigration
{
	public function up()
	{
        $this->execute('alter table mp_category add image varchar(200);');
        return true;
	}

	public function down()
	{
		$this->execute('alter table mp_category drop image;');
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