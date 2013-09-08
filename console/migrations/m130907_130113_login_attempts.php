<?php

class m130907_130113_login_attempts extends CDbMigration
{
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute('alter table {{user}} add column login_attempts int(11)');
        return true;
	}

	public function safeDown()
	{
        $this->dropColumn('{{user}}', 'login_attempts');
	}
	
}