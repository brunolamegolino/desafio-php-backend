<?php

namespace ProductType;

class ProductType
{
    public $id;
    public $name;
    public $percentageTax;

    public function __construct($name)
    {
        $this->name = $name;
    }
}