<?php

// This api route will handle the media upload for the post

require '../../utils.php';

header('Content-Type: application/json');

$allowed_file_types = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/quicktime'];


require_post();

$user = login_required();

$data = get_request_post_data();

$id = $data['id'] ?? null;

if (is_null($id)){
    echo json_encode(["message" => "Missing id"]);
    exit;
}

$post = get_post_by_id($id);

if ($post['user_id'] != $user['id']){
    echo json_encode(["message" => "Unauthorized"]);
    http_response_code(401);
    exit;
}

// Get the media post

$media = $_FILES['media'] ?? null;

echo json_encode([$media, "alert" => "This route is currently under maintainance"]);
