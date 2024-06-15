<?php

require_once "dbconn.php";

session_start();


$GLOBALS['conn'] = $dbconn;
function db_query($sql, $params = array(), $single = true)
{
    $stmt = mysqli_prepare($GLOBALS['conn'], $sql);

    if (!$stmt) {
        // Handle SQL query preparation error
        return null;
    }

    // Determine parameter types dynamically based on the values passed
    $types = '';
    foreach ($params as $param) {
        if (is_int($param)) {
            $types .= 'i'; // Integer
        } elseif (is_float($param)) {
            $types .= 'd'; // Double
        } elseif (is_string($param)) {
            $types .= 's'; // String
        } else {
            $types .= 'b'; // Blob
        }
    }

    // Bind parameters with dynamically determined types to the prepared statement
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    // Execute the prepared statement
    $success = mysqli_stmt_execute($stmt);

    if (!$success) {
        // Handle SQL query execution error
        return null;
    }

    $result = mysqli_stmt_get_result($stmt);
    $affected_rows = mysqli_stmt_affected_rows($stmt);

    if ($result === false) {
        if ($affected_rows > 0) {
            return mysqli_stmt_insert_id($stmt);
        }
        // Handle result retrieval error
        return null;
    }

    if ($single) {
        $row = mysqli_fetch_assoc($result);
    } else {
        $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    mysqli_stmt_close($stmt);

    return $row;
}

function db_count($table)
{
    $sql = "SELECT COUNT(*) AS total FROM $table";
    $result = db_query($sql);

    if ($result !== null && isset($result['total'])) {
        return $result['total'];
    } else {
        // Handle error if count query fails
        return 0;
    }
}


function set_session($key, $value)
{
    $_SESSION[$key] = $value;
}

function get_request_post_data()
{
    $json = file_get_contents('php://input');

    return json_decode($json, true) ?? $_POST;
}

// USER/AUTH RELATED METHODS

function generate_secure_id($len = 10)
{
    return bin2hex(random_bytes($len));
}

function get_secure_id()
{
    return $_SESSION['secure_id'] ?? $_COOKIE['secure_id'] ?? $_SERVER['HTTP_SECURE_ID'] ?? null;
}

function get_all_users($limit = 10, $offset = 0)
{
    return db_query("SELECT * FROM users LIMIT ? OFFSET ?", [$limit, $offset], false);
}


function get_user_by_secure_id($secure_id)
{
    return db_query("SELECT * FROM users WHERE secure_id = ?", [$secure_id]);
}
function get_username_by_id($id)
{
    return db_query("SELECT * FROM users WHERE id = ?", [$id]);
}
function get_user_by_username($username)
{
    return db_query("SELECT * FROM users WHERE user_url = ?", [$username]);
}
function get_user_by_email($email)
{
    return db_query("SELECT * FROM users WHERE email = ?", [$email]);
}

function get_authenticated_user()
{
    return get_user_by_secure_id(get_secure_id()) ?? null;
}

function verify_password($password, $user)
{
    $password = hash('sha256', $password);

    return $password === $user['password'];
}

function authenticate_user($email, $password)
{
    $user = get_user_by_email($email);
    if ((!$user) || (!verify_password($password, $user))) {
        return false;
    }
    return $user;
}

function display_user($user, $exclude_fields = ['password', 'secure_id'])
{
    foreach ($exclude_fields as $field) {
        unset($user[$field]);
    }
    $user['avatar'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/profile/' .  $user['avatar'];
    $user['banner'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/profile/' .  $user['banner'];
    return $user;
}

function display_users($users, $exclude_fields = ['password', 'secure_id'])
{
    foreach ($users as $key => $user) {
        $users[$key] = display_user($user, $exclude_fields);
    }
    return $users;
}


function create_user($username, $email, $password)
{
    /* Only for signup purposes, for creating channels see the function below */
    if (!get_user_by_email($email) && !get_user_by_username($username)) {
        $secure_id = generate_secure_id();
        $password = hash('sha256', $password);
        $user_url = strtolower($username);
        $result = db_query(
            "INSERT INTO users (uname, email, password, secure_id, user_url, join_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$username, $email, $password, $secure_id, $user_url, gmdate("d/m/y"), "unver"]
        );
        if (!$result) {
            return ["status" => "error", "messages" => "User could not be created"];
        }
        return ["status" => "success", "message" => "User created successfully", "user" => get_username_by_id($result)];
    }
    return ["status" => "error", "message" => "User already exists"];
}

function get_all_posts($limit = 10, $offset = 0)
{
    return db_query("SELECT * FROM post_data LIMIT ? OFFSET ?", [$limit, $offset], false);
}

function get_post_by_id($id)
{
    return db_query("SELECT * FROM post_data WHERE id = ?", [$id]);
}


function get_all_user_posts($user_id, $limit = 10, $offset = 0)
{
    return db_query("SELECT * FROM post_data WHERE user_id = ? LIMIT ? OFFSET ?", [$user_id, $limit, $offset], false);
}
function get_all_user_posts_by_username($username, $limit = 10, $offset = 0)
{
    return db_query("SELECT * FROM post_data WHERE uname = ? LIMIT ? OFFSET ?", [$username, $limit, $offset], false);
}
function get_all_user_posts_by_secure_id($secure_id, $limit = 10, $offset = 0)
{
    return db_query("SELECT * FROM post_data WHERE user_id = ? LIMIT ? OFFSET ?", [$secure_id, $limit, $offset], false);
}

function user_own_this_channel($user_id, $channel_id)
{

    return db_query("SELECT * FROM users WHERE secure_id = ? AND owner = ?", [$channel_id, $user_id]) ?? null;
}

function create_post($user_id, $content, $category = "")
{
    $id_gener1 = bin2hex(random_bytes(4));
    $id_gener2 = bin2hex(random_bytes(1));
    $id = $id_gener1 . $id_gener2;
    $get_date = gmdate("Y-m-d");
    $get_date_two = date("Y-m-d H:i:s");
    $result =  db_query(
        "INSERT INTO post_data (id, user_id, content, post_date, post_date_two, posted_by, c_type) VALUES (?, ?, ?, ?, ?, ?, ?)",
        [$id, $user_id, $content, $get_date, $get_date_two, get_username_by_id($user_id)['uname'], $category]
    );
    return [$result, get_post_by_id($id)];
}

function require_post()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        http_response_code(405);
        exit;
    }
}
function require_get()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        http_response_code(405);
        exit;
    }
}


function create_channel($user_id, $channel_name, $channel_username, $limited = false)
{
    $secure_id = generate_secure_id() . "-c-sub";
    $channel_type = $limited ? "limited" : "sub-basic";
    $result = db_query(
        "INSERT INTO users (uname, secure_id, user_url, join_date, owner, type) VALUES (?, ?, ?, ?, ?, ?)",
        [$channel_name, $secure_id, htmlspecialchars($channel_username), gmdate("d/m/y"), $user_id, $channel_type]
    );
    if (!$result) {
        return ["status" => "error", "messages" => "Channel could not be created"];
    }
    return ["status" => "success", "message" => "Channel created successfully", "user" => get_username_by_id($result)];
}

function get_stats()
{
    $posts_count = db_count('post_data');
    $users_count = db_count('users');
    return array('users' => $users_count, 'posts' => $posts_count);
}

function is_image($path)
{
    $image_info = getimagesize($path);
    return $image_info !== false;
}


function login_required()
{
    $user = get_authenticated_user();
    if (!$user) {
        echo json_encode(['error' => 'User not authenticated']);
        http_response_code(401);
        exit;
    }
    return $user;
}


function get_all_user_channels($user_id, $limit = 10, $offset = 0, $paginate = false)
{
    if ($paginate) {
        $offset = ($offset - 1) * $limit;
        return db_query("SELECT * FROM users WHERE owner = ? LIMIT ? OFFSET ?", [$user_id, $limit, $offset], false);
    } else {
        return db_query("SELECT * FROM users WHERE owner = ?", [$user_id], false);
    }
}
