<?php

    class DateUtil
    {

        /**
         * Convert your date into another format
         * @param string $format convert format
         * @param string $date original date value
         * @return string date with new format 
         */
        public static function convertDate($format, $date)
        {
            if ($date != null)
            {
                $time = strtotime($date);
                if ($time !== false)
                {
                    return date($format, $time);
                }
            }
            return '';
        }                

        /**
         * Calculate how much time has passed for a given datetime compare with current datetime
         * @param string $date
         * @return string 
         */
        public static function elapseTime($date)
        {

            $time = strtotime($date);
            $time = time() - $time; 

            $tokens = array(
                31536000 => Yii::t('strings','year',null),
                2592000 => Yii::t('strings','month',null),
                604800 => Yii::t('strings','week',null),
                86400 => Yii::t('strings','day',null),
                3600 => Yii::t('strings','hour',null),
                60 => Yii::t('strings','min',null),
                1 => Yii::t('strings','second',null)
            );

            foreach ($tokens as $unit => $text)
            {
                if ($time < $unit)
                    continue;
                $numberOfUnits = floor($time / $unit);
                if($numberOfUnits>1)
                    return $numberOfUnits . ' ' . $text.'s';
                else
                    return $numberOfUnits . ' ' . $text;
            }
        }

        /**
         * return standard format of current datetime 
         * @return string Standard date time
         */
        public static function getCurrentDateTime()
        {
            return date('Y-m-d H:i:s');
        }

        public static function convertSecondToTime($second){
            $minute = floor($second /60);

            
            $remainSec = $second - ($minute *60);

            $smin = $minute < 10?'0'.$minute :$minute;
            $ssec = $remainSec < 10 ? '0'.$remainSec:$remainSec;
         
            return $smin.':'.$ssec;
        }    

        public static function convertDigitalTimeToSecond($time){
            // 00:00:00 to => 0
            $timeArr = explode(':',$time);            
            if(count($timeArr) == 3){
                return floatval($timeArr[0])*60*60 + floatval($timeArr[1])*60 + floatval($timeArr[2]);
            }else if(count($timeArr) == 2){
                return floatval($timeArr[0])*60 + floatval($timeArr[1]);
            }
            return 0;
        }
    }
