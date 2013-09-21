<?php

class m130921_054450_fix_user_image extends CDbMigration
{

	public function safeUp()
	{
        $this->execute('update {{user}} set image = null');
        return true;
	}

	public function safeDown()
	{
        return false;
	}

}