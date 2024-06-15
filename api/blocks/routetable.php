<?php include "routes.php" ?>

<h3 class="title is-<?= $title_size ?? 3 ?>">API Routes</h3>
<div style="overflow: auto;">

    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>API Endpoint</th>
                <th>Description</th>
                <th>Arguments</th>
                <th>Request Method</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($routes['api'] as $endpoint => $details) : ?>
                <tr>
                    <td><code><?= $details['url'] ?></code></td>
                    <td><?= $details['description'] ?></td>
                    <td><code><?= $details['arguments'] ?></code></td>
                    <td><?= $details['method'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<br>
<h3 class="title is-3 has-text-centered">Stats</h3>
<nav class="level is-mobile">
    <div class="level-item has-text-centered">
        <div>
            <p class="heading">Users</p>
            <p class="title"><?= get_stats()['users'] ?></p>
        </div>
    </div>
    <div class="level-item has-text-centered">
        <div>
            <p class="heading">Posts</p>
            <p class="title"><?= get_stats()['posts'] ?></p>
        </div>
    </div>
</nav>