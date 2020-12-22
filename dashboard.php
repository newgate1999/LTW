<?php
require_once('models.php');
include('auth.php');
?>
<body style="background: #f4f9fd">
<header>
    <?php include('nav_bar.php'); ?>
</header>
<div class="container-fluid">
    <div class="row">
        <div class="furniture-box">
            <div class="terms-title">
                <div class="container">
                    <div class="row">
                        <ol class="breadcrumb">
                            <li><a href="#">Trang chủ</a></li>
                            <li class="active">Bảng điều khiển</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2 furniture-box" style="padding-left: 40px">
            <nav class="navbar-default">
                <ul class="nav navbar">
                    <li class="nav-box nav-active">
                        <a>Bảng điều khiển</a>
                    </li>
                    <li class="nav-box">
                        <a href="invoice.php">Hóa đơn</a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php
        require_once('order_controller.php');
        $order_controller = new OrderController();
        $result = $order_controller->get_orders(null);
        $rows = mysqli_fetch_all($result);
        $total = count($rows);
        ?>
        <div class="col-sm-9" style="margin-top: 5px;padding-left: 40px">
            <div class="container-fluid furniture-box">
                <h2>Tổng quan</h2>
                <div class="row">
                    <div class="col-sm-3">
                        <h4>Tổng số:</h4>
                        <p><?=count($rows)?></p>
                    </div>
                    <div class="col-sm-3">
                        <h4>Đang xác nhận:</h4>
                        <p><?php $result = $order_controller->get_orders(['status_name' => 'Đang xác nhận']);
                        $rows = mysqli_fetch_all($result);
                        $confirmming = count($rows);
                        echo(count($rows));
                        ?></p>
                    </div>
                    <div class="col-sm-3">
                        <h4>Đang giao:</h4>
                        <p><?php $result = $order_controller->get_orders(['status_name' => 'Đang giao']);
                            $rows = mysqli_fetch_all($result);
                            $shipping = count($rows);
                            echo(count($rows));
                            ?></p>
                    </div>
                    <div class="col-sm-3">
                        <h4>Đã giao:</h4>
                        <p><?php $result = $order_controller->get_orders(['status_name' => 'Đã giao']);
                            $rows = mysqli_fetch_all($result);
                            $shipped = count($rows);
                            echo(count($rows));
                            ?></p>
                    </div>
                </div>

                <?php $confirming_percentage = round($confirmming / $total * 100, PHP_ROUND_HALF_UP);
                $shipping_percentage = round($shipping / $total * 100, PHP_ROUND_HALF_UP);
                $shipped_percentage = round($shipped / $total * 100, PHP_ROUND_HALF_UP); ?>

                <h2>Thống kê</h2>
                <div class="row">
                    <div class="col-sm-12">
                        <div style="width:10px;height: 10px;background: #5cb85c; display: inline-block"></div>
                        <span style="margin-left: 10px;vertical-align: middle;">Đang xác nhận</span>
                        <div style="margin-left: 20px;width:10px;height: 10px;background: #d9534f; display: inline-block; vertical-align: middle"></div>
                        <span style="margin-left: 10px;vertical-align: middle;">Đang giao</span>
                        <div style="margin-left: 20px;width:10px;height: 10px;background: #0275d8; display: inline-block; vertical-align: middle"></div>
                        <span style="margin-left: 10px;vertical-align: middle;">Đã giao</span>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="progress" style="height: 20px">
                        <div class="progress-bar" role="progressbar" style="width:<?=$confirming_percentage?>%; background: #5cb85c"> <?=$confirming_percentage?>% </div>
                        <div class="progress-bar" role="progressbar" style="width:<?=$shipping_percentage?>%; background: #d9534f""> <?=$shipping_percentage?>% </div>
                        <div class="progress-bar" role="progressbar" style="width:<?=$shipped_percentage?>%; background: #0275d8""> <?=$shipped_percentage?>% </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <a href="add_new_product.php"><i class="fa fa-plus"></i> Thêm mặt hàng mới </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>