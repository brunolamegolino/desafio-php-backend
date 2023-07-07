<?php

require 'vendor/autoload.php';

$postgres = new PDO(
    'pgsql:host=db;port=5432;dbname=' . getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASSWD')
);

try {
    $postgres->exec('CREATE DATABASE "' . getenv('DB_NAME') . '-test"');
} catch (\Throwable $e) {
    echo "Database already exists.\n";
}

$postgresTest = new PDO(
    'pgsql:host=db;port=5432;dbname=' . getenv('DB_NAME') . '-test',
    getenv('DB_USER'),
    getenv('DB_PASSWD')
);

$execSql = function ($sql) use ($postgres, $postgresTest) {
    $postgres->exec($sql);
    $postgresTest->exec($sql);
};

$execSql("CREATE TABLE IF NOT EXISTS product_types (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name TEXT,
    percentage_tax FLOAT,
    created_at TIMESTAMP DEFAULT now())");

$execSql( "CREATE TABLE IF NOT EXISTS products (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name TEXT,
    price FLOAT,
    description TEXT,
    product_type_id UUID REFERENCES product_types(id),
    images_path TEXT,
    created_at TIMESTAMP DEFAULT now()
    )");

$execSql("CREATE TABLE IF NOT EXISTS sales (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    total FLOAT,
    created_at TIMESTAMP DEFAULT now()
    )");

$execSql("CREATE TABLE IF NOT EXISTS sale_products ( 
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    sale_id UUID REFERENCES sales(id),
    product_id UUID REFERENCES products(id)
    )");

$execSql("ALTER TABLE sale_products ADD COLUMN IF NOT EXISTS purchase_price FLOAT");
$execSql("ALTER TABLE sale_products ADD COLUMN IF NOT EXISTS quantity INTEGER");

echo "Tables created successfully.\n";