<?php

class JsonRenderAdapter{
    public static function renderProduct(Product $product){
        $data = array(
            'id'=>$product->id,
            'title'=>$product->title,
            'description'=>$product->description,
            'create_date'=>$product->create_date,
            'price'=>$product->price,           
            'locationText'=>$product->locationText,
            'phone'=>$product->phone,
            'city'=>$product->cityModel->attributes,            
            'country'=>$product->countryModel->attributes,
            'latitude'=>$product->lat,
            'longitude'=>$product->lon
        );
        if($product->user!=null){
            $data['user'] = self::renderUser($product->user);
        }
        $images = array();
        foreach($product->images as $image){
            $images[] = $image->attributes;
        }
        $data['images'] = $images;     
        return $data;
    }
    
    public static function renderUser(User $user){
        $data = array(
            'id'=>$user->id,
            'username'=>$user->username,
            'email'=>$user->email,
            'image'=>$user->getProfileImageUrl(true)
        );
        return $data;
    }
}