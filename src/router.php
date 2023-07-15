<?php
require_once 'vendor/autoload.php';
require_once 'database.php';
require_once 'application/usecases/CreateSales.php';
require_once 'application/usecases/CreateProduct.php';
require_once 'application/dtos/CreateSalesDTO.php';
require_once 'application/dtos/ProductDTO.php';
require_once 'application/services/ProductService.php';
require_once 'application/services/ProductTypeService.php';
require_once 'domain/entities/Sales.php';
require_once 'domain/entities/Product.php';
require_once 'domain/entities/ProductType.php';
require_once 'infrastructure/persistence/SalesRepository.php';
require_once 'infrastructure/persistence/ProductRepository.php';
require_once 'infrastructure/persistence/ProductTypeRepository.php';
require_once 'infrastructure/persistence/SaleProductsRepository.php';
require_once 'infrastructure/persistence/ProductRepository.php';

Database::getInstance('postgres');

date_default_timezone_set('America/Sao_Paulo');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');

$_POST = $_POST
    ? $_POST
    : json_decode(file_get_contents('php://input'), true);

$uri = $_SERVER['REQUEST_URI'];

try {
    if ($uri == '/hello') {
        require 'hello.php';
    } elseif ($uri == '/product') {
        require 'presentation/controllers/ProductController.php';
    } elseif ($uri == '/sales') {
        require 'presentation/controllers/SalesController.php';
    } elseif ($uri == '/product-type') {
        require 'presentation/controllers/ProductTypeController.php';
    } elseif (str_contains($uri, '/image/')) {
        $imagePath = explode('/' , $uri);
        $imagePath = end($imagePath);
        $image = file_get_contents('public/'.$imagePath);
        header('Content-Type: image/'.explode('.', $imagePath)[1]);
        echo $image;
    } else {
        header('HTTP/1.1 404 Not Found');
        echo 'Page not found';
    }
} catch (Throwable $e) {
    if (getenv('DEBUG') == 'TRUE') {
        throw new Error($e->getMessage());
    } else {
        echo 'Instability in the application. try again later.';
    }
    header('HTTP/1.1 500 Internal Server Error');
}
