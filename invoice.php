<?php
require_once('models.php');
include('auth.php');
include('nav_bar.php');
include('order_controller.php');

$order_controller = new OrderController();
$result = null;

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case "search":
            $_SESSION['idInput'] = $_POST['idInput'] === '' ? null : $_POST['idInput'];
            $_SESSION['updated_at'] = $_POST['updated_at'] === '' ? null : $_POST['updated_at'];
            $_SESSION['name'] = $_POST['name'] === '' ? null : $_POST['name'];
            $_SESSION['phone'] = $_POST['recipient_phone'] === '' ? null : $_POST['recipient_phone'];
            $_SESSION['searching'] = true;
            break;
        case "reset_filters":
            unset($_SESSION['searching']);
            unset($_SESSION['idInput']);
            unset($_SESSION['name']);
            unset($_SESSION['updated_at]']);
            unset($_SESSION['phone']);
            break;
    }
}
?>

<html lang = "en">
<body style="background: #f4f9fd">
<div class="row">
    <div class="furniture-box">
        <div class="terms-title">
            <div class="container">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="#">Trang chủ</a></li>
                        <li class="active">Hóa đơn</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2 furniture-box" style="padding-left: 40px">
        <nav class="navbar-default">
            <ul class="nav navbar">
                <li class="nav-box">
                    <a href="dashboard.php">Bảng điều khiển</a>
                </li>
                <li class="nav-box nav-active">
                    <a>Hóa đơn</a>
                </li>
            </ul>
        </nav>
    </div>
        <div class="col-sm-9" style="margin: 10px 50px 10px 50px" id="orders_table">
            <h1>Thông tin các hóa đơn</h1>
            <form id="form">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                            <div class="form-group">
                                <label for="idInput" class="form-control-label">Mã hóa đơn:</label>
                                <input id="idInput" name="idInput" type="text" class="form-control" placeholder="Mã hóa đơn">
                            </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="updated_at" class="form-control-label">Ngày cập nhật gần nhất: </label>
                            <input name="updated_at" id="updated_at" type="date" class="form-control" placeholder="Ngày nhập">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                                <label for="name" class="form-control-label">Tên người nhận:</label>
                                <input name="name" id="name" type="text" class="form-control" placeholder="Tên người nhận" aria-label="Tên người nhận">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-submit" type="button" onClick="button_clicked('search')">Tìm kiếm</button>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                                <label for="recipient_phone" class="form-control-label">SĐT người nhận:</label>
                                <input name="recipient_phone" id="recipient_phone" type="text" class="form-control" placeholder="SĐT người nhận" aria-label="SĐT người nhận">
                        </div>
                    </div>

                </div>
            </div>
            </form>

            <?php if (isset($_SESSION['searching'])) { ?>
                <button class="btn btn-submit" onClick="button_clicked('reset_filters')">Xóa bộ lọc</button>
            <?php } ?>
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên người nhận</th>
                        <th>SĐT người nhận</th>
                        <th>Địa chỉ</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày cập nhật gần nhất</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                $result = $order_controller->get_orders(array());
                if (isset($_SESSION['searching'])) {
                    $result = $order_controller->get_orders([
                            'X.orders_id' => $_SESSION['idInput'],
                        'DATE(updated_at)' => $_SESSION['updated_at'],
                        'recipient_name' => $_SESSION['name'],
                        'recipient_phone' => $_SESSION['phone'],]);
                }
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo($i) ?></td>
                        <td><?php echo($row['orders_id'])?></td>
                        <td><?php echo($row['recipient_name'])?></td>
                        <td><?php echo($row['recipient_phone'])?></td>
                        <td><?php echo($row['address'])?></td>
                        <td><?php echo($row['total_price'])?> đ</td>
                        <td>
                            <?php echo($row['status_name'])?>
                        </td>
                        <td><?=$row['updated_at']?></td>
                        <td>
                            <a href="invoice_details.php?log_id=<?php echo($row['id'])?>">Xem chi tiết</a>
                        </td>
                    </tr>
                <?php
                }?>
                </tbody>
            </table>
            <span>
        </div>
</div>
<script>
    function button_clicked(action) {
        var queryString = "";
        if(action !== "") {
            switch(action) {
                case "search":
                    queryString = 'action=search&' + $('#form').serialize();
                    break;
                case "reset_filters":
                    queryString = 'action=reset_filters';
                    break;
            }
        }
        jQuery.ajax({
            url: "invoice.php",
            data:queryString,
            type: "POST",
            success:function(data){
                $("#orders_table").load(location.href + " #orders_table > *");
            },
            error:function (){}
        });
    }
</script>
</body>
</html>