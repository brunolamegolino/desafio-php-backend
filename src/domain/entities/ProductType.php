<?php

class ProductType
{
    private function __construct(
        public string $id,
        public string $name,
        public float $percentage_tax,
        public string $created_at,
    ) {}

    public static function create(string $name, float $percentage_tax) {
        return new ProductType('', $name, $percentage_tax, '');
    }
}