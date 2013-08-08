<?php

/**
 * Import product model into solr
 */
class ProductModelSolrImporter extends ProductSolrImporter
{

    
    public function deleteProduct($product)
    {

        $this->solr->deleteById($product->id);
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
            'phone' => $product->phone,
            'view'=>$product->view,
            'country'=>$product->country
        );
        
        if ($product->category != null)
        {
            $data['category_name'] = $product->category->name;
        }
        
        $data['suggest_terms'] = $data['title'];
        $data['city_name'] = CityUtil::getCityName($product->city);
        return $data;
    }

}