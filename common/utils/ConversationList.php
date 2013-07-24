<?php

class ConversationList{
    public $userId;
    public $friendId;
    
    public $pageSize = 10;
    public function __construct($userId,$friendId)
    {
        $this->userId = $userId;
        $this->friendId = $friendId;
    }
    
    public function getList($page){
        $dataProvider=new CActiveDataProvider('Message', array(
            'criteria'=>array(
                'condition'=>'(sender_id=:id AND receiver_id=:friend_id) OR (sender_id=:friend_id AND receiver_id=:id)',
                'params'=>array(':id'=>$this->userId, 'friend_id'=>$this->friendId),
                'order'=>'create_date ASC',
            ),
            'pagination'=>array(
                'pageSize'=>20,
                'currentPage'=>$page,
            ),
        ));        
        return $dataProvider;
    }
    
    
}