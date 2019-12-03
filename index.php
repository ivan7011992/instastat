<?php
require_once ("init.php");
require_once ("helpers.php");


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

    if (!password_verify($_POST['password'], $user['password'])) {
        $errors['password'] = 'Неверный пароль';
        return $errors;
    }

    session_start();
    $_SESSION['user'] = $user;

    exit();
}

$errors=[];

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $errors = checkErrorsAuth($con);
    header("Location: /sucsess.php", true, 301);
}


?>

<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>


</head>
<body>
<a href="controllers/register.php">Регистрация</a>


<form method="POST" enctype="multipart/form-data" action="index.php">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"  value="<?= $password['email'] ?? '' ?>">
            <?php if (array_key_exists('email', $errors)): ?>
             <p> <?= $errors['email'] ?></p>
            <?php endif ?>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input  name= 'password' type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="<?= $password['password'] ?? '' ?>">
            <?php if (array_key_exists('password', $errors)): ?>
                <p class="form__message">Неверный пароль</p><?= $errors['password'] ?></p>
            <?php endif ?>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

</form>


</body>


</html>

<!--кнопки авторизация и регистраци-->
<!--репозитоий-->
<!--регистрая сделать таблицу-->