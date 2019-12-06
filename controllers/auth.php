<?php
require_once("init.php");
require_once("helpers.php");

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


function getUser($con, $email)
{
    $sql = sprintf("SELECT * FROM app_users WHERE email = '%s'", $email);
    $result = mysqli_query($con, $sql);
    if (!$result) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formData = new AuthForm();

    $errors = checkErrorsAuth($formData);


    if (count($errors) === 0) {
        $user = getUser($con, $formData->email);
        if ($user !== null) {
            if (password_verify($formData->password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: /index.php", true, 301);
            } else {
                $errors['password'] = 'Неверный пароль';
            }
        } else {
            $errors['email'] = 'Пользователь с указанным email не найден';
        }
    }
}

$content = include_template('auth.php', [
    'errors' => $errors,
    'formData' => $formData
]);
echo $content;