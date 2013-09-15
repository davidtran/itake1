<?php

class CategoryCommand extends ConsoleCommand
{

    public function changeImage()
    {
//        $sql = 'select c.id,i.thumbnail from {{category}} c
//            join {{product}} p on p.category_id = c.id and p.view 
//                in (select max(view) from {{product}} p1 where p1.category_id = c.id)
//            join {{product_image}} i on i.product_id = p.id
//            ';
//        $categories = Yii::app()->db->createCommand($sql)->queryAll();
//        foreach($categories as $category){            
//            Yii::app()->db->createCommand()->update('{{category}}', array('image'=>$category['thumbnail']),'id='>$category['id']);
//        }
        $categories = Category::model()->findAll();
        foreach($categories as $category){
            $sql = 'select i.thumbnail from {{product}} p 
                join {{product_image}} i on p.id = i.product_id
                where p.view in (select max(view) from {{product}} p1 where p1.category_id = :category_id)';
            $image = Yii::app()->db->createCommand($sql)->bindValue('category_id', $category['id'])->queryScalar();
            echo $image;
        }
    }

}