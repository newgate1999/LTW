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
    $result = mysqli_query($db, "SELECT * FROM users WHERE email= '$username_sql' LIMIT 1");

    if (mysqli_num_rows($result) > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = new User($user['email'], $user['password']);
            $_SESSION['user']->setId($user['id']);
            $_SESSION['user']->setName($user['name']);
            $_SESSION['user']->setEmail($user['email']);
            $_SESSION['user']->setPhone($user['phone']);
            $_SESSION['user']->setRole($user['role']);
            $_SESSION['logged_in'] = true;
            $_SESSION['name'] = $result->fetch_assoc()['name'];
            $message = "Đăng nhập thành công";
        }
        else
            $message = " Sai tên đăng nhập hoặc mật khẩu";


        header("Location: index.php");
        exit();
    }
    else {
       $message = "Không thể tìm thấy tài khoản";
    }
    $_SESSION['message'] = $message;
    session_commit();
}

