<?php
namespace Tests;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../application/usecases/CreateProduct.php';
require_once __DIR__ . '/../application/usecases/CreateSales.php';
require_once __DIR__ . '/../infrastructure/persistence/ProductRepository.php';
require_once __DIR__ . '/../infrastructure/persistence/ProductTypeRepository.php';
require_once __DIR__ . '/../infrastructure/persistence/SalesRepository.php';
require_once __DIR__ . '/../infrastructure/persistence/SaleProductsRepository.php';
require_once __DIR__ . '/../application/dtos/ProductDTO.php';
require_once __DIR__ . '/../application/dtos/CreateSalesDTO.php';
require_once __DIR__ . '/../domain/entities/ProductType.php';
require_once __DIR__ . '/../domain/entities/Product.php';
require_once __DIR__ . '/../domain/entities/Sales.php';


use CreateProduct;
use CreateSales;
use CreateSalesDTO;
use ProductDTO;
use Database;
use ProductType;
use ProductRepository;
use ProductTypeRepository;
use Tests\Support\UnitTester;

date_default_timezone_set('America/Sao_Paulo');


class GeneralCest
{
    public function _before(UnitTester $I) {
        (Database::getInstance('test'))->eraseTestDatabase();
    }

    public function testCreateProduct(UnitTester $I, $name='Product 1', $price='290.70')
    {
        $productType = ProductType::create('Type 01', 10);
        (new ProductTypeRepository())->save($productType);

        $input = new ProductDTO($name, "Description 1", $price, $productType->id, '');
        $porduct = (new CreateProduct(
            new ProductRepository(),
            new ProductTypeRepository()
            ))->execute($input);
        $I->assertEquals($input->name, $porduct->name);
        return $porduct;
    }

    public function testCreateSales(UnitTester $I) {
        $products = [];
        $products[] = [...((array) $this->testCreateProduct($I)), 'quantity' => 2];
        $products[] = [...((array) $this->testCreateProduct($I, 'Product 2', '175.00')), 'quantity' => 1];
        $total = array_reduce($products, fn($prev, $cur) => $prev + $cur['price']*$cur['quantity'], 0);

        $input = new CreateSalesDTO($products, $total);
        $sales = (new CreateSales($input))->execute();

        $I->assertEquals($input->total, $sales->total);
    }
}
