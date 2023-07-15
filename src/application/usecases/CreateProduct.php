<?php

class CreateProduct
{

    public function __construct(
        private ProductRepository $productRepository = new ProductRepository(),
        private ProductTypeRepository $productTypeRepository = new ProductTypeRepository(),
    ) {}

    public function execute(ProductDTO $input) : Product
    {
        $productType = $this->productTypeRepository->getProductTypeById($input->product_type_id);
        $product = Product::create((array) $input);
        try {
        $productCreated = $this->productRepository->save($product);
        
        $imagesPath = [];
        foreach($input->images as $image) {
            $imagesPath[] = $this->productRepository->saveImage($image);
        }

        $productCreated->images_path = implode(',', $imagesPath);
        $this->productRepository->updateImagePath($productCreated->id, $productCreated->images_path);

        return $productCreated;
        } catch (Exception $e) {
            if ($productCreated->id) {
                $this->productRepository->delete($productCreated->id);
            }
            throw new Exception('Erro ao criar produto');
        }
    }
}