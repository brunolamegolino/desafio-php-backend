<?php

class ProductRepository
{
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // @return Product[]
    public function getProducts($id=null) : array {
        return $this->db->query("SELECT * FROM products ".(!empty($id)?'WHERE id = $id':''))->fetchAll(PDO::FETCH_CLASS, Product::class);
    }

    public function save(Product $product) {
        $return = $this->db->query(
            "INSERT INTO products (name, description, price, product_type_id, images_path)
                VALUES ('$product->name', '$product->description', $product->price, '$product->product_type_id', '$product->images_path') RETURNING id, created_at")->fetch(PDO::FETCH_ASSOC);
        $product->id = $return['id'];
        $product->created_at = $return['created_at'];
    }
}