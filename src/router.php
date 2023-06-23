<?php
require_once 'vendor/autoload.php';
require_once 'database.php';

\Database::getInstance('sqlite');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri == '/hello') {
    require 'hello.php';
} elseif ($uri == '/product') {
    require 'product/ProductController.php';
} else {
    header('HTTP/1.1 404 Not Found');
    echo 'Page not found';
}