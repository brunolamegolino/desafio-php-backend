<?php

class Sales {
    private function __construct(
        public string      $id,
        public float       $total,
        public string      $created_at,
        public array|null  $products,
    ) {}

    public static function create(array $data) {
        return new Sales('', $data['total'], '', $data['products']??null); 
    }
}