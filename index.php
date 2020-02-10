<?php
require_once('helpers.php');
require_once("db.php");
require_once 'vendor/autoload.php';

$twig = include_once 'twig.php';

function getProfileLinksForUser($userid)
{
    global $DB;

    $results = $DB->select("SELECT * FROM profile_link where user_id = ? ", [$userid]);
    return $results;
}

function parseUserName(string $url, array &$errors): ?string
{

    $profile_link = parse_url($url);
    if (!isset($profile_link['scheme'])) {
        $errors['user_link'] = 'Неправильная ссылка';
        return null;
    }

    if ($profile_link['scheme'] !== 'https') {
        $errors['user_link'] = 'Неправильная ссылка';
        return null;
    }
    if (!isset($profile_link['host'])) {
        $errors['user_link'] = 'Неправильная ссылка';
        return null;
    }
    if ($profile_link['host'] !== 'www.instagram.com') {
        $errors['user_link'] = 'Неправильная ссылка';
        return null;
    }
    $userName = trim($profile_link['path'], "/\t\n\r ");

    if (strpos($userName, "/") !== false) {
        $errors['user_link'] = 'Неправильная ссылка';
        return null;
    }
    return $userName;

}

session_start();

if (!array_key_exists('user', $_SESSION)) {
    header("Location: /controllers/auth.php", true, 301);
    exit;
}

$errors = [];
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = [
        'user_link' => trim($_POST['user_link'])
    ];

    if (empty($formData['user_link'])) {
        $errors['user_link'] = 'Введите ссылку на профиль';
    }

    // parse_url -извлечт имя пользователя из url https://www.instagram.com/hatch95/

    $userName = parseUserName($formData['user_link'], $errors);
    $userid = $_SESSION['user']['id'];


    if ($userName !== null) {
        $existingAccounts = $DB->select('select id from profile_link where account_name=? 
and user_id=?', [$userName, $userid]);

        if (count($existingAccounts) > 0) {
            $errors['user_link'] = 'Данный аккаунт уже добавлен';
        } else {

            $DB->insert("INSERT INTO profile_link (account_name,user_id) VALUES (?,?)", [
                $userName,
                $userid

            ]);
        }
    }
}
$profiles = getProfileLinksForUser($_SESSION['user']['id']);


$content = $twig->render('index.twig', [
    'formData' => $formData,
    'profiles' => $profiles,
    'errors' => $errors
]);


echo $content;


