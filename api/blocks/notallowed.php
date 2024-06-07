<?php
header("HTTP/1.1 403 Forbidden");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <link rel="stylesheet" href="./static/style.css">
</head>

<body>
    <div class="container">
        <section class="section" style="text-align: center;">
            <h1 class="title is-1">403 Forbidden</h1>
            <p class="subtitle">Sorry, you don't have permission to access this resource.</p>
            <div class="buttons" style="justify-content: center;">
                <a href="/" class="button is-white">
                    <span>Go to Homepage</span>
                    <span class="icon"><i class="bi bi-house-door-fill"></i></span>
                </a> or <a href="/api/actions/login.php" class="button">
                    <span>Login as another user</span>
                    <span class="icon"><i class="bi bi-person-badge"></i></span>
                </a>
            </div>
            <!-- Currently authenticated as -->
            <p class="subtitle">
                Currently authenticated as <span class="tag is-large user-mention">
                    <span class="icon user-mention-image">
                        <img src="/profile/<?= get_authenticated_user()["avatar"] ?>" alt="Auth User" class="user-mention-image" style="border-radius: 100%;">
                    </span>
                    <span>

                        <b><?= get_authenticated_user()["user_url"] ?></b>
                    </span>
                </span>
            </p>

        </section>
    </div>
</body>

</html>