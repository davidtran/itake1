<?php

class m131009_074106_comment_system extends CDbMigration
{
	public function up()
	{
        
        $sql = "--
            -- Table structure for table `mp_comment`
            --
            DROP TABLE IF EXISTS  `mp_comment`;
            CREATE TABLE IF NOT EXISTS `mp_comment` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `content` varchar(5000) NOT NULL,
              `create_date` datetime NOT NULL,
              `user_id` int(11) NOT NULL,
              `product_id` int(11) NOT NULL,
              `status` int(11) NOT NULL,
              `parent_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;";
        return $this->execute($sql);
        
	}

	public function down()
	{
		$this->dropTable('mp_comment');
		return true;
	}
	
}