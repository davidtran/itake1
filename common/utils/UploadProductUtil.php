<?php

class UploadProductUtil{
    public static function getStaticGoogleMapUrl($address,$addMaker = true,$width = 200,$height =200){
        $url = 'https://maps.googleapis.com/maps/api/staticmap?&sensor=true';
        $url.='&size='.$width.'x'.$height;
        $url.='&center='.$address->lat.','.$address->lon;
        $url.='&zoom=13';
        if($addMaker){
            $url.='&markers='.$address->lat.','.$address->lon;
        }
        return $url;
        
    }
}
