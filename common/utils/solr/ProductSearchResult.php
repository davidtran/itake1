<?php

class ProductSearchResult
{
    /**
     * Search status
     * @var int 
     */
    public $status;
    
    /**
     * Search time
     * @var float
     */
    public $queryTime;
    
    /**
     * Total of product found
     * @var int
     */
    public $numFound;
    
    /**
     * Search offset
     * @var int
     */
    
    public $productList = array();        

}