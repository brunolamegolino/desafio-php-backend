<?php

class CreateProductType
{
    private ProductTypeRepository $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepository)
    {
        $this->productTypeRepository = $productTypeRepository;
    }

    public function createProductType(createProductTypeDTO $input)
    {
        $productType = ProductType::create($input->name, $input->percentage_tax);
        $this->productTypeRepository->save($productType);
    }
}