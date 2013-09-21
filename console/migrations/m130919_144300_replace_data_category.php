<?php

class m130919_144300_replace_data_category extends CDbMigration
{
	public function up()
	{
		$dataSQL = file_get_contents(Yii::getPathOfAlias('console').'/migrations/replace_data_category.sql');
        $this->execute($dataSQL);
        return true;
	}

	public function down()
	{
		echo "m130919_144300_replace_data_category does not support migration down.\n";
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