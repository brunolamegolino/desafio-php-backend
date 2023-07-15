<?php

class ProductTypeService
{
    public function __construct(
        public ProductTypeRepository $productTypeRepository = new ProductTypeRepository()
    ) {}

    public function getAllProductTypes() : array {
        return $this->productTypeRepository->getProductTypes();
    }
}