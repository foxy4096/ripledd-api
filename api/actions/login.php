<?php
require '../../utils.php';


?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="../static/style.css">

</head>

<body>
    <?php include '../blocks/navbar.php'; ?>
    <div class="container">
    <section class="section">

            <h2 class="title is-2">Login</h2>
            <div class="column is-one-third">

                <form method="post" action="/api/login.php">
                    <input type="hidden" name="next" value="/api/sandbox.php">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" name="email" type="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" name="password" type="password" placeholder="Password">
                        </div>
                    </div>

                    <button type="submit" class="button is-white is-fullwidth">Login</button>
                </form>
            </div>
        </section>
    </div>
</body>

</html>