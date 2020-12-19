<?php
require_once('models.php');
include('nav_bar.php');
?>
<body style="background: #f4f9fd">
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
        <div class="col-sm-9" style="margin-top: 5px;padding-left: 40px">
            <div class="container-fluid furniture-box">
                <h2>Tổng quan</h2>
                <div class="row">
                    <div class="col-sm-4">
                        <h4>Tổng số:</h4>
                        <p>2</p>
                    </div>
                    <div class="col-sm-4">
                        <h4>Chưa trả:</h4>
                        <p>1</p>
                    </div>
                    <div class="col-sm-4">
                        <h4>Đã trả:</h4>
                        <span>1</span>
                    </div>
                </div>
                <h2>Thống kê</h2>
                <div class="row">
                    <div class="col-sm-12">
                        <div style="width:10px;height: 10px;background: #5cb85c; display: inline-block"></div>
                        <span style="margin-left: 10px;vertical-align: middle;">Đã thanh toán</span>
                        <div style="margin-left: 20px;width:10px;height: 10px;background: #d9534f; display: inline-block; vertical-align: middle"></div>
                        <span style="margin-left: 10px;vertical-align: middle;">Chưa thanh toán</span>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="progress" style="height: 20px">
                        <div class="progress-bar" role="progressbar" style="width:50%"> 50% </div>
                        <div class="progress-bar" role="progressbar" style="width:50%"> 50% </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <h4>Tổng số tiền các hóa đơn:</h4>
                        <p>100$</p>
                    </div>
                    <div class="col-sm-4">
                        <h4>Tổng số tiền đã chi trả:</h4>
                        <span>10$</span>
                    </div>
                    <div class="col-sm-4">
                        <h4>Tổng số tiền còn nợ:</h4>
                        <p>90$</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <a href="#"><i class="fa fa-plus"></i> Thêm mặt hàng mới </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>