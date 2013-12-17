<?php

class m131211_155538_add_require_verify extends CDbMigration
{
	public function up()
	{
		$this->execute('alter table {{email_queue}} add column require_verify tinyint default 0');
	}

	public function down()
	{
		echo "m131211_155538_add_require_verify does not support migration down.\n";
		return false;
	}


}