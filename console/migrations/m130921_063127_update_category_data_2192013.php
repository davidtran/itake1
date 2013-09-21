<?php

class m130921_063127_update_category_data_2192013 extends CDbMigration
{
	public function up()
	{
		$dataSQL = file_get_contents(Yii::getPathOfAlias('console').'/migrations/category_replacing_data_9212013.sql');
        $this->execute($dataSQL);
        return true;
	}

	public function down()
	{
		echo "m130921_063127_update_category_data_2192013 does not support migration down.\n";
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