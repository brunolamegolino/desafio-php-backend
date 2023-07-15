<?php

class ProductRepository
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getDb();
    }

    // @return Product[]
    public function getProducts(string $ids=null) : array {
        $sql = "
            SELECT
                p.*,
                pt.id as pt_id,
                pt.name as pt_name,
                pt.percentage_tax as pt_percentage_tax,
                pt.created_at as pt_created_at
            FROM products p
                INNER JOIN product_types pt ON p.product_type_id = pt.id 
            ".($ids ? " WHERE p.id IN ($ids) " : '');
        return $this->db->query($sql)
            ->fetchAll(
                PDO::FETCH_CLASS,
                Product::class, [['fetch']]);
    }

    public function save(Product $product) : Product {
        $return = $this->db->query(
            "INSERT INTO products (name, description, price, product_type_id, images_path)
                VALUES ('$product->name', '$product->description', $product->price, '$product->product_type_id', '$product->images_path')
                RETURNING id, created_at")->fetch(PDO::FETCH_ASSOC);
        $product->id = $return['id'];
        $product->created_at = $return['created_at'];
        return $product;
    }

    public function getProductsByIds(string $productsId) : array {
        return $this->getProducts($productsId);
    }

    public function saveImage($image) : string {
        $imagePath = uniqid().'.'.(explode('.', $image['name'])[1]);
        move_uploaded_file($image['tmp_name'], 'public/'.$imagePath);
        return $imagePath;
    }

    public function updateImagePath(string $productId, string $imagesPath) {
        $this->db->query("UPDATE products SET images_path = '$imagesPath' WHERE id = '$productId'");
    }

    public function delete(string $productId) {
        $this->db->query("DELETE FROM products WHERE id = '$productId'");
    }
}