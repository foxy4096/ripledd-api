<?php

require "../utils.php";


header("Content-Type: application/json");

require_get();


// get the id from the user

$id = $_GET["id"] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["message" => "Missing id"]);
    exit;
}

$post = get_post_by_id($id);

if ($post) {
    echo json_encode($post);
    exit;
}

http_response_code(404);
echo json_encode(["message" => "Post not found"]);
exit;
