<?php

class MessageHelper{
    public static function renderMessageNotification(){
        if(Yii::app()->user->isGuest == false){
            $count = self::getUnreadMessageNumber(Yii::app()->user->id);
            return Yii::app()->controller->renderPartial('/message/partial/notification',array(
                'count'=>$count
            ),true,false);
            
        }
    }
    
    public static function getUnreadMessageNumber($userId){
        $count = Yii::app()->db->createCommand('
            select count(*) from {{user}} u
            inner join {{message}} m on m.sender_id = u.id OR m.receiver_id = u.id
            where (m.sender_id=:id OR m.receiver_id=:id) AND u.id != :id
            group by u.id')
                ->bindValue('id',$userId)
                ->queryScalar();
        if(is_numeric($count)){
            return $count;
        }
        return 0;
    }
}