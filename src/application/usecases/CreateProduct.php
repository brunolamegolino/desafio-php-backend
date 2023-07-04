<?php

class CreateProduct
{
    private ProductRepository $productRepository;
    private ProductTypeRepository $productTypeRepository;

    public function __construct(ProductRepository $productRepository, ProductTypeRepository $productTypeRepository)
    {
        $this->productRepository = $productRepository;
        $this->productTypeRepository = $productTypeRepository;
    }

    public function execute(ProductDTO $input) : Product
    {
        $productType = $this->productTypeRepository->getProductTypeById($input->product_type_id);
        $product = Product::create((array) $input);
        return $this->productRepository->save($product);
    }
}