<?php
require_once 'vendor/autoload.php';
require_once 'database.php';

Database::getInstance('postgres');

date_default_timezone_set('America/Sao_Paulo');

header('Access-Control-Allow-Origin: *');
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try {
    if ($uri == '/hello') {
        require 'hello.php';
    } elseif ($uri == '/product') {
        require 'presentation/controllers/ProductController.php';
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
