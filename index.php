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


session_start();

if (!array_key_exists('user', $_SESSION)) {
    header("Location: /controllers/auth.php", true, 301);
    exit;
}

$error = [];
$formData=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData=[
        'user_link' => trim($_POST['user_link'])
    ];

    if (empty($formData['user_link'])) {
        $error['user_link'] = 'Введите ссылку на профиль';
    }

    // parse_url -извлечт имя пользователя из url https://www.instagram.com/hatch95/
    $profile_link = $formData['user_link'];
    $stmt = db_get_prepare_stmt($con, "INSERT INTO profile_link (account_name) VALUES (?)", [
        $profile_link
    ]);
    if (!$stmt) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }
    $insertResult = mysqli_stmt_execute($stmt);
    if (!$insertResult) {

        $error = mysqli_stmt_error($stmt);
        echo "Ошибка MySQL:" . $error;
        die;

    }
}

$profiles = getprofile($con, $_SESSION['user']['id']);

$content = $twig->render('index.twig', [
    'formData' => $formData,
    'profiles' => $profiles
]);
echo $content;


