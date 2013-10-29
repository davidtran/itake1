<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryUtil
 *
 * @author David Tran
 */
class CategoryUtil
{
    /**
     * Return a list of translated category model
     * @return array
     */
    public static function getCategoryList(){
        $list = Category::model()->findAll(array(
            'order'=>'sort asc'
        ));
        foreach($list as $item){
            $item->name = Yii::t("Default",$item->name);
        }
        return $list;
    }        
    public static function getCategoryColor($index){
    	switch ($index) {
    		case 1:
    			return array('r' =>0xD5 ,'g'=>0x4E,'b'=>0x88 );
    		case 2:
    			return array('r' =>0xF9 ,'g'=>0x8A,'b'=>0x6E );
    		case 3:
    			return array('r' =>0xDF ,'g'=>0xAF,'b'=>0x4B );
    		case 4:
    			return array('r' =>0x00 ,'g'=>0x8C,'b'=>0x72 );
    		case 5:
    			return array('r' =>0xB4 ,'g'=>0xCD,'b'=>0x3D );
    		case 6:
    			return array('r' =>0x00 ,'g'=>0x6D,'b'=>0xA8 );
    		case 7:
    			return array('r' =>0x7B ,'g'=>0x7D,'b'=>0x7E );
    		case 8:
    			return array('r' =>0x83 ,'g'=>0x44,'b'=>0xB8 );
    		case 9:
    			return array('r' =>0x53 ,'g'=>0xC7,'b'=>0x70 );    	
    		default:
    			return array('r' =>0x00 ,'g'=>0x00,'b'=>0x00 );
    	}
    }
}

?>
