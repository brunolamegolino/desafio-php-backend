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

    public static function init(object $data) {
        return new ProductType(
            $data->pt_id,
            $data->pt_name,
            $data->pt_percentage_tax,
            $data->pt_created_at);
    }
}