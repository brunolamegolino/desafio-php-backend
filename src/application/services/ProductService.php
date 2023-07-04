<?php

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct() {
        $this->productRepository = new ProductRepository();
    }

    public function getAllProducts() : array {
        return $this->productRepository->getProducts();
    }
}