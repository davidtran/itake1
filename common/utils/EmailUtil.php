<?php

    Yii::import('common.extensions.yii-mail.YiiMailMessage');

    /**
     * Util class to send email with custom-data
     */
    class EmailUtil extends CWidget
    {
    
        public static function sendEmail($from, $to, $view,$params, $subject)
        {
            Yii::app()->mail;
            $message = new YiiMailMessage;
            $message->view = $view;
            $message->setBody($params, 'text/html');
            $message->subject = $subject;
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
            catch(Exception $e)
            {
                $msg = 'Send email fail from '.$from.' to '.implode(',', $to);
                Yii::log($msg);
                return false;
            }
        }
     


    }
