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
    public static function getCategoryList(){
        return Category::model()->findAll();
    }        
}

?>
