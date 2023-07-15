<?php

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository = new ProductRepository()
    ) {}

    public function getAllProducts() : array {
        return $this->productRepository->getProducts();
    }

    public function getProduct(string $productId) : Product {
        return $this->productRepository->getProductsByIds("'".$productId."'")[0];
    }
}