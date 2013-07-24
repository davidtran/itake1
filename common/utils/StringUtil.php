<?php

    class StringUtil
    {

        /**
         *
         * @param type $text
         * @param type $limit
         * @return type 
         */
        public static function limitCharacter($text, $limit, $endStr = '...')
        {

            if (strlen($text) <= $limit) {
                return $text;
            }

            $last_space = strrpos(substr($text, 0, $limit), ' ');
            // Trim
            $trimmed_text = substr($text, 0, $last_space);
            // Add ellipsis.
            $trimmed_text .= $endStr;
            if(strcmp($trimmed_text,$endStr)==0)
            {
                return substr($text, 0, $limit).$endStr;
            }
            return $trimmed_text.$endStr;

        }
        
        /**
         * Limit text in a smarter way.
         * @param type $text
         * @param type $limit
         * @param type $endStr
         * @return type
         */
        public static function smartLimit($text,$limit = 50,$endStr = '...'){            
            $text = trim($text);
            if(mb_strlen($text,'utf-8') <=$limit){
                return $text;
            }else{
                $space = ' ';
                $moveLimit = 10;
                //check forward
                for($i=50;$i<  strlen($text)+$moveLimit;$i++){
                    if(mb_substr($text,$i,1,'utf-8') == $space){
                        return mb_substr($text,0,$i,'utf-8').$endStr;
                    }
                }
                //check backward                
                for($i=50;$i > mb_strlen($text,'utf-8') - $moveLimit;$i--){
                    if(mb_substr($text,$i,1,'utf-8') == $space){
                        return mb_substr($text,0,$i,'utf-8').$endStr;
                    }
                }
                
                return substr($text, 0,10).$endStr;
            }
        }
        
        public static function limitByWord($text,$limit,$endStr = '...'){
            $textArray = explode(' ', $text);
            if(count($textArray)> $limit){
                $resultArray = array_slice($textArray, 0,$limit);
                $result = implode(' ', $resultArray);
                return $result.$endStr;
            }else{
                return $text;
            }
        }
        
        public static function removeSpecialCharacter($str)
        {
            return preg_replace('/[^a-zA-Z0-9\s]/s', '', $str);
        }
        
        public static function makeSlug($name)
        {
            return str_replace(' ', '-', self::removeSpecialCharacter(trim(self::utf8ToAscii($name))));
        }
        
        public static function generateRandomString($length = 10)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++)
            {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

        public static function utf8ToAscii($str)
        {
            if (!$str)
                return false;
            $unicode = array(
                'a' => 'A|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
                'b' => 'B',
                'c' => 'C',
                'd' => 'D|Đ|đ',
                'e' => 'E|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
                'f' => 'F',
                'g' => 'G',
                'h' => 'H',
                'i' => 'I|Í|Ì|Ỉ|Ĩ|Ị|í|ì|ỉ|ĩ|ị',
                'j' => 'J',
                'k' => 'K',
                'l' => 'L',
                'm' => 'M',
                'n' => 'N',
                'o' => 'O|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
                'p' => 'P',
                'q' => 'Q',
                'r' => 'R',
                's' => 'S',
                't' => 'T',
                'u' => 'U|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
                'v' => 'V',
                'w' => 'W',
                'x' => 'X',
                'y' => 'Y|Ý|Ỳ|Ỷ|Ỹ|Ỵ|ý|ỳ|ỷ|ỹ|ỵ',
                'z' => 'Z')
            ;
            foreach ($unicode as $nonUnicode => $uni)
                $str = preg_replace("/($uni)/i", $nonUnicode, $str);
            return $str;
        }

        public static function replaceSingleWord($search,$replace,$needle){
            $pos1 = stripos($needle,$search);
            $length = strlen($search);
            if($pos1!==false){
                $start= substr($needle,0,$pos1);
                $mid = $replace;
                $end = substr($needle,$pos1+$length);
                return $start.$mid.$end;
            }
            return $needle;
        }


    }

?>
