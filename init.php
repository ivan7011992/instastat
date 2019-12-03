<?php




$con = mysqli_connect("localhost", "root", "root", "instastat");

if ($con === false) {
    print("Ошибка подключения:" . mysqli_connect_error());
    die;
}

mysqli_set_charset($con, "utf8");


