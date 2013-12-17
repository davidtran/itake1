<?php

Yii::import('common.extensions.yii-mail.YiiMailMessage');

/**
 * Util class to send email with custom-data
 */
class EmailUtil extends CWidget
{

    public static function sendEmail($from, $to, $view, $params, $subject)
    {
        Yii::app()->mail;
        $message = new YiiMailMessage;
        $message->view = $view;
        $message->setBody($params, 'text/html');
        $message->subject = $subject;
        $toEmailList = $to;
        if (is_array($to))
        {
            $toEmailList = implode(',', $to);
        }
        if (is_array($to))
        {
            foreach ($to as $toAddress)
            {
                $message->addTo($toAddress);
            }
        }
        else
        {
            $message->addTo($to);
        }

        $message->from = $from;
        try
        {
            Yii::app()->mail->send($message);
            return true;
        }
        catch (Exception $e)
        {
            $msg = 'Send email fail from ' . $from . ' to ' . $toEmailList;
            Yii::log($msg);
            return false;
        }
    }

    protected static function createEmailQueue($from, $to, $view, $params, $subject,$requireVerify)
    {
        $model = new EmailQueue();
        $model->from_email = $from;
        $model->to_email = $to;
        $model->view = $view;
        $model->params = serialize($params);
        $model->subject = $subject;   
        $model->require_verify = $requireVerify;
        return $model;
    }

    public static function queue($from, $to, $view, $params, $subject, $requireVerify = true, $checkUnique = false, $uniqueParams = null)
    {
        $model = self::createEmailQueue($from, $to, $view, $params, $subject,$requireVerify);


        $model->unique_hash = self::queueUniqueHash($model, $uniqueParams);

        $isUnique = true;
        if ($checkUnique)
        {
            $checkUnique = EmailQueue::model()->count("t.unique_hash=:hash", array(":hash" => $model->unique_hash));
            $isUnique = $checkUnique > 0 ? false : true;
        }

        if (($checkUnique && $isUnique) || !$checkUnique)
        {
            
            return $model->save();

            
        }
        return false;
    }

    private static function queueUniqueHash($emailQueue, $uniqueParams = null)
    {
        $hash = '';
        if ($uniqueParams != null)
        {
            if (is_array($uniqueParams))
            {
                $uniqueParams = CJSON::encode($uniqueParams);
            }
            $uniqueParams = "{$emailQueue->view}-$uniqueParams";
        }
        else
        {
            $uniqueParams = "{$emailQueue->from_email}-{$emailQueue->to_email}-{$emailQueue->subject}-{$emailQueue->view}";
        }
        $hash = md5($uniqueParams);
        return $hash;
    }

}
