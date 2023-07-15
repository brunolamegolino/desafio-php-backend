<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $createProduct = new CreateProduct();
    $product = $createProduct->execute(new ProductDTO(...$_POST, images: $_FILES ?? []));
    header('Content-Type: application/json');
    echo json_encode($product);
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $products = (new ProductService)->getAllProducts();
    header('Content-Type: application/json');
    echo json_encode($products);
}