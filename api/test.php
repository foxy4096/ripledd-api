<?php include("dbconn.php") ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auth_email = $_POST['email'];
    $auth_pw = $_POST['password'];
    $hashed_auth_pw = hash('sha256', $auth_pw);
    $query = "SELECT * FROM users WHERE email='$auth_email' AND password='$hashed_auth_pw'";
    $content = htmlspecialchars($_POST["content"]);
    $user = "";
    $channel = "";
    $uploaded_through_specific_channel = false;


    $rs = mysqli_query($dbconn, $query);
    $user_row = mysqli_fetch_assoc($rs);
    $user = $user_row['secure_id'];
    if ($user != "") {
        if (isset($_POST["channel_id"])) {
            $channel = $_POST["channel_id"];
            $query = "SELECT * FROM users  WHERE secure_id='$channel'";
            $rs = mysqli_query($dbconn, $query);
            $channel_row = mysqli_fetch_assoc($rs);
            if ($channel_row["owner"] == $user) {
                $uploaded_through_specific_channel = true;
            }
        }
        $target_dir = ""; // Set your target directory here
        $target_file = ""; // Set your target file here

        if ($target_file == $target_dir) {
            $target_file = "null";
        }

        $get_date = gmdate("Y-m-d");
        $get_date_two = date("Y-m-d H:i:s");
        $id_gener1 = bin2hex(random_bytes(4));
        $id_gener2 = bin2hex(random_bytes(1));
        $id_gener = $id_gener1 . $id_gener2;
        $data = $content;

        if ($uploaded_through_specific_channel) {
            $query = "INSERT INTO post_data (id, content, post_date, post_date_two, c_type, user_id)
                  VALUES('$id_gener', '$data', '$get_date', '$get_date_two', 'Automated', '$channel')";
        } else {
            $query = "INSERT INTO post_data (id, content, post_date, post_date_two, c_type, user_id)
                  VALUES('$id_gener', '$data', '$get_date', '$get_date_two', 'Automated', '$user')";
        }

        $post = mysqli_query($dbconn, $query);

        if ($post) {
            http_response_code(201);
            echo json_encode(array(
                "id" => $id_gener,
                "content" => $data,
                "post_date" => $get_date,
                "post_date_two" => $get_date_two,
                "status" => "success"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "500 Internal Server Error"));
        }
    } else {
        echo json_encode(array("error" => "401 Unauthorized"));
        http_response_code(401);
    }
} else {
    echo json_encode(array("error" => "405 Method not allowed"));
    http_response_code(405);
}
