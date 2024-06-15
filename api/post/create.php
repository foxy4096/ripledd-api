<?php


require '../../utils.php';

header('Content-Type: application/json');

require_post();

$user = login_required();

$data = get_request_post_data();

$allowed_cateories = [
    "NSFW",
    "Movie",
    "Video",
    "Animation",
    "Tutorial",
    "Broadcast",
    "Music",
    "Sound",
    "Voice",
    "Art picture",
    "Photo",
    "Story",
    "Announcement",
    "Guide",
    "Link",
    "Place",
    "Challenge",
];


$content = $data['content'] ?? null;
$category = $data['category'] ?? null;

if (!$content) {
    echo json_encode(['error' => 'Content is required']);
    exit;
}

$channel_id = $data['channel_id'] ?? null;

// Check if channel_id is in the POST and also check is the current authenticated user owns the channel
if (isset($channel_id)) {
    $channel = user_own_this_channel($user['id'], $channel_id);
    if ($channel) {
        $post = create_post($channel['id'], $content, $category);
        if ($post) {
            echo json_encode([
                "message" => "Post Created successfully via the channel user",
                "post" => $post[1]
            ]);
            exit;
        }
        echo json_encode([
            "message" => "Post could not be created"
        ]);
        http_response_code(500);
        exit;
    }
    echo json_encode(
        ["message" => "Forbidden"]
    );
    http_response_code(403);
    exit;
}

// Create the post by current authenticated user
$post = create_post($user['id'], $content, $category);
if ($post) {
    echo json_encode([
        "message" => "Post Created successfully via the auth user",
        "post" => $post[1]
    ]);
    exit;
}

echo json_encode([
    "message" => "Post could not be created"
]);
http_response_code(500);
exit;
