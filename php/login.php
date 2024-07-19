<?php

require_once('./db.php');
require_once('./User.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, X-Requsted-With');

$method = $_SERVER['REQUEST_METHOD'];
$body = json_decode(file_get_contents('php://input'));

if ($method === 'POST') {

    //check if email and password are present on the body
    if (empty($body->email) || empty($body->password)) {
        http_response_code(400);
        echo json_encode(array('message' => 'Nieprawidłowy email lub hasło.'));
        exit();
    }

    //find a user by email and compare passwords
    $user = User::find_by_email($conn, $body->email);

    if (!$user) {
        http_response_code(400);
        echo json_encode(array('message' => 'Nieprawidłowy email lub hasło.'));
        exit();
    }

    $is_password_correct = password_verify($body->password, $user['password']);

    if (!$is_password_correct) {
        http_response_code(400);
        echo json_encode(array('message' => 'Nieprawidłowy email lub hasło.'));
        exit();
    }

    session_start();
    $_SESSION['user'] = array('id' => $user['id'], 'email' => $user['email']);
    
    echo json_encode(array('message' => 'Zalogowano.'));
}

if($method === 'GET') {
    session_start();

    if(empty($_SESSION['user'])) {
        echo json_encode(array('isAuth' => false));
        exit();
    }

    echo json_encode(array('isAuth' => true, 'user' => $_SESSION['user']));
}
