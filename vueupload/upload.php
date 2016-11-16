<?php
/**
 * Created by PhpStorm.
 * User: Kaan
 * Date: 11/16/2016
 * Time: 4:03 PM
 */


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

if (isset($_FILES['file'], $_POST['id'])){
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_POST['id']);
}

echo json_encode([
    'data' => [
        'success' => true,
    ]
]);