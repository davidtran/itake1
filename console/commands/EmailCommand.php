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
 
 
}