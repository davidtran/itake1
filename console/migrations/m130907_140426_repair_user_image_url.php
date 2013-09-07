<?php

class m130907_140426_repair_user_image_url extends CDbMigration
{

    public function safeUp()
    {
        $url = Yii::app()->params['urlManager.hostInfo'] . '/';
        $urlLength2 = strlen($url);
        $urlLength1 = strlen($url) + 1;
        $sql = 'update {{user}} set image = substring(image from ' . $urlLength1 . ') where substring(image from 1 for ' . $urlLength2 . ') = "' . $url . '"';
        $this->execute($sql);
        return true;
    }

    public function safeDown()
    {
        
    }

}