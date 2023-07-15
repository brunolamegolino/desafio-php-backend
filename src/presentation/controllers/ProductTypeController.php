<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $products = (new ProductTypeService())->getAllProductTypes();
    header('Content-Type: application/json');
    echo json_encode($products);
}   