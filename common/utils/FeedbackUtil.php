<?php

class FeedbackUtil
{

    protected static $adminList = array(
        array('Nam Tran', 'nam.trankhanh.vn@gmail.com'),
        array('Tuan Nguyen', 'tuan.itus@gmail.com'),
        array('Anh Phat', 'clark.nguyen@live.com'),
        array('Khoa Nguyen', 'vankhoa011@gmail.com')
    );

    public static function sendFeedbackToAdmin(Feedback $feedback)
    {
        foreach (self::$adminList as $adminData)
        {
            self::send($adminData[0], $adminData[1], $feedback);
        }
    }

    protected static function send($adminName, $adminEmail, $feedback)
    {
        EmailUtil::queue(
                Yii::app()->params['email.adminEmail'], $adminEmail, 'feedback', array(
            'username' => $feedback->username,
            'email' => $feedback->email,
            'message' => $feedback->message,
            'create_date' => $feedback->create_date,
            'url' => $feedback->url,
            'adminName' => $adminName
                ), 'Feedback từ iTake.me');
    }

}