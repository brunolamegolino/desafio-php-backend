<?php
namespace Product;

use Product;
use ProductRepository;

class ProductService
{
    public static function createProduct($name, $description, $price, $productTypeId) : Product {
        $product = new Product($name, $description, $price, $productTypeId);
        $product->save();
        return $product;
    }

    public static function getAllProducts() : array {
        return (new ProductRepository)->getProducts();
    }
}