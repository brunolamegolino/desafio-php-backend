<?php

class ProductDTO
{
    public function __construct(
        public string $name,
        public string $description,
        public float $price,
        public string $product_type_id,
        public string $images_path='',    
    ) {}
}