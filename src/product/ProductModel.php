<?php

require_once __DIR__.'/../productType/ProductTypeRepository.php';

use ProductType\ProductTypeRepository;

class Product
{
    public $product_id;
    public $name;
    public $description;
    public $price;
    public $product_type_id;

    public function __construct($name, $description, $price, $product_type_id)
    { 
        $this->product_type_id = (new ProductTypeRepository)->hasProductTypeById($product_type_id)
            ? $product_type_id
            : throw new Exception("Type doesn't exist");
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function save()
    {
        $db = \Database::getInstance()->getDb();
        $db->query(
            "INSERT INTO product (name, description, price, product_type_id)
                VALUES ('$this->name', '$this->description', $this->price, $this->product_type_id)");
        $this->product_id = $db->lastInsertId();
    }
}