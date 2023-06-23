<?php
namespace ProductType;

class ProductTypeRepository
{
    private $db;

    public function __construct() {
        $this->db = \Database::getInstance()->getDb();
    }
    
    public function getProductTypeById($id) : ProductType | false {
        return $this->db->query("SELECT * FROM product_types WHERE id = $id")->fetch(\PDO::FETCH_PROPS_LATE);
    }

    public function hasProductTypeById($id) : bool {
        return is_a($this->getProductTypeById($id), ProductType::class);
    }
}