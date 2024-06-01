<?php


require '../../utils.php';

header('Content-Type: application/json');

require_post();

$data = get_request_post_data();


$content = $data['content'] ?? null;

if (!$content) {
    echo json_encode(['error' => 'Content is required']);
    exit;
}

$channel_id = $data['channel_id'] ?? null;

$user = get_authenticated_user();

if (!$user) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

// Check if channel_id is in the POST and also check is the current authenticated user owns the channel
if (isset($channel_id) && user_own_this_channel($user['id'], $data['channel_id'])) {
    echo json_encode([
        "message" => "Success, yes"
    ]);
} else {

    // Create the post by current authenticated user
    echo json_encode([
        "message" => "Post Created successfully via the auth user"
    ]);

}
