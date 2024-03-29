<?php

/**
 * Import product model into solr
 */
class ProductModelSolrImporter extends ProductSolrImporter
{

    
    public function deleteProduct($product)
    {

        return $this->deleteById($product->id);
    }


    /**
     * Return a array contain all importable field from single product, these field should match with schema.xml in solr
     * @param Product $product
     * @return array
     */
    protected function getImportableProductData($product)
    {
        $data = array(
            'id' => $product->id,
            'title' => $product->title,
            'description' => $product->description,
            'category_id' => $product->category_id,
            'city_id' => $product->city,
            'create_date' => $this->formatSolrDate($product->create_date),
            'lat' => $product->lat,
            'lon' => $product->lon,
            'price' => $product->price,    
            'view'=>$product->view,
            'country'=>$product->country,
            'latlng_0_coordinate'=>$product->lat,
            'latlng_1_coordinate'=>$product->lon,
            'status'=>$product->status,
            'user_id'=>$product->user_id,
            'update_date'=>$this->formatSolrDate($product->update_date),
        );
        
        if ($product->category != null)
        {
            $data['category_name'] = $product->category->name;
        }
        
        $data['suggest_terms'] = $data['title'];
        if($product->cityModel!=null){
            $data['city_name'] = $product->cityModel->name;
        }else{
            $data['city_name'] = '';
        }
      
        return $data;
    }

}