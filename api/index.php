<?php
require "../utils.php";
$domain = "https://ripledd.com";
$title_size = 1
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/style.css">

    <title>API Index</title>
</head>

<body>
    <div class="container">
        <section class="section" style="text-align: center;">
            <a href="/api/sandbox.php" class="button is-outline is-large mb-3"><span>Sandbox</span><span class="icon"><i class="bi bi-joystick"></i></span></a>
            <?php include "./blocks/routetable.php" ?>
        </section>
        <hr>
        <section class="section">

            <h3 class="title is-3">Authorization and Authentication</h3>
            <p>
                For getting the secure ID, you need to do the following request to
                <code><?= $_SERVER['REQUEST_SCHEME'] ?>://<?= $_SERVER['SERVER_NAME'] ?>/api/login.php</code>

                Send your following credentials:
                <br>
                <br>
            <div style="border: 1px black solid; width: fit-content; border-radius: 10px;">
                <pre style="padding: 10px; border-radius: inherit;">{
    <span style="color: rgb(224 86 67);">"email"</span>: <span style="color: rgb(120 195 121);">"example@mail.com"</span>,
    <span style="color: rgb(224 86 67);">"password"</span>: <span style="color: rgb(120 195 121);">"XXXXXXXX"</span>,
}</pre>
            </div>
            <br>
            You will get the following response:
            <br>
            <br>

            <div style="border: 1px black solid; width: fit-content; border-radius: 10px;">
                <pre style="padding: 10px; border-radius: inherit;">
{
  "id": ,
  "email": "jhondoe@mail.com",
  "uname": "Jhon Doe",
  "avatar": "http://localhost/profile/jhon.png",
  "banner": "http://localhost/profile/default/default-banner.png",
  "secure_id": "12345",
  "user_url": "jhondoe",
  "followers": 3000,
  "quote_text": "I love my wife Jane Doe.",
  "bio_link": "johndoe.com",
  "bio_about": "Your friendly neighbourhood John Doe.,
  "join_date": 01-06-2015,
  "status": "verified",
  "restriction": null,
  "owner": null,
  "type": null,
  "change_id": null
}
</pre>

                </p>
        </section>
    </div>
</body>

</html>