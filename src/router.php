<?php
require_once 'vendor/autoload.php';
require_once 'database.php';

// Database::getInstance('sqlite');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri == '/hello') {
    // php_sapi_name
    // echo php_sapi_name();
    require 'hello.php';
} elseif ($uri == '/product') {
    require 'product/ProductController.php';
} else {
    header('HTTP/1.1 404 Not Found');
    echo 'Page not found';
}