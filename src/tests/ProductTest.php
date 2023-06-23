<?php
namespace Tests\Unit;

require_once '/app/database.php';

use Database;
use Product\ProductService;

// use Tests\Support\UnitTester;

class ProductTest extends \Codeception\Test\Unit
{

    // protected \UnitTester $tester;
    private $db;

    public function __construct() {
        Database::getInstance('sqlite');
    }

    protected function _before()
    {
    }

    public function testCreateProduct()
    {
        try {
            ProductService::createProduct('Product 1', 'Descrição', 10.00, 1);
        } catch (\Exception $e) {
            $this->assertEquals("Type doesn't exist", $e->getMessage());
        }

        $this->db->query("INSERT INTO product_type (id, name) VALUES ('1', 'Type 1')");
        $product = ProductService::createProduct('Product 1', 'Descrição', 10.00, 1);
        $this->assertEquals('Product 1', $product->name);

    }
}
