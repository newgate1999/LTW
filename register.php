<?php
include('login_controller.php');
include('nav_bar.php');
include('connection.php');
if (isset($_POST['phone'])) {
    $password = mysqli_real_escape_string($db, password_hash($_POST['password'], PASSWORD_DEFAULT));
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $role = mysqli_real_escape_string($db, "guest");
    mysqli_query($db, "INSERT INTO users(name, email, password, phone, role) VALUES('$name', '$email', '$password', '$phone', '$role')");
    header("Location: ./index.php");
    exit();
}
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
        <form method="post">
            <div class="row text-center" style="margin-bottom: 50px">
                <img src="images/logo.png" alt="Logo">
            </div>
            <h2 class="text-center" style="padding-bottom: 10px">Đăng ký</h2>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <label>
                            Họ và tên:
                        </label>
                        <input name="name" type="text" class="form-control" placeholder="Email" required="required">

                    </div>
                    <div class="col-sm-6">
                        <label>
                            SĐT:
                        </label>
                        <input name="phone" type="text" class="form-control" placeholder="SĐT" required="required">

                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>
                    Email:
                </label>
                <input name="email" type="text" class="form-control" placeholder="Email" required="required">

            </div>
            <div class="form-group">
                <label>
                    Mật khẩu:
                </label>
                <input name="password" type="password" class="form-control" placeholder="Mật khẩu" required="required">

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
            </div>
            <div class="row">
                <div class="col-sm-12" style="text-align: right">
                    <a href="#">Quên mật khẩu?</a>
                </div>
            </div>
            <div class="row text-center">
                <span>Đã có tài khoản? <a href="login.php">Đăng nhập</a></span>
            </div>
        </form>
    </div>
</div>
</body>
</html>