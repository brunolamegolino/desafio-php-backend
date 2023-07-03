<?php

class Product
{
    private function __construct(
        public string $id='',
        public string $name,
        public string $description,
        public float $price,
        public string $product_type_id,
        public ProductType | null $productType,
        public string $images_path,
        public string $created_at,
    ) {}

    public static function create(
        string $name, 
        string $description, 
        float $price, 
        string $product_type_id, 
        ProductType | null  $productType)
    {
        return new Product('', $name, $description, $price, $product_type_id, $productType, '', '');
    }
}