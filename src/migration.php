<?php

require 'vendor/autoload.php';

$sqlite = new PDO('sqlite:tests/database.db');

$postgres = new PDO(
    'pgsql:host=db;port=5432;dbname=' . getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASSWD')
);

$sqlProductTypes = 
"CREATE TABLE IF NOT EXISTS product_types (
    id UUID PRIMARY KEY,
    name TEXT,
    percentage_tax REAL,
    created_at TIMESTAMP
    )";

$sqlite->exec($sqlProductTypes);
$postgres->exec($sqlProductTypes);

$sqlProducts = 
"CREATE TABLE IF NOT EXISTS products (
    id UUID PRIMARY KEY,
    name TEXT,
    price REAL,
    description TEXT,
    product_type_id UUID REFERENCES product_types(id),
    images_path TEXT,
    created_at TIMESTAMP
    )";
    
$sqlite->exec($sqlProducts);
$postgres->exec($sqlProducts);

$sqlSales = 
"CREATE TABLE IF NOT EXISTS sales (
    id UUID PRIMARY KEY,
    price REAL,
    created_at TIMESTAMP
    )";

$sqlite->exec($sqlSales);
$postgres->exec($sqlSales);

$sqlSaleProducts = 
"CREATE TABLE IF NOT EXISTS sale_products ( 
    id UUID PRIMARY KEY,
    sale_id UUID REFERENCES sales(id),
    product_id UUID REFERENCES products(id)
    )";

$sqlite->exec($sqlSaleProducts);
$postgres->exec($sqlSaleProducts);

echo "Tables created successfully.\n";