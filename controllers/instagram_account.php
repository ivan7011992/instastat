<?php
require_once("./../db.php");
require_once("./../helpers.php");
require_once '../vendor/autoload.php';

$twig = include_once '../twig.php';

session_start();

if (empty($_SESSION['user'])) {

    header("Location: /conrollers/auth.php", true, 301);
    die();
}

if (empty($_GET['account_name'])) {
    echo 'account name is mot set';
    die();
}

$accountName = $_GET['account_name'];

$accountData = null;

$instagramAccounts = $DB->select("SELECT * FROM instagram_account where login = ? ", [$accountName]);

if (count($instagramAccounts) !== 0) {
    $accountData['account'] = $instagramAccounts[0];

    $GetUserId = $instagramAccounts[0]['id'];
    $GetMedia = $DB->select("SELECT * from instagram_media where account_id=?", [$GetUserId]);

    $accountData['medias'] = $GetMedia;
}

$content = $twig->render('instagram_account.twig', [
    'accountData' => $accountData
]);


echo $content;;