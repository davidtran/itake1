<?php

class m130803_033329_user_feedback extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE  `mp_feedback` ADD PRIMARY KEY (  `id` ) ;
            ALTER TABLE  `mp_feedback` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT ;');
	}

	public function down()
	{
		echo "m130803_033329_user_feedback does not support migration down.\n";
		return false;
	}

}