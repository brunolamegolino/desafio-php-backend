<?php


header('Content-Type: application/json');

$data = array('key' => 'value', 'key2' => 'value2');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = array('key' => 'value');
}
    
echo json_encode($data);