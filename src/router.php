<?php
require_once 'vendor/autoload.php';
require_once 'database.php';

\Database::getInstance('sqlite');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try {
    if ($uri == '/hello') {
        require 'hello.php';
    } elseif ($uri == '/product') {
        require 'product/ProductController.php';
    } else {
        header('HTTP/1.1 404 Not Found');
        echo 'Page not found';
    }
} catch (\Exception $e) {
    if (getenv('DEBUG') == 'TRUE') {
        throw $e;
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Instability in the application. try again later.';
    }
}
