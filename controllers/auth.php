<?php
require_once ("./../db.php");
require_once("./../helpers.php");
require_once '../vendor/autoload.php';


/** @var \Twig\Environment $twig */
$twig = include_once '../twig.php';

class AuthForm{
    /** @var string */
    public $email;
    /** @var string */
    public $password;

    public function __construct()
    {
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
    }
}

function checkErrorsAuth(AuthForm $formData)
{
    $errors = [];

    if (empty($formData->email)) {
        $errors['email'] = 'Введите email';
    }
    if (empty($formData->password)) {
        $errors['password'] = 'Введите пароль';
    }

    return $errors;
}


function getUser( $email)
{
    global $DB;
    $users = $DB-> select("SELECT * FROM app_users WHERE email = '%s'", $email);


    switch (count($users)) {
        case 0:
            return null;
        case 1:

            return $users[0];
        default:
            return null;
    }

}



session_start();
$errors = [];
$formData=[];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formData = new AuthForm();

    $errors = checkErrorsAuth($formData);


    if (count($errors) === 0) {
        $user = getUser( $formData->email);
        if ($user !== null) {
            if (password_verify($formData->password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: /index.php", true, 301);
                exit;
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        } else {
            $errors['email'] = 'Пользователь с указанным email не найден';
        }
    }
}

$content = $twig ->render('auth.twig', [
    'errors' => $errors,
    'formData' => $formData
]);
echo $content;