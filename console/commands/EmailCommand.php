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
        $users = Yii::app()->db->createCommand('select u.username,u.id,u.username,u.email from {{user}} u join {{product}} p on p.user_id = u.id where p.id is not null group by u.id')->queryAll();        
        
        $productCommand = Yii::app()->db->createCommand('select view,id,title from {{product}} where user_id=:user_id');
        foreach($users as $user){
            $productList = $productCommand->bindParam('user_id', $user['id'])->queryAll();            
            $items = array();
            $summary = array(
                'like'=>0,
                'share'=>0,
                'view'=>0
            );
            foreach($productList as $index=>$product){
                $analytic = new SimpleProductAnalyticUtil($product);
                $analytic->makeAnalytic();      
                
                $items[$index]['like'] = $analytic->getLike();
                $items[$index]['share'] = $analytic->getShare();
                $items[$index]['view'] = $analytic->getView();
                $items[$index]['link'] = CHtml::link($product['title'],array('product/details','id'=>$product['id']));
                $summary['like'] += $analytic->getLike();
                $summary['share'] += $analytic->getShare();
                $summary['view'] += $analytic->getView();
            }
            EmailUtil::queue(
                        Yii::app()->params['email.adminEmail'], 
                        $user['email'], 
                        'weeklyAnalytic', 
                        array(
                            'items'=>$items,
                            'summary'=>$summary,
                            'username'=>$user['username']
                        ), 
                        Yii::t('Default','Weekly analytic'));
            
        }
    }
 
 
}