<?php
require_once('./db.php');
require_once('./User.php');

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Origin, Content-Type, Access-Control-Allow-Methods, X-Requsted-With');

$method = $_SERVER['REQUEST_METHOD'];
$body = json_decode(file_get_contents('php://input'));

if ($method === 'POST') {

    //check if email and password are present on the body
    if (empty($body->email) || empty($body->password || $body->repassword)) {
        http_response_code(400);
        echo json_encode(array('message' => 'Nieprawidłowe dane.'));
        exit();
    }

    $is_email_valid = filter_var($body->email, FILTER_VALIDATE_EMAIL);

    if (!$is_email_valid) {
        http_response_code(400);
        echo json_encode(array('message' => 'Nieprawidłowy email'));
        exit();
    }

    // check if email is available
    $is_email_available = User::is_email_available($conn, $body->email);

    if (!$is_email_available) {
        http_response_code(400);
        echo json_encode(array('message' => 'Ten email jest już zajęty'));
        exit();
    }

    if (strlen($body->password) < 8) {
        http_response_code(400);
        echo json_encode(array('message' => 'Hasło powinno zawierać przynajmniej 8 znaków'));
        exit();
    }

    if ($body->password !== $body->repassword) {
        http_response_code(400);
        echo json_encode(array('message' => 'Hasła muszą być takie same'));
        exit();
    }

    //hash password
    $hashed_password = password_hash($body->password, PASSWORD_DEFAULT);

    $user = new User($body->email, $hashed_password);
    $result = $user->insert($conn);

    echo json_encode(array('message' => 'Dodano użytkownika'));
}
