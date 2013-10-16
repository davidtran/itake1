<?php

class m131016_143514_add_update_product_right extends CDbMigration
{
	public function up()
	{
        $auth = Yii::app()->authManager;
        /* @var $auth CAuthManager */
        $auth->createTask('updateProduct');
        $mod = $auth->getAuthItem('mod');
        $mod->addChild('updateProduct');
	}

	public function down()
	{
		echo "m131016_143514_add_update_product_right does not support migration down.\n";
		return false;
	}

}