<?php

class ProductRepository
{
    private $db;

    public function __construct() {
        $this->db = \Database::getInstance()->getDb();
    }

    // @return Product[]
    public function getProducts($id=null) : array {
        return $this->db->query("SELECT * FROM products ".(!empty($id)?'WHERE id = $id':''))->fetchAll(PDO::FETCH_CLASS, Product::class);
    }

    // public function hasProductById($id) : bool {
    //     return is_a($this->getProductById($id), Product::class);
    // }
}