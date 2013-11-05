<?php

class m131103_163855_add_limit_post_to_user extends CDbMigration
{
	public function up()
	{
        return $this->execute('
            alter table {{user}} add column post_limit int(11) null default 0;
            update {{user}} set post_limit = 3;');
	}

	public function down()
	{
		return $this->execute('alter table {{user}} drop column post_limit');
	}

}