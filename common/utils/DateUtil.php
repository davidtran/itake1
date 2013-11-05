<?php

class DateUtil {

    /**
     * Convert your date into another format
     * @param string $format convert format
     * @param string $date original date value
     * @return string date with new format 
     */
    public static function convertDate($format, $date) {
        if ($date != null) {
            $time = strtotime($date);
            if ($time !== false) {
                return date($format, $time);
            }
        }
        return '';
    }

    /**
     * return standard format of current datetime 
     * @return string Standard date time
     */
    public static function getCurrentDateTime() {
        return date('Y-m-d H:i:s');
    }

    public static function convertSecondToTime($second) {
        $minute = floor($second / 60);


        $remainSec = $second - ($minute * 60);

        $smin = $minute < 10 ? '0' . $minute : $minute;
        $ssec = $remainSec < 10 ? '0' . $remainSec : $remainSec;

        return $smin . ':' . $ssec;
    }

    public static function convertDigitalTimeToSecond($time) {
        // 00:00:00 to => 0
        $timeArr = explode(':', $time);
        if (count($timeArr) == 3) {
            return floatval($timeArr[0]) * 60 * 60 + floatval($timeArr[1]) * 60 + floatval($timeArr[2]);
        } else if (count($timeArr) == 2) {
            return floatval($timeArr[0]) * 60 + floatval($timeArr[1]);
        }
        return 0;
    }
    
    public static function elapseTime($date)
    {

        $time = strtotime($date);
        $time = time() - $time; 

        $tokens = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'min',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text)
        {
            if ($time < $unit)
                continue;
            $numberOfUnits = floor($time / $unit);
            return Yii::t('Default','{number} '.$text.'|{number} '.$text.'s',array($numberOfUnits,'{number}'=>$numberOfUnits));                
        }
    }
    
    public static function displayTime($date) {
        
        if (!empty($date)) {
            $day = 3600 * 24;
            $threeDays = $day * 3;
            $elapseTime = time() - strtotime($date);
            $week = $day * 7;
            $year = $day * 365;
            $dateFormatter = new CDateFormatter(Yii::app()->getLocale(Yii::app()->language));
            if ($elapseTime < $day || $elapseTime > $year) {
                $timeString = DateUtil::elapseTime($date);
                if (strlen($timeString) == 0) {
                    $timeString = "1 " . Yii::t('Default', 'second', null);
                }
                return $timeString . ' ' . Yii::t('Default', 'ago', null) . '';
            } else if ($elapseTime < $day * 2) {
                return Yii::t('Default', 'Yesterday at {time}', array(
                            '{time}' => $dateFormatter->format('HH:mm', strtotime($date)
                            )
                ));
            } else {


                $pattern = null;
                if ($elapseTime < $week) {
                    $pattern = 'EEEE';
                } else {
                    $pattern = 'd, MMMM';
                }

                return Yii::t('Default', '{date} at {time}', array(
                            '{date}' => $dateFormatter->format($pattern, strtotime($date)),
                            '{time}' => $dateFormatter->format('HH:mm', strtotime($date))
                ));
            }
        }
    }

}

