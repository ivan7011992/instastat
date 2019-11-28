<?php
require_once("init.php");
require_once("helpers.php");


$errors = [];

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

    if (empty($_POST ['reg-phone'])) {
        $errors['reg-phone'] = 'Введите телефон';
    }


    if (empty($_POST['reg-email'])) {
        $errors['reg-email'] = 'Введите почту';
    }

    return $errors;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = checkErrorsReg($con);
    $name = $_POST['reg-name'];
    $area = $_POST['reg-area'];
    $password = $_POST['reg-password'];
    $email = $_POST['reg-email'];
    $phone = $_POST ['reg-phone'];


    if (count($errors) === 0) {

        $Regresult = 'Абонент зарегистрирован';
        $stmt = db_get_prepare_stmt($con, "INSERT INTO CUSTOMER (name,area,password,email,phone) VALUES (?,?,?,?,?)", [

            $name,
            $area,
            $password,
            $email,
            $phone


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

?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Анкета</title>




</head>
<body>

<div class="container">
    <form method="POST" enctype="multipart/form-data" action="register.php">
        <ul class="flex-outer">

            <li>
                <label for="reg-name">ф.И.О.</label>
                <input class="<?php if (array_key_exists('reg-name', $errors)): ?> form__input__error <?php endif ?>"
                       type="text"
                       name="reg-name"
                       id="reg-name"
                       value="<?= $_POST['reg-name'] ?? '' ?>">
                <?php if (array_key_exists('reg-name', $errors)): ?>
                    <p class="form__message"><?= $errors['reg-name'] ?></p>
                <?php endif ?>
            </li>
            <li>
                <label for="reg-area">Район</label>
                <input class="<?php if (array_key_exists('reg-area', $errors)): ?> form__input__error <?php endif ?>"
                       type="text"
                       name="reg-area"
                       id="reg-area"
                       value="<?= $_POST['reg-area'] ?? '' ?>">
                <?php if (array_key_exists('reg-area', $errors)): ?>
                    <p class="form__message"><?= $errors['reg-area'] ?></p>
                <?php endif ?>
            </li>
            <li>
                <label for="reg-password">Пароль</label>
                <input class="<?php if (array_key_exists('reg-password', $errors)): ?> form__input__error <?php endif ?>"
                       type="text"
                       name="reg-password"
                       id="reg-password"
                       value="<?= $_POST['reg-password'] ?? '' ?>">
                <?php if (array_key_exists('reg-password', $errors)): ?>
                    <p class="form__message"><?= $errors['reg-password'] ?></p>
                <?php endif ?>
            </li>
            <li>
                <label for="reg-phone">Телефон</label>
                <input class="test <?php if (array_key_exists('reg-phone', $errors)): ?> form__input__error <?php endif ?>"
                       style="flex:0"
                       type="text"
                       name="reg-phone"
                       id="reg-phone"
                       value="<?= $_POST['reg-phone'] ?? '' ?>"
                       placeholder="XX-XXXXXXX">
                <?php if (array_key_exists('reg-phone', $errors)): ?>
                    <p class="form__message"><?= $errors['reg-phone'] ?></p>
                <?php endif ?>
            </li>
            <li>
                <label for="reg-email">Email</label>
                <input class="test <?php if (array_key_exists('reg-email', $errors)): ?> form__input__error <?php endif ?>"
                       style="flex:0"
                       type="text"
                       name="reg-email"
                       id="reg-email"
                       value="<?= $_POST['reg-email'] ?? '' ?>">
                <?php if (array_key_exists('reg-email', $errors)): ?>
                    <p class="form__message"><?= $errors['reg-email'] ?></p>
                <?php endif ?>
            </li>



            <?php if (!empty($errors)): ?>
                <p class="error-message">Пожалуйста, исправьте ошибки в форме</p>
            <?php endif ?>
            <li>
                <button type="submit">Submit</button>
            </li>
        </ul>
    </form>
</div>


</body>
</html>