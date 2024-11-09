<?php

if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    include "../connection/database.php";
    include "../control/signup.control.php";

    $signup = new signupCtrl($username, $email, $password, $confirmPassword);

    $signup->signupUser();

    header("location: ../");

}