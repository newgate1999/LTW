<?php
require('connection.php');
require_once('models.php');
if(!isset($_SESSION))
{
    session_start();
}
if (isset($_POST["username"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $username_sql = mysqli_real_escape_string($db, $username);
    $password_sql = mysqli_real_escape_string($db, $password);
    $result = mysqli_query($db, "SELECT * FROM users WHERE email= '$username_sql' AND password='$password_sql' LIMIT 1");

    if (mysqli_num_rows($result) > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = new User($user['email'], $user['password']);
        $_SESSION['user']->setId($user['id']);
        $_SESSION['user']->setName($user['name']);
        $_SESSION['user']->setEmail($user['email']);
        $_SESSION['user']->setPhone($user['phone']);
        $_SESSION['logged_in'] = true;
        $_SESSION['name'] = $result->fetch_assoc()['name'];

        header("Location: index.php");
    }
    else {
        echo "Đăng nhập thất bại";
    }
}
