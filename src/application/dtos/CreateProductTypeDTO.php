<?php

class CreateProductTypeDTO
{
    public function __construct(
        public string $name,
        public float $percentage_tax,
    ) {}
}