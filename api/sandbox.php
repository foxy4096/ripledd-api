<?php

require '../utils.php';
require "./blocks/routes.php";


$current_user = get_authenticated_user();
if ($current_user == null) {
    include 'blocks/notauthorized.php';
    exit;
} elseif ($current_user && !str_contains($current_user['status'], "contrib")) {
    include 'blocks/notallowed.php';
    exit;
}

$hero_colors = ['danger', 'success', 'black', 'warning', 'link'];

$random_color_idx = array_rand($hero_colors);

$hero_color = $hero_colors[$random_color_idx];

if (isset($_POST['key']) && isset($_POST['value'])) {
    if ($_POST['type'] === 'cookie') {
        setcookie($_POST['key'], $_POST['value'], time() + 3600);
    } else {
        $_SESSION[$_POST['key']] = $_POST['value'];
    }
    header('Location: sandbox.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./static/style.css">
    <title>Sandbox</title>
</head>

<body>
    <?php include "./blocks/navbar.php" ?>
    <section class="hero is-bold is-centered is-<?php echo $hero_color; ?>">
        <div class="hero-body">
            <div class="container">
                <h2 class="title">API SANDBOX</h2>
                <p class="subtitle">This API sandbox page allows you to interact with and test various functionalities of an API.</p>
            </div>
        </div>
    </section>
    <div class="container">
        <section class="section">
            <h3 class="subtitle is-3">Configure Cookie or Session</h3>
            <form method="post">
                <input type="hidden" name="setter">
                <div class="field">
                    <label class="label">Key</label>
                    <div class="control">
                        <input type="text" name="key" class="input" placeholder="Key">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Value</label>
                    <div class="control">
                        <input type="text" name="value" class="input" placeholder="Value">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Set Type</label>
                    <div class="control">
                        <div class="select">
                            <select name="type">
                                <option value="cookie">Cookie</option>
                                <option value="session" selected>Session</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <input type="submit" class="button" value="Submit">
                    </div>
                </div>
            </form>
            <br>
            <h4 class="title is-4">Result</h4>
            <code><?= json_encode($_POST) ?></code>
            <hr>
            <h4>Session</h4>
            <code>
                <?= json_encode($_SESSION) ?>
            </code>
            <hr>
            <h4>Cookie</h4>
            <code><?= json_encode($_COOKIE) ?></code>
            <hr>
            <h3 class="title is-3">Mini POST 📫</h3>
            <section id="mini-post-section">
                <label class="label">URL</label>
                <div class="field has-addons">
                    <p class="control">
                        <a class="button is-static">
                            <?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] ?>
                        </a>
                    </p>

                    <div class="control">
                        <input type="text" list="urls" id="mini-post-url" class="input" name="url" value="/api/me">
                        <datalist id="urls">
                            <?php foreach ($routes['api'] as $endpoint => $details) : ?>
                                <option value="<?= $details['url'] ?>">
                                <?php endforeach; ?>
                        </datalist>
                    </div>
                </div>
                <div class="field">
                    <label for="data" class="label">Body</label>
                    <div class="control">
                        <div name="body" id="mini-post-body" cols="30" style="height: 20vh;" rows="10" placeholder="Enter in json" class="textarea is-family-monospace">{}</div>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button" id="mini-post-append-paginator">Add Paginator</button>
                    </div>
                </div>
                <div class="field">
                    <label for="method" class="label">Method</label>
                    <div class="select">
                        <select name="method" id="mini-post-method">
                            <option value="get">GET</option>
                            <option value="post">POST</option>
                            <option value="put">PUT</option>
                            <option value="delete">DELETE</option>
                        </select>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label for="file-input-key" class="label">File Input Key</label>
                            <div class="control">
                                <input type="text" name="file-input-key" id="mini-post-file-key" class="input" placeholder="File Input Key">
                            </div>
                        </div>
                    </div>
                    <div class="column">

                        <div class="field">
                            <label class="label">File</label>
                            <div class="control">
                                <div class="file">
                                    <label class="file-label">
                                        <input type="file" id="mini-post-file" class="file-input" name="file">
                                        <span class="file-cta">
                                            <span class="file-label"> Choose a file… </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="field">
                    <div class="control">
                        <input type="submit" class="button" value="Submit" id="mini-post-submit">
                    </div>
                </div>
                <h3 class="title is-3">Result</h3>
                <div style="border: 1px black solid">
                    <pre id="mini-post-result" style="padding: 10px"></pre>
                </div>
                <div class="my-2 buttons">
                    <button class="button is-small" onclick="navigator.clipboard.writeText(document.getElementById('mini-post-result').innerText)">Copy</button>
                    <button class="button is-small is-danger is-outlined" onclick="document.getElementById('mini-post-result').textContent = ''">Clear</button>
                </div>
            </section>
            <hr>
            <?php include "./blocks/routetable.php" ?>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.8/ace.js"></script>
    <script>
        let bodyEditor = ace.edit("mini-post-body");
        bodyEditor.setTheme("ace/theme/one_dark");
        bodyEditor.session.setMode("ace/mode/json");

        function isJson(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
        document.getElementById('mini-post-append-paginator').addEventListener('click', function() {
            let body = bodyEditor.getValue();
            if (!isJson(body)) {
                alert("Body is not valid JSON");
                return;
            }
            let bodyParams = JSON.parse(body);
            bodyParams['page'] = 1;
            bodyEditor.setValue(JSON.stringify(bodyParams, null, 2));
        })
        document.getElementById('mini-post-submit').addEventListener('click', function() {
            try {

                let url = document.getElementById('mini-post-url').value;
                let method = document.getElementById('mini-post-method').value.toUpperCase();
                let body = bodyEditor.getValue();

                let bodyParams = JSON.parse(body);

                let formData = new FormData();

                let fileInput = document.getElementById('mini-post-file');
                let fileKey = document.getElementById('mini-post-file-key');

                if (fileInput.files.length > 0) {
                    formData.append(fileKey.value, fileInput.files[0]);
                }

                for (let key in bodyParams) {
                    formData.append(key, bodyParams[key]);
                }

                let queryString = Object.keys(bodyParams)
                    .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(bodyParams[key]))
                    .join('&');


                let options = {
                    method: method,
                };


                if (method === "GET") {
                    url = url + "?" + queryString;
                } else {
                    options.body = formData;
                }

                fetch(url, options)
                    .then(response => response.json())
                    .then(data => {

                        let formattedResponse = JSON.stringify(data, null, 2);
                        document.getElementById('mini-post-result').textContent = formattedResponse;
                    })
                    .catch(error => {
                        document.getElementById('mini-post-result').textContent = error;
                    });
            } catch (error) {
                document.getElementById('mini-post-result').textContent = error;

            }
        });
    </script>


</body>

</html>