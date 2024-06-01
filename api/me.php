<?php

require '../utils.php';

header('Content-Type: application/json');


$user = get_authenticated_user();

if (empty($user)) {
    echo json_encode(array('error' => 'Unauthenticated.'));
    http_response_code(401);
    exit;
}

echo json_encode(display_user($user));
exit;
