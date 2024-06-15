<?php
require '../../utils.php';

$me = display_user(login_required());

$badges = explode(" ", $me['status'])

?>

<!DOCTYPE html>
<html>

<head>
    <title>Me</title>
    <link rel="stylesheet" href="../static/style.css">

</head>

<body>
    <?php include '../blocks/navbar.php'; ?>
    <div class="container">
        <section class="section">

            <div class="card">
                <div class="card-image">
                    <article class="image is-16by9">
                        <img src="<?= $me['banner'] ?>" alt="User Banner">
                    </article>
                </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-left">
                            <figure class="image is-96x96">
                                <img src="<?= $me['avatar'] ?>" alt="User Avatar" class="is-rounded">
                            </figure>

                        </div>
                        <div class="media-content">
                            <h1 class="title is-1"><?= $me['uname'] ?></h1>
                            <p class="subtitle">@<?= $me['user_url'] ?></p>
                        </div>
                    </div>
                    <div class="content">
                        <p><?= $me['bio_about'] ?></p>
                        <br>
                        <div class="badges tags">
                            <?php foreach ($badges as $badge) : ?>
                                <span class="badge tag"><?= $badge ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>