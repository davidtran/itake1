<?php

class m131123_090239_add_update_date extends CDbMigration
{
	public function up()
	{
		$sql = '
		alter table {{product}} add column update_date datetime not null;
		update {{product}} set update_date = create_date;';
		return $this->execute($sql);
	}

	public function down()
	{
		echo "m131123_090239_add_update_date does not support migration down.\n";
		return false;
	}

}