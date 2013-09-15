<?php

class m130915_102540_add_product_status extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $sql = "ALTER TABLE  `mp_product` ADD  `status` INT NOT NULL DEFAULT  '0'";
        $this->execute($sql);
        return true;
	}

	public function safeDown()
	{
        $sql = 'alter table {{product}} drop `status`';
        $this->execute($sql);
        return true;
	}
	
}