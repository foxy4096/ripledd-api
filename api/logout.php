<?php
session_start();
session_unset();
session_destroy();
session_write_close();
setcookie(session_name(), '', 0, '/');

echo json_encode(array('status' => 'success', 'message' => 'Logged out', 'data' => null, 'code' => 200, 'error' => null, 'success' => true), JSON_PRETTY_PRINT);

exit;
