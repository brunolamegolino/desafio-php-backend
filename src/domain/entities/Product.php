<?php

class Product
{
    public string $id='';
    public string $name;
    public string $description;
    public float $price;
    public string $product_type_id;
    public ProductType|stdClass $productType;
    public string $images_path;
    public string $created_a='';
    public int|null $quantity=null;
    
    private function __construct(array $product)
    {
        if (isset($product[0]) && $product[0] == 'fetch') {
            $this->productType      = ProductType::init($this->productType);
        } else {
            $this->name             = $product['name'];
            $this->description      = $product['description'];
            $this->price            = $product['price'];
            $this->product_type_id  = $product['product_type_id'];
            $this->images_path      = $product['images_path'];
        }
    }

    public function __set($name, $value) {
        $this->productType ??= new stdClass();
        $this->productType->$name = $value;
    }

    public static function create(array $data)
    {
        return new Product($data);
    }
}