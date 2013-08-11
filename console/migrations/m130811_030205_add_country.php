<?php

class m130811_030205_add_country extends CDbMigration
{
	public function up()
	{
        $citySql = file_get_contents(Yii::getPathOfAlias('console').'/migrations/mp_city.sql');
        $countrySql = file_get_contents(Yii::getPathOfAlias('console').'/migrations/mp_country.sql');
        
        $this->execute($citySql);
        $this->execute($countrySql);
        return true;
	}

	public function down()
	{
		echo "m130811_030205_add_country does not support migration down.\n";
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