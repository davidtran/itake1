<?php

class m130803_023342_user_feedback extends CDbMigration
{
	public function up()
	{
        $this->execute('CREATE TABLE IF NOT EXISTS `mp_feedback` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;');
        return true;
	}

	public function down()
	{
		$this->dropTable('{{feedback}}');
		return true;
	}

}