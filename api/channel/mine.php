<?php
require "../../utils.php";

header('Content-Type: application/json');


// Get all the user owned channels from the database

$user = login_required();

$limit = $_GET["limit"] ?? 10;
$page = $_GET["page"] ?? 1;
$offset = ($page - 1) * $limit;
$paginate = $_GET["paginate"] ?? false;


echo json_encode(get_all_user_channels($user['id'], $limit, $offset, $paginate));
