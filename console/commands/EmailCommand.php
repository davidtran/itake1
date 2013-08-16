<?php

class EmailCommand extends ConsoleCommand
{
 
    public function sendQueueEmail()
    {
        $criteria = new CDbCriteria(array(
                'condition' => 'success=:success AND attempts < max_attempts',
                'params' => array(
                    ':success' => 0,
                ),
            ));
 
        $queueList = EmailQueue::model()->findAll($criteria);
 
        /* @var $queueItem EmailQueue */
        foreach ($queueList as $queueItem)
        {
            $rs = EmailUtil::sendEmail(
                        $queueItem->from_email, 
                        $queueItem->to_email, 
                        $queueItem->view, 
                        unserialize($queueItem->params), 
                        $queueItem->subject
                    );
            if($rs){
                $queueItem->attempts = $queueItem->attempts + 1;
                $queueItem->success = 1;
                $queueItem->last_attempt = new CDbExpression('NOW()');
                $queueItem->send_date = new CDbExpression('NOW()'); 
                $queueItem->save();
            }else{
                $queueItem->attempts = $queueItem->attempts + 1;
                $queueItem->last_attempt = new CDbExpression('NOW()'); 
                $queueItem->save();
            }   
        }
    }
    
    public function weeklyAnalytic(){
        //get all user have product > 1
        $users = Yii::app()->db->createCommand('select * from {{user}} u join {{product}} p on p.user_id = u.id where count(p.id) >0')->queryAll();
        $productCommand = Yii::app()->db->createCommand('select * from {{product}} where user_id=:user_id');
        foreach($users as $user){
            $productList = $productCommand->bindParam('user_id', $user['id'])->queryAll();
            $analyticResult = array();
            foreach($productList as $product){
                $analytic = new SimpleProductAnalyticUtil($product);
                $analytic->makeAnalytic();         
                $analyticResult['like'] = $analytic->getLike();
                $analyticResult['share'] = $analytic->getShare();
                $analyticResult['view'] = $analytic->getView();
                $analyticResult['link'] = CHtml::link($product['title'],array('product/details','id'=>$product['id']));
            }
            EmailUtil::queue(
                        Yii::app()->params['email.adminEmail'], 
                        $user['email'], 
                        'weeklyAnalytic', 
                        array(
                            'data'=>$analyticResult
                        ), 
                        Yii::t('Default','Weekly analytic'));
        }
    }
 
 
}