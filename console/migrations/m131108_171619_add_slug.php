<?php

class m131108_171619_add_slug extends CDbMigration
{
	public function up()
	{
        $this->execute('
            ALTER TABLE  `mp_city` ADD  `slug` VARCHAR( 50 ) NOT NULL ;
            ALTER TABLE  `mp_category` ADD  `slug` VARCHAR( 50 ) NOT NULL ;
            ');
        $cityList = City::model()->findAll();
        foreach($cityList as $city){
            $city->slug = StringUtil::makeSlug($city->name);
            $city->save();
        }
        
        $categoryList = Category::model()->findAll();
        foreach($categoryList as $category){
            $category->slug = StringUtil::makeSlug($category->name);
            $category->save();
            //var_dump($category->errors);
        }
        return true;
	}

	public function down()
	{
		echo "m131108_171619_add_slug does not support migration down.\n";
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