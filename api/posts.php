<?php

require "../utils.php";

header("Content-Type: application/json");

require_get();

$limit = $_GET["limit"] ?? 10;
$page = $_GET["page"] ?? 1;
$offset = ($page - 1) * $limit;

if ($limit > 100) {
    echo json_encode(["error" => "Limit must be less than 100"]);
    exit;
}


$posts = get_all_posts($limit, $offset);

if ($posts) {
    echo json_encode($posts);
    exit;
}

echo json_encode(["error" => "No posts found"]);
exit;
?>
