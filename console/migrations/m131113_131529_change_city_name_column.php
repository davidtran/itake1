<?php

class m131113_131529_change_city_name_column extends CDbMigration
{
	public function up()
	{
        $this->execute("
                ALTER TABLE  `mp_city` CHANGE  `name`  `name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
                UPDATE  `itake`.`mp_city` SET  `name` =  'Hà Nội' WHERE  `mp_city`.`id` =1;
                UPDATE  `itake`.`mp_city` SET  `name` =  'Hồ Chí Minh' WHERE  `mp_city`.`id` =2;
                UPDATE  `itake`.`mp_city` SET  `name` =  'Đà Nẵng' WHERE  `mp_city`.`id` =3;
                ");
	}

	public function down()
	{
		echo "m131113_131529_change_city_name_column does not support migration down.\n";
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