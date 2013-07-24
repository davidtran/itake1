<?php

class MessageList{
    
    public $userId;
    
    public $pageSize = 10;
    public $unread = false;
    public function __construct($userId)
    {
        $this->userId = $userId;
        
    }
                
    public function getMessageList($page = 0){
        $criteria = new CDbCriteria();
		$criteria->select = 'u.*,m.is_read as lastIsRead, m.create_date as lastMessageDate, m.content as lastMessageContent';//,sum(s.score) as totalScore, count(s.user_id) as scoreCount';
		$criteria->condition = '(m.sender_id=:id OR m.receiver_id=:id) AND u.id != :id';
		$criteria->params = array(':id'=>$this->userId);
		$criteria->alias = 'u';
		$criteria->join = 'inner join {{message}} m on m.sender_id = u.id OR m.receiver_id = u.id';
		$criteria->distinct = true;		
		$criteria->order = 'lastMessageDate asc';
		$criteria->group = 'u.id';		
        
        if($this->unread){
            $criteria->compare('m.is_read', 0);
        }
        $dataProvider = CActiveDataProvider('User',array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>$this->pageSize,
                'currentPage'=>$page
            )
        ));
        $result = array();
        foreach($dataProvider->getData() as $item){
            $result[] = array(
                'friend'=>$item,
                'content'=>$item->lastMessageContent,
                'time'=>$item->lastMessageDate,
                'read'=>$item->lastIsRead
            );
        }
        return $result;
    }
}