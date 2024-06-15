<?php


require "../../utils.php";

header('Content-Type: application/json');

require_post();

$user = login_required();

$data = get_request_post_data();

$channel_name = $data["channel_name"] ?? null;
$channel_username = $data["channel_username"] ?? null;
$limited = $data["limited"] ?? false;

if (!$channel_name || !$channel_username) {
    echo json_encode(["status" => "error", "message" => "Missing channel name or username"]);
    http_response_code(400);
    exit;
}

// Check if channel exists
$channel_user = get_user_by_username($channel_username);

if ($channel_user) {
    echo json_encode(["status" => "error", "message" => "Channel already exists"]);
    http_response_code(409);
    exit;
} 

// If channel does not exist, create it
$channel = create_channel($user["id"] ,$channel_name, $channel_username, $limited);

if (!$channel) {
    echo json_encode(["status" => "error", "message" => "Failed to create channel"]);
    http_response_code(500);
    exit;
}

echo json_encode($channel);