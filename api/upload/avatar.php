<?php

// This api route will handle the avatar upload for users!

require "../../utils.php";

header("Content-Type: application/json");


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    http_response_code(405);
    exit;
}

$user = get_authenticated_user();

if (!$user) {
    echo json_encode(array('status' => 'error', 'message' => 'User not authenticated'));
    http_response_code(401);
    exit;
}


if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

    $upload_dir = '../../profile/';

    $DEFAULT_AVATAR = "default/default-avatar.png";


    $temp_name = $_FILES['avatar']['tmp_name'];

    $file_name = $_FILES['avatar']['name'];

    $old_avatar = $user['avatar'];

    if (move_uploaded_file($temp_name, $upload_dir . $file_name)) {
        echo json_encode(array('status' => 'success', 'message' => 'Avatar upload successful'));
        http_response_code(200);
        db_query("UPDATE users SET avatar = ? WHERE id = ?", [$file_name, $user['id']]);
        if ($old_avatar && $old_avatar != $DEFAULT_AVATAR) {
            unlink($upload_dir . $old_avatar);
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
