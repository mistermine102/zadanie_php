<?php
require_once('./db.php');
require_once('./User.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, X-Requsted-With');

$method = $_SERVER['REQUEST_METHOD'];

if($method === 'POST') {
    session_start();
    session_destroy();
}