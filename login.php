<?php
    require_once('models.php');
    include('login_controller.php');
    include('nav_bar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chamb - Responsive E-commerce HTML5 Template</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--enable mobile device-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--fontawesome css-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!--bootstrap css-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--animate css-->
    <link rel="stylesheet" href="css/animate-wow.css">
    <!--main css-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/slick.min.css">
    <!--responsive css-->
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body style="background: #f4f9fd">
<div class="row-sm">
    <div class="col-sm" style="padding: 20px 600px 0px 600px">
    <form action="#" method="post">
        <div class="row text-center" style="margin-bottom: 50px">
            <img src="images/logo.png" alt="Logo">
        </div>
        <h2 class="text-center" style="padding-bottom: 10px">Đăng nhập</h2>
        <div class="form-group">
            <input name="username" type="text" class="form-control" placeholder="Tên đăng nhập" required="required">
        </div>
        <div class="form-group">
            <input name="password" type="password" class="form-control" placeholder="Mật khẩu" required="required">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        </div>
        <div class="row">
            <div class="col-sm-12" style="text-align: right">
                <a href="#">Quên mật khẩu?</a>
            </div>
        </div>
        <div class="row text-center">
            <span>Chưa có tài khoản? <a href="register.php">Đăng kí</a></span>
        </div>
    </form>
    </div>
</div>
</body>
</html>