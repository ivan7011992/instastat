<?php
require_once("C:\Users\ivasilev\Desktop\OSPanel\domains\instastat\init.php");
require_once("C:\Users\ivasilev\Desktop\OSPanel\domains\instastat\helpers.php");


$errors = [];
$con = mysqli_connect("localhost", "root", "", "instastat");
function CheckErrorsReg($con)
{

    $errors = [];

    if (empty($_POST['reg-name'])) {
        $errors['reg-name'] = $Regresult = 'Введите инициалы';
    }
    if (empty($_POST['reg-area'])) {
        $errors['reg-area'] = $Regresult = 'Введите район проживания';
    }
    if (empty($_POST['reg-password'])) {
        $errors['reg-password'] = $Regresult = 'Введите пароль';
    }


    if (empty($_POST['reg-email'])) {
        $errors['reg-email'] = 'Введите почту';
    }

    return $errors;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = checkErrorsReg($con);
    $name = $_POST['reg-name'];
    $area = $_POST['reg-area'];
    $password = $_POST['reg-password'];
    $email = $_POST['reg-email'];


    if (count($errors) === 0) {
        $errors = [];

        $Regresult = 'Абонент зарегистрирован';
        $stmt = db_get_prepare_stmt($con, "INSERT INTO app_users (name,area,password,email) VALUES (?,?,?,?)", [

            $name,
            $area,
            $password,
            $email


        ]);
        if (!$stmt) {
            $error = mysqli_error($con);
            echo "Ошибка MySQL:" . $error;
            die;
        }
        $insertResult = mysqli_stmt_execute($stmt);
        header("Location: /sucsess.php", true, 301);
        exit;
    }
}
$errors []= null;

    $content = include_template('register.php', [

        'errors' => $errors,
        'name' => $name,
        'area' => $area,
        'password' => $password,
        'email' => $email


    ]);

    echo $content;

