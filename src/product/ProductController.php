<?php
require_once 'ProductService.php';
require_once 'ProductModel.php';
require_once 'ProductRepository.php';

use Product\ProductService;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $productTypeId = $_POST['product_type_id'];

    $product = ProductService::createProduct($name, $description, $price, $productTypeId);
    header('Content-Type: application/json');
    echo json_encode($product);
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $products = ProductService::getAllProducts();
    header('Content-Type: application/json');
    echo json_encode($products);
}