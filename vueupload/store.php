<?php
/**
 * Created by PhpStorm.
 * User: Kaan
 * Date: 11/16/2016
 * Time: 4:01 PM
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$id = uniqid(true);

//http_response_code(500);

echo json_encode([
    'data' => [
        'id' => $id
    ]
]);