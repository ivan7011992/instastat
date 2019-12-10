<?php
require_once('helpers.php');
if (!array_key_exists('user', $_SESSION)) {

    header("Location: /controllers/auth.php", true, 301);
    exit;
}
if(empty($_POST['user_link'])){

    $error = $_POST['Введите логин'];
}
$error=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    $profile_link = $_POST['user_link'];
    $stmt = db_get_prepare_stmt($con, "INSERT INTO profile_link (name_link) VALUES (?)", [
        $profile_link


    ]);
    if (!$stmt) {
        $error = mysqli_error($con);
        echo "Ошибка MySQL:" . $error;
        die;
    }
    $insertResult = mysqli_stmt_execute($stmt);
    if(!$insertResult){

        $error = mysqli_stmt_error($stmt);
        echo "Ошибка MySQL:". $error;
        die;

    }
}

    $content = include_template('index.php', [
            'user_link' => $_POST
    ]);
echo $content;
?>

