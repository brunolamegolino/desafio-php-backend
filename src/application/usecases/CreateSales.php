<?php

class CreateSales {

    private SalesRepository $salesRepository;
    private ProductRepository $productRepository;
    private SaleProductsRepository $saleProductsRepository;

    public function __construct(
        private CreateSalesDTO $input,
    ) {
        $this->salesRepository  = new SalesRepository();
        $this->productRepository    = new ProductRepository();
        $this->saleProductsRepository   = new SaleProductsRepository();
    }

    public function execute() {
        try {
            $sale = Sales::create((array) $this->input);
            $this->salesRepository->save($sale);

            $products = $this->productRepository->getProductsByIds(
                array_reduce($this->input->products,
                fn($prev, $cur) => $prev.(empty($prev)?'':',')."'".$cur['id']."'", ''));

            $totalProducts = 0.0;
            foreach ($products as $product) {
                $product->quantity = $this->input->products[$product->id]['quantity'];
                $totalProducts += $product->price*$product->quantity;
            }

            $this->saleProductsRepository->save($sale->id, $products);

            round($sale->total) == round($totalProducts) ?: throw new Exception('Invalid price');
            return $sale;
        } catch (Throwable $e) {
            if ($sale->id) {
                $this->saleProductsRepository->delete($sale->id);
                $this->salesRepository->delete($sale->id);
            }
            throw new Error('Error creating sale');
        }
    }
}