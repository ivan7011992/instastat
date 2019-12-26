<?php
require_once("./../db.php");
require_once("./../helpers.php");
require_once '../vendor/autoload.php';

/** @var \Twig\Environment $twig */
$twig = include_once '../twig.php';

function CheckErrorsReg($data)
{
    $errors = [];

    if (empty($data['name'])) {
        $errors['reg-name'] = 'Введите инициалы';
    }

    if (empty($data['password'])) {
        $errors['reg-password'] = 'Введите пароль';
    }
    if (empty($data['email'])) {
        $errors['reg-email'] = 'Введите почту';
    }
    if ($data['password'] != $data['passwordConfirmation']) {
        $errors['passwordConfirmation'] = 'Пароли не совпадают';
    }

    return $errors;
}

$errors = [];
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formData = [
        'name' => $_POST['reg-name'],
        'password' => $_POST['reg-password'],
        'passwordConfirmation' => $_POST['passwordConfirmation'],
        'email' => $_POST['reg-email']
    ];

    $errors = checkErrorsReg($formData);

    if (count($errors) === 0) {
        $DB->insert("INSERT INTO app_users (name,password,email) VALUES (?,?,?)", [
            $formData['name'],
            password_hash($formData['password'], PASSWORD_DEFAULT),
            $formData['email']
        ]);

        header("Location: /index.php", true, 301);
        exit;
    }
}

$content = $twig->render('register.twig', [
    'errors' => $errors,
    'formData' => $formData,
]);

echo $content;


