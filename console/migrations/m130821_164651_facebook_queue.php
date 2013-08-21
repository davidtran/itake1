<?php

class m130821_164651_facebook_queue extends CDbMigration
{
	public function up()
	{
        $this->execute("CREATE TABLE IF NOT EXISTS `mp_facebook_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `command` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `create_date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0: fresh, 1: refreshed, 2: deleted',
  `success_date` datetime NOT NULL,
  `type` varchar(10) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
        return true;
	}

	public function down()
	{
		$this->dropTable('mp_facebook_queue');
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