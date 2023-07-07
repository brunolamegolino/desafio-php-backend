<?php

class SaleProductsRepository {

    private PDO $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getDb();
    }

    public function save(string $saleId, array $products) {
        // array_map(function($product) {
        //     is_a($product, Product::class)?: throw new Exception('Invalid product');
        // }, $products);
        
        $sql = "INSERT INTO sale_products (sale_id, product_id, purchase_price, quantity) VALUES ";
        $sql .= implode(',', 
            array_map(function($product) use ($saleId) {
                return "('$saleId', '$product->id', $product->price, $product->quantity) ";
            }, $products));
        return $this->db->query($sql);
    }

    public function delete(string $saleId) {
        $this->db->exec("DELETE FROM sale_products WHERE sale_id = '$saleId'");
    }
}