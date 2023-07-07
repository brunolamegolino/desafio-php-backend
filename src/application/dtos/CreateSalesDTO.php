<?php

class CreateSalesDTO {

    public function __construct(
        public array $products,
        public float $total,
    ) {
        $this->products = array_reduce($this->products, function($prev, $cur) {
            $prev[$cur['id']] = $cur;
            return $prev;
          }, []);
    }
}