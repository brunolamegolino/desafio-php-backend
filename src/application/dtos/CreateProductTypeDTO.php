<?php

class CreateProductTypeDTO
{
    public string $name;
    public float $percentage_tax;

    public function __construct(
        string $name,
        string $description,
        float  $price,
        string $product_type_id,
        string $images_path)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->product_type_id = $product_type_id;
        $this->images_path = $images_path;
    }
}