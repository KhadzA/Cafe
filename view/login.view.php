<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    include "../connection/database.php";
    include "../control/login.control.php";

    $login = new LoginCtrl($username, $password);
    $login->loginUser();
}
