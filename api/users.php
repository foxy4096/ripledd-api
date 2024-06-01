<?php

require '../utils.php';

header('Content-Type: application/json');

$limit = $_GET['limit'] ?? 10;
$offset = $_GET['offset'] ?? 0;

$users = get_all_users($limit, $offset);

if (!$users) {
    echo json_encode(['error' => 'No users in the database']);
    exit;
}


echo json_encode(display_users($users));
