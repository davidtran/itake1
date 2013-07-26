<?php

class m130726_102529_mail_queue extends CDbMigration
{
	public function up()
	{
        $sql = "DROP TABLE IF EXISTS `{{email_queue}}`;
CREATE TABLE IF NOT EXISTS `{{email_queue}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `from_email` varchar(128) NOT NULL,
  `to_email` varchar(128) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `view` varchar(50),
  `max_attempts` int(11) NOT NULL DEFAULT '3',
  `attempts` int(11) NOT NULL DEFAULT '0',
  `success` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` datetime DEFAULT NULL,
  `last_attempt` datetime DEFAULT NULL,
  `send_date` datetime DEFAULT NULL,
  `unique_hash` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `to_email` (`to_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
        $this->execute($sql);
        return true;
        
	}

	public function down()
	{
		$this->dropTable('{{mail_queue}}');
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