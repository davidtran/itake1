<?php

class m130811_031006_multi_image extends CDbMigration
{
	public function up()
	{
        $this->execute("
            create table if not exists `{{product_image}}`(
            `id` int(11) not null AUTO_INCREMENT,
            `product_id` int(11) not null,
            `image` varchar(100) not null,
            `thumbnail` varchar(100) not null,
            `facebook` varchar(100) not null,
            `create_date` datetime not null,
            primary key (`id`)            
            )engine=InnoDb
            ");
        $products = Yii::app()->db->createCommand('select * from {{product}}')->queryAll();
        foreach($products as $product){
            Yii::app()->db->createCommand()->insert('{{product_image}}', array(
                'product_id'=>$product['id'],
                'image'=>$product['image'],
                'thumbnail'=>$product['image_thumbnail'],
                'facebook'=>$product['processed_image'],
                'create_date'=>$product['create_date']
            ));
        }
        return true;
	}

	public function down()
	{
		$this->dropTable('{{product_image}}');
        return true;
	}
}