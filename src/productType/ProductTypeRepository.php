<?php
namespace ProductType;

class ProductTypeRepository
{
    private $db;

    public function __construct() {
        $this->db = \Database::getInstance()->getDb();
    }
    public function getProductTypeById($id) : ProductType {
        return $this->db->query("SELECT * FROM product_type WHERE id = $id")->fetchObject(ProductType::class);
    }

    public function hasProductTypeById($id) : bool {
        return is_a($this->getProductTypeById($id), ProductType::class);
    }
}