<?php
require_once 'ProductService.php';
require_once 'ProductModel.php';
require_once 'ProductRepository.php';

use Product\ProductService;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $description = $data['description'];
    $price = $data['price'];
    $productTypeId = $data['product_type_id'];

    $product = ProductService::createProduct($name, $description, $price, $productTypeId);
    header('Content-Type: application/json');
    echo json_encode($product);
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $products = ProductService::getAllProducts();
    header('Content-Type: application/json');
    echo json_encode($products);
}