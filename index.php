<?php
require_once('helpers.php');
if (!array_key_exists('user', $_SESSION)) {

    header("Location: /controllers/auth.php", true, 301);
    exit;
}
$content = include_template('index.php', []);
echo $content;


