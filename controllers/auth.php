<?php
require_once('init.php');
require_once('helpers.php');

/**
 *
 * Валидация формы авторизиции.
 * @param $con
 * @return array
 */
function checkErrorsAuth($con)
{
    $errors = [];

    if (empty($_POST['email'])) {
        $errors['email'] = 'Введите email';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Введите пароль';
    }

    return $errors;
}

/**
 * Получение  пользователя с заданным email.
 * @param $con
 * @param $email
 * @return |null
 */
function getUser($con, $email)
{
    $sql = sprintf("SELECT * FROM users WHERE email = '%s'", $email);
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

/**
 * Расширенная проверка авторизации пользователя.
 * @param $con
 * @return array
 */
function checkAuth($con)
{
    $errors = checkErrorsAuth($con);

    if (count($errors) !== 0) {
        return $errors;
    }

    $user = getUser($con, $_POST['email']);
    if ($user === null) {
        $errors['email'] = 'Пользователь с указанным email не найден';
        return $errors;
    }

      $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    if (!password_verify($password, $user['password'])) {
        $errors['password'] = 'Неверный пароль';
        return $errors;
    }

    session_start();
    $_SESSION['user'] = $user;
    header("Location: / index.php", true, 301);
    exit();

}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = checkAuth($con);


}

//if (!empty($_POST['email'])){
//    $email = $_POST['email']; } else{$email = null;}
//if (!empty($_POST['password'])){
//    $password = $_POST['password']; } else{$password = null;}




$content = include_template('index.php', [
    'errors' => $errors,
    'password' => $_POST,
    'email' => $_POST

]);


echo $content;
