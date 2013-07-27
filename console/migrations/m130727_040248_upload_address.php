<?php

class m130727_040248_upload_address extends CDbMigration
{
	public function up()
	{
        $this->execute("
            DROP TABLE IF EXISTS {{address}};
            CREATE TABLE IF NOT EXISTS `{{address}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `city` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  `create_date` datetime NOT NULL,
  `user_id` int(11) not null,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");        
        $this->addColumn('{{product}}', 'address_id', 'int');
        return true;
	}

	public function down()
	{
		$this->dropTable('{{address}}');
        $this->dropColumn('{{product}}', 'address_id');
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