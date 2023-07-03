<?php
namespace Tests;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../application/usecases/CreateProduct.php';
require_once __DIR__ . '/../infrastructure/persistence/ProductRepository.php';
require_once __DIR__ . '/../infrastructure/persistence/ProductTypeRepository.php';
require_once __DIR__ . '/../application/dtos/ProductDTO.php';
require_once __DIR__ . '/../domain/entities/ProductType.php';
require_once __DIR__ . '/../domain/entities/Product.php';


use CreateProduct;
use ProductDTO;
use ProductRepository;
use ProductType;
use ProductTypeRepository;
use Tests\Support\UnitTester;

date_default_timezone_set('America/Sao_Paulo');

class ProductCest
{
    private $db;

    public function _before(UnitTester $I)
    {
        $this->db = \Database::getInstance('test')->getDb();
    }

    public function testCreateProduct(UnitTester $I)
    {
        $productType = ProductType::create('Type 01', 10);
        (new ProductTypeRepository($this->db))->save($productType);

        $input = new ProductDTO("Product 1", "Description 1", "290.70", $productType->id, '');
        (new CreateProduct(
            new ProductRepository($this->db),
            new ProductTypeRepository($this->db)
            ))->execute($input);
        $I->assertTrue(true);
    }
}
