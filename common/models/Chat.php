<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $thisname
 * @property string $password
 * @property string $salt
 * @property string $create_date
 * @property string $update_date
 * @property integer $type
 * @property integer $level     
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $website
 * @property string $image  
 * @property integer $status     
 */
class Chat extends CActiveRecord
{   
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{chat}}';
    }


    public static function getUnreadMsg($userId)
    {
        # code...
        $count = Yii::app()
            ->db
            ->createCommand('select count(*) from {{chat}} where receiver_id =:user_id and is_read = 0')
            ->queryScalar(array(
                'user_id'=>$userId,
            ));   

        if(is_numeric($count) && $count > 0){
            return $count;
        }           
        return false;
    }
}