<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sale = (new CreateSales(new CreateSalesDTO(...$_POST)))->execute();
    header('Content-Type: application/json');
    echo json_encode($sale);
}