<?php

require '../utils.php';

header('Content-Type: application/json');



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    http_response_code(405);
    exit;
}

# Get the Raw JSON data from POST body. 
$json = file_get_contents('php://input');


# Decode the JSON data into an associative array.
$data = json_decode($json, true) ?? $_POST;

$email = $data['email'] ?? null;
$password = $data['password'] ?? null;
$next = $data['next'] ?? null;

$user = authenticate_user($email, $password);


if (!$user) {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid email or password'));
    http_response_code(401);
    exit;
}

set_session('secure_id', $user['secure_id']);

if ($next) {
    header("Location: $next");
    http_response_code(302);
    exit;
}

echo json_encode(display_user($user, ['password']));
exit;
