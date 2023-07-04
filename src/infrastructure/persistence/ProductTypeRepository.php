<?php

class ProductTypeRepository
{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getDb();
    }
    
    public function getProductTypeById($id) : ProductType | false {
        $teste = $this->db->query("SELECT * FROM product_types WHERE id = '$id'");
        $teste->setFetchMode(PDO::FETCH_CLASS, ProductType::class, ['', '', 0, 0]);
        return $teste->fetch(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE);
    }

    public function hasProductTypeById($id) : bool {
        return is_a($this->getProductTypeById($id), ProductType::class);
    }

    public function save(ProductType $productType) : void {
        $return = $this->db->query(
            "INSERT INTO product_types (name, percentage_tax)
                VALUES ('$productType->name', $productType->percentage_tax) RETURNING id, created_at")->fetch(PDO::FETCH_ASSOC);
        $productType->id = $return['id'];
        $productType->created_at = $return['created_at'];
    }
}