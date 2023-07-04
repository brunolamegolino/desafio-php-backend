<?php
require_once 'application/services/ProductService.php';
require_once 'infrastructure/persistence/ProductRepository.php';
require_once 'domain/entities/Product.php';
require_once 'domain/entities/ProductType.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $createProduct = new CreateProduct(
        new ProductRepository(),
        new ProductTypeRepository());
    $product = $createProduct->execute(new ProductDTO(...$_POST));
    header('Content-Type: application/json');
    echo json_encode($product);
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $products = (new ProductService)->getAllProducts();
    header('Content-Type: application/json');
    echo json_encode($products);
}