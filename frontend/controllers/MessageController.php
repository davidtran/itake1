<?php

class MessageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';


	
	public function actionSend()
	{
		$model=new Message;	
		if(isset($_POST['content']) && isset($_POST['user_id']))
		{
			
			$model->receiver_id = $_POST['user_id'];
			$model->content = $_POST['content'];
			if($model->save()){
				$html = $this->renderPartial('/message/_messageItem',array(
					'message'=>$model
				));
				$this->renderAjaxResult(true,array(
					'html'=>$html
				));
			}else{
				$this->renderAjaxResult(false,array('errors'=>$model->errors));
			}
		}

		$this->renderAjaxResult(false,'Invalid data');


	}

	/*

	List users having conversations with user
	Render list view

	*/

	public function actionList($page = 0)
	{
        
		$this->checkLogin('Vui lòng đăng nhập để sử dụng chức năng này');
        $userId = Yii::app()->user->id;
		$messageList = new MessageList($userId);
        $messageList->unread = true;
        $list = $messageList->getMessageList($page);
        
        
        echo $this->renderPartial('partial/list',array(
            'list'=>$list
        ),true,false); 
		
	}

	/*

	List messages in a conversation between user and another user (indicate by $GET['friendId'])	

	*/

	public function actionConversation($page = 0)
	{
		$id=Yii::app()->user->id;
		if(isset($_GET['friend_id']))
		{
			$friend_id = $_GET['friend_id'];
			$friend = User::model()->findByPk($friend_id);
			$dataProvider=new CActiveDataProvider('Message', array(
	    		'criteria'=>array(
	        		'condition'=>'(sender_id=:id AND receiver_id=:friend_id) OR (sender_id=:friend_id AND receiver_id=:id)',
	        		'params'=>array(':id'=>$id, 'friend_id'=>$friend_id),
	        		'order'=>'create_date ASC',
	    		),
	    		'pagination'=>array(
	        		'pageSize'=>20,
	        		'currentPage'=>$page,
	        	),
			));

			//Mark all message as read if user is last receiver
			$messages = $dataProvider->getData();
			$lastMessage = end($messages);
			if ($lastMessage->receiver_id == $id)
			{
				foreach ($messages as $message) {
					$message->is_read = 1;
					$message->save();
				}
			}
			$newMessage= new Message();
			$newMessage->sender_id = $id;
			$newMessage->receiver_id = $friend_id;
			$this->render('conversation',array(
				'dataProvider'=>$dataProvider,
				'messageList'=>$dataProvider->getData(),
				'newMessage'=>$newMessage,
				'friend'=>$friend
			));
		}
		
	}


	public function loadModel($id)
	{
		$model=Message::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}
