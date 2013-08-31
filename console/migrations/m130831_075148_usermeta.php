<?php

class m130831_075148_usermeta extends CDbMigration
{
	public function up()
	{
        $metaList = Yii::app()->db->createCommand('select * from {{usermeta}}')->queryAll();
        foreach($metaList as $meta){
            $meta['value'] = serialize($meta['value']);
            $id = $meta['id'];
            unset($meta['id']);
            Yii::app()->db->createCommand()->update('{{usermeta}}',$meta ,'id=:id', array(
                'id'=>$id
            ));
        }
	}

	public function down()
	{
		echo "m130831_075148_usermeta does not support migration down.\n";
		return false;
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