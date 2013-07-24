<?php

    class FileUtil
    {

        public static function convertSizeToBytes($size, $format)
        {
            $filesizename = array("Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
            $fileSizeIndex = null;
            foreach($filesizename as $index=>$name){
                if($name == $format){
                    $fileSizeIndex = $index;
                }
            }
            if ($fileSizeIndex != null)
            {
                $exp = $fileSizeIndex +1;
              
               return $size *pow(1024,$exp);
            }
            return false;
        }
        
        

    }

?>
