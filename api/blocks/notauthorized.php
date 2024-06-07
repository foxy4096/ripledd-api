<?php
header("HTTP/1.1 401 Not Authorized");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/style.css">

    <title>401 Unauthorized</title>
</head>

<body>
    <div class="container">
        <section class="section" style="text-align: center;">
            <h1 class="title is-1">401 Unauthorized</h1>
            <p class="subtitle">Sorry, you are not authorized to access this page.</p>
            <a href="/api/actions/login.php" class="button is-outline is-large"><span>Login</span><span class="icon"><i class="bi bi-joystick"></i></span></a>

        </section>
    </div>
</body>

</html>