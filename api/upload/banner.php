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

    $upload_dir = '../../profile/banner';

    $DEFAULT_BANNER = "default/default-banner.png";


    $temp_name = $_FILES['banner']['tmp_name'];

    $file_name = $_FILES['banner']['name'];

    $old_banner = $user['banner'];

    if (move_uploaded_file($temp_name, $upload_dir . $file_name)) {
        echo json_encode(array('status' => 'success', 'message' => 'Banner upload successful'));
        http_response_code(200);
        db_query("UPDATE users SET banner = ? WHERE id = ?", [$file_name, $user['id']]);
        if ($old_banner && $old_banner != $DEFAULT_BANNER) {
            unlink($upload_dir . $old_banner);
        }
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
