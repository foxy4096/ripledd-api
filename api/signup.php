<?php

require "../utils.php";

header("Content-Type: application/json");

require_post();

$data = get_request_post_data();

$username = $data['username'] ?? null;
$password = $data['password'] ?? null;
$email = $data['email'] ?? null;

if (!$username || !$password || !$email) {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid input'));
    http_response_code(400);
    exit;
}

$user = create_user($username, $email, $password);
if (!$user['status'] == 'error') {
    echo json_encode(array('status' => 'error', 'message' => 'User creation failed'));
    http_response_code(500);
    exit;
}
echo json_encode($user);
http_response_code(201);

exit;
