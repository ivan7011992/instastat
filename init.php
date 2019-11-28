<?php




$con = mysqli_connect("localhost", "root", "root", "things");

if ($con === false) {
    print("������ �����������:" . mysqli_connect_error());
    die;
}

mysqli_set_charset($con, "utf8");


