<?php

class FeedbackController extends Controller{
    public function actionIndex()
    {
        $feedback = new Feedback();        
        $html = $this->renderPartial('partial/dialog',array(
            'feedback'=>$feedback
        ),true,false);
        $this->renderAjaxResult(true,array(
            'html'=>$html
        ));
    }
    
    public function actionSend(){
        $feedback = new Feedback();
        if(Yii::app()->user->isGuest == false){
            $feedback->user_id = Yii::app()->user->getId();
        }        
        if(isset($_POST['Feedback'])){
            $feedback->attributes = $_POST['Feedback'];
            $feedback->url = $_SERVER['HTTP_REFERER'];                        
            $feedback->ip = Yii::app()->request->getUserHostAddress();
            if($feedback->save()){
                FeedbackUtil::sendFeedbackToAdmin($feedback);
                $this->renderAjaxResult(true,'Phản hồi của bạn đã gửi đến chúng tôi. Xin cảm ơn bạn.');
            }else{
                $this->renderAjaxResult(false,'Vui lòng nhập đầy đủ thông tin');
            }            
        }
        $this->renderAjaxResult(false,'Có lỗi khi gửi phản hồi. Chúng tôi đang khắc phục điều này');
    }
    
    public function actionValidate(){
        $feedback = new Feedback();
        if(isset($_POST['Feedback'])){
            $feedback->attributes = $_POST['Feedback'];
            echo TbActiveForm::validate($feedback);
        }
    }
}
