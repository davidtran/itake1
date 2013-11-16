<?php

class SlugMakerUtil{
    protected $systemSlug = null;
    public function __construct() {
        ;
    }
    
    public function makeDefaultSlug($name){
        $originalSlug = self::makeSlug($name);
        $slug = $originalSlug;
        $try = 0;
        while(true){
            
            if($this->checkSlugAvailable($slug)){
                return $slug;
            }else{
                $slug =$originalSlug.'_'.rand(0,9999);
            }
            $try++;
            if($try > 100){
                break;
            }
        }  
        return false;
    }
    
    public function checkSlugAvailable($slug){
        
        if($this->systemSlug == null){
            $categorySlug = $this->getCategorySlug();
            $citySlug = $this->getCitySlug();
            $this->systemSlug = array_merge($citySlug,$categorySlug);       
        }
        
        foreach($this->systemSlug as $checkSlug){
            if($slug == $checkSlug){
                return false;
            }
        }
        if($this->isSlugAvailableInUser($slug)){
            return true;
        }

        return false;
        
        
    }
    
    protected function getCategorySlug(){
        $slugList = Yii::app()->db->createCommand('select slug from {{category}} where slug is not null or slug !=""')->queryAll();
        $allSlug = array();
        foreach($slugList as $slugRow){
            $slug = $slugRow['slug'];
            $allSlug[] = $slug;
            
            $allSlug[] = Yii::t('Default',$slug);
        }
        return array_unique($allSlug);
    }
    
    protected function getCitySlug(){
        $slugList = Yii::app()->db->createCommand('select slug from {{city}} where slug is not null or slug !=""')->queryAll();
        $allSlug = array();
        foreach($slugList as $slugRow){
            $allSlug[] = $slugRow['slug'];            
        }
        return $allSlug;
    }
    
    protected function isSlugAvailableInUser($slug){
        $count = Yii::app()->db->createCommand('select count(*) from {{user}} where slug like :slug')->bindValues(array(
            'slug'=>$slug
        ))->queryScalar();
        if(is_numeric($count) && $count>0){
            return false;
        }
        return true;
    }
    
    public static function makeSlug($name)
    {
        return trim(strtolower(
                StringUtil::replaceRepeatCharacter(
                str_replace(' ','-',
                    StringUtil::removeSpecialCharacter(
                        StringUtil::utf8ToAscii($name)
                    )),'-','')),'-');
    }
}
