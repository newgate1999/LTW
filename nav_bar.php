<?php
    include('login_controller.php');
    require_once 'models.php';

if(!isset($_SESSION))
{
    session_start();
}

if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="vi">
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
    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-12 left-rs">
                    <div class="navbar-header">
                        <button type="button" id="top-menu" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="index.php" class="navbar-brand"><img src="images/logo.png" alt="" /></a>
                    </div>
                    <form class="navbar-form navbar-left web-sh" method="post">
                        <div class="form">
                            <input type="text" id="nav-search" class="form-control" placeholder="Tìm sản phẩm">
                        </div>
                    </form>
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="right-nav">
                        <?php
                        if (!$_SESSION['logged_in']) : ?>
                            <div class="login-sr">
                                <div class="login-signup">
                                    <ul>
                                        <li> <a href="category.php?type=all"> <span>Danh mục sản phẩm</span> </a> </li>
                                        <li><a href="login.php">Đăng nhập</a></li>
                                        <li><a class="custom-b" href="#">Đăng kí</a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php
                        else : ?>
                        <div class="login-sr">
                            <div class="login-signup">
                                <ul>
                                    <li>
                                        <a class="custom-b" href="index.php?logout='1'">Đăng xuất</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="nav-b hidden-xs" id="cart-div">
                            <div class="nav-box" id="cart-badge">
                                <ul>
                                    <li><a class="custom-b" href="dashboard.php">Xin chào <?php echo $_SESSION['user']->getName(); ?></a></li>
                                    <li>
                                        <a class="custom-b" href="cart_view.php">
                                            <i class="fa fa-shopping-cart"></i>
                                            <span> Giỏ hàng </span>
                                            <span class="badge"><?php if (isset($_SESSION['cart'])) echo($_SESSION['cart']->totalQuantity)?></span>
                                        </a>
                                    </li>
                                    <li> <a href="category.php?type=all"> <span>Danh mục sản phẩm</span> </a> </li>

                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="help-r hidden-xs">
                            <div class="help-box">
                                <ul>
                                    <li> <a href="#"><img class="h-i" src="images/help-icon.png" alt="" /> Trợ giúp </a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="nav-b hidden-xs">
                            <div class="nav-box">
                                <ul>
                                    <li><a href="howitworks.html">Điều khoản</a></li>
                                    <li><a href="about-us.html">Trở thành cộng tác viên</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="login-sr">
                            <div class="login-signup">
                                    <button class="search_button" onclick="search()"><span class="glyphicon glyphicon-search"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/.container-fluid -->
    </nav>
<script>
    function search() {
        name = $("#nav-search").val();
        window.location.assign('category.php?type=all&name='+name);
    }
</script>
</body>
</html>