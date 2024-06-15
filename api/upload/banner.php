<?php

// This api route will handle the banner upload for users!

require "../../utils.php";

header("Content-Type: application/json");

require_post();

$user = get_authenticated_user();

if (!$user) {
    echo json_encode(array('status' => 'error', 'message' => 'User not authenticated'));
    http_response_code(401);
    exit;
}

if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {

    $upload_dir = '../../profile/';
    $DEFAULT_BANNER = "default/default-banner.png";

    $temp_name = $_FILES['banner']['tmp_name'];
    $file_name = $_FILES['banner']['name'];
    $file_size = $_FILES['banner']['size'];
    $file_type = $_FILES['banner']['type'];

    // Validate file size (max 20MB)
    if ($file_size > 20 * 1024 * 1024) {
        echo json_encode(array('status' => 'error', 'message' => 'File size must be less than 20MB'));
        http_response_code(400);
        exit;
    }

    // Validate file type (allow only JPEG, PNG, GIF)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file_type, $allowed_types)) {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed.'));
        http_response_code(400);
        exit;
    }

    // Validate that the file is an image
    $image_info = getimagesize($temp_name);
    if ($image_info === false) {
        echo json_encode(array('status' => 'error', 'message' => 'File is not a valid image'));
        http_response_code(400);
        exit;
    }

    $old_banner = $user['banner'];

    if (move_uploaded_file($temp_name, $upload_dir . "/banner/" . $file_name)) {
        http_response_code(200);
        db_query("UPDATE users SET banner = ? WHERE id = ?", ["banner/" . $file_name, $user['id']]);
        if ($old_banner && $old_banner != $DEFAULT_BANNER) {
            unlink($upload_dir . $old_banner);
            }
        echo json_encode(array('status' => 'success', 'message' => 'Banner upload successful', 'banner' => "banner/" . $file_name));
        exit;
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to move uploaded file'));
        http_response_code(500);
        exit;
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Error uploading file'));
    http_response_code(500);
    exit;
}
?>
