<?php
namespace Tests\Unit;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../product/ProductService.php';
require_once __DIR__ . '/../product/ProductModel.php';

use Database;
use Product\ProductService;

class ProductTest extends \Codeception\Test\Unit
{
    private $db;
    public function _before()
    {
        $this->db = Database::getInstance('sqlite')->getDb();  
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