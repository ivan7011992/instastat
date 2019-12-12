<?php
require_once('helpers.php');
require_once("init.php");
require_once 'vendor/autoload.php';

$twig = include_once 'twig.php';

function getprofile($con, $userid)
{
    $sql = "SELECT * FROM profile_link where user_id = $userid";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        $error = myqli_error($con);
        echo "Ошибка MySQL" . $error;
        die;

    }
    $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $profile = [];

    foreach ($results as $result) {
        $profile[] = $results;

    }
    return $profile;
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

    if(strpos($userName, "/") !== false){
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
    if ($userName !== null) {
        $stmt = db_get_prepare_stmt($con, "INSERT INTO profile_link (account_name) VALUES (?)", [
            $userName
        ]);
        if (!$stmt) {
            $errors = mysqli_error($con);
            echo "Ошибка MySQL:" . $errors;
            die;
        }
        $insertResult = mysqli_stmt_execute($stmt);
        if (!$insertResult) {

            $errors = mysqli_stmt_error($stmt);
            echo "Ошибка MySQL:" . $errors;
            die;

        }
    }
}
$profiles = getprofile($con, $_SESSION['user']['id']);

$content = $twig->render('index.twig', [
    'formData' => $formData,
    'profiles' => $profiles,
    'errors' =>$errors
]);
echo $content;


