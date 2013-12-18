<?php

class m131218_052447_set_user_id_productid_unique_in_rating extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE IF NOT EXISTS `mp_rating` (
		  `id` int(11) NOT NULL,
		  `product_id` int(11) NOT NULL,
		  `user_id` int(11) NOT NULL,
		  `score` tinyint(4) NOT NULL,
		  `create_date` datetime NOT NULL,
		  UNIQUE KEY `product_id` (`product_id`,`user_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	}

	public function down()
	{
		echo "m131218_052447_set_user_id_productid_unique_in_rating does not support migration down.\n";
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