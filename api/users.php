<?php

require '../utils.php';

header('Content-Type: application/json');

$limit = $_GET["limit"] ?? 10;
$page = $_GET["page"] ?? 1;
$offset = ($page - 1) * $limit;

$users = get_all_users($limit, $offset);

if (!$users) {
    echo json_encode(['error' => 'No users in the database']);
    exit;
}


echo json_encode(display_users($users));
