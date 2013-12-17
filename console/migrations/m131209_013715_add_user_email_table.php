<?php

class m131209_013715_add_user_email_table extends CDbMigration
{
	public function up()
	{
		$this->execute("

			CREATE TABLE IF NOT EXISTS `{{user_email}}` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,			
			  `email` varchar(255) NOT NULL,
			  `code` varchar(255) NOT NULL,
			  `is_verified` int(11) NOT NULL,
			  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`),
			  KEY `email` (`email`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

		");
	}

	public function down()
	{
		$this->execute('drop table {{user_email}}');
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