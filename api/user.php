<?php

require '../utils.php';

header('Content-Type: application/json');

if (!isset($_GET['username'])) {
    echo json_encode(['error' => 'Missing username']);
    exit;
}

$username = $_GET['username'];

$user = get_user_by_username($username);

if (!$user) {
    echo json_encode(['error' => 'User not found']);
    exit;
}

echo json_encode(display_user($user));
