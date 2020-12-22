<?php
require_once('models.php');
include('nav_bar.php');
require('connection.php');
include('order_controller.php');
if (!empty($_POST['action'])) {
    $order_controller = new OrderController();
    switch ($_POST['action']) {
        case 'mark_completed':
            $order_controller->mark_completed($_POST['orders_id']);
            die;
            break;
        case 'mark_shipping':
            $order_controller->mark_shipping($_POST['orders_id']);
            die;
            break;
        case 'remove':
            $order_controller->remove_order($_POST['orders_id']);
            break;
    }
}
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>Chi tiết hóa đơn</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script>
        function deleteInvoice() {
        if (confirm("Bạn có muốn xóa đơn hàng này?")) {

        }
        else {

        }
        }
    </script>
    <style type="text/css">

        /*Invoice*/
        .invoice .top-left {
            font-size:65px;
            padding:20px;
        }

        .invoice .top-right {
            text-align:right;
            padding:40px;
        }

        .invoice .payment-info {
            font-weight:500;
        }

        .invoice .table-row .table>thead {
            border-top:1px solid #ddd;
        }

        .invoice .table-row .table>thead>tr>th {
            border-bottom:none;
        }

        .invoice .table>tbody>tr>td {
            padding:8px 20px;
        }

        .invoice .invoice-total {
            margin-right:-10px;
            font-size:16px;
        }

        @media(max-width:575px) {
            .invoice .top-left,.invoice .top-right,.invoice .payment-details {
                text-align:center;
            }

            .invoice .from,.invoice .to,.invoice .payment-details {
                float:none;
                width:100%;
                text-align:center;
                margin-bottom:25px;
            }

            .invoice p.lead,.invoice .from p.lead,.invoice .to p.lead,.invoice .payment-details p.lead {
                font-size:22px;
            }

            .invoice .btn {
                margin-top:10px;
            }

        }

        @media print {
            .invoice {
                width:900px;
                height:800px;
            }
        }
    </style>
</head>
<body style="background: #f4f9fd">
<div class="container bootstrap">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default invoice" id="invoice">
                <div class="panel-body" style="margin: 0px 10px 10px 10px">
                    <div class="row">

                        <div class="col-sm-6 top-left">
                            <img src="images/logo.png" alt="Logo">
                        </div>
                        <?php
                        $user_id = mysqli_real_escape_string($db, $_SESSION['user']->getId());
                        $log_id = mysqli_real_escape_string($db, $_GET['log_id']);
                        $result = mysqli_query($db,"SELECT * FROM orders 
                                                            INNER JOIN order_logs ON orders.id = order_logs.orders_id 
                                                            INNER JOIN statuses ON order_logs.status_id = statuses.id
                                                            WHERE order_logs.id = $log_id");
                        $row = mysqli_fetch_assoc($result);
                        $status = $row['status_name'];
                        ?>
                        <div class="col-sm-6 top-right">
                            <h3>Đơn hàng - <?php echo($row['orders_id'])?></h3>
                        </div>

                    </div>
                    <hr>
                    <?php
                    $i=1;
                    ?>
                    <div class="row">
                        <div class="col-sm-8 from">
                            <p class="lead marginbottom">Người nhận: <?php echo($row['recipient_name'])?></p>
                            <p>Trạng thái: <?=$row['status_name']?></p>
                            <p>Địa chỉ: <?=$row['address'] ?></p>
                            <p>SĐT: <?=$row['recipient_phone'] ?></p>
                            <p>Email: <?=$_SESSION['user']->getEmail() ?></p>
                        </div>

                        <div class="col-sm-4 text-right payment-details">
                            <p class="lead marginbottom payment-info">Chi tiết</p>
                            <p>Ngày đặt hàng: <?=$row['created_at']?> </p>
                            <p>Ngày cập nhật gần nhất: <?=$row['created_at'] ?> </p>
                            <p>Tổng tiền: <?=$row['total_price']?> đ</p>
                        </div>
                    </div>

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="text-center" style="width:5%">#</th>
                                <th style="width:50%">Mặt hàng</th>
                                <th class="text-right" style="width:15%">Số lượng</th>
                                <th class="text-right" style="width:15%">Đơn giá</th>
                                <th class="text-right" style="width:15%">Tổng tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i=1;
                            $orders_id = $row['orders_id'];
                            $orders_id_sql = mysqli_real_escape_string($db, $row["orders_id"]);
                            $result = mysqli_query($db, "SELECT * FROM ordered_items INNER JOIN items ON ordered_items.item_id = items.id 
                                                                WHERE orders_id = $orders_id_sql");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr>
                                    <td class="text-center"> <?=$i ?></td>
                                    <td><?=$row['name'] ?></td>
                                    <td class="text-right"> <?=$row['quantity']?></td>
                                    <td class="text-right"> <?=$row['price']?></td>
                                    <td class="text-right"> <?=$row['price'] * $row['quantity']?></td>
                                </tr>
                                <?php $i ++ ?>
                            </tbody>
                            <?php } ?>
                        </table>
                        <div class="row">
                            <div class="col-sm-6 margintop">
                                <?php if ($status === "Đang xác nhận") { ?>
                                <button onClick="action('mark_shipping', <?=$orders_id?>)" class="btn btn-primary" id="invoice-print"><i class="fa fa-check"></i> Đánh dấu là đang giao </button>
                                <?php }
                                else if ($status === "Đang giao") {
                                    ?>
                                <button onClick="action('mark_completed', <?=$orders_id?> )" class="btn btn-success" id="invoice-print"><i class="fa fa-check"></i> Đánh dấu là đã giao </button>
                                <?php } ?>
                                <button onClick="window.print()" class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i> In hóa đơn </button>
                                <button onClick="action('remove', <?=$orders_id?>)" class="btn btn-danger"><i class="fa fa-trash-o"></i> Xóa hóa đơn</button>
                            </div>
                            <div class="col-sm-6 text-right pull-right invoice-total">
                            <?php
                            $result = mysqli_query($db, "SELECT * FROM orders 
                                                                WHERE id = $orders_id_sql");
                            $row = mysqli_fetch_assoc($result);
                            ?>
                                <p>Tổng giá : <?=$row['total_price']?> đ</p>
                            </div>
                        </div>
                    <script>
                        function action(action, id) {
                            var queryString = "";
                            if(action !== "") {
                                switch(action) {
                                    case "mark_shipping":
                                        queryString = 'action='+action+'&orders_id='+ id;
                                        break;
                                    case "remove":
                                        queryString = 'action='+action+'&orders_id='+ id;
                                        break;
                                    case "mark_completed":
                                        queryString = 'action='+action+'&orders_id='+ id;
                                        break;
                                }
                            }
                            jQuery.ajax({
                                url: "invoice_details.php",
                                data:queryString,
                                type: "POST",
                                success:function(data){
                                    $("#cart-badge").load(location.href + " #cart-badge > *");
                                    window.location.assign("invoice.php");
                                },
                                error:function (){}
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
<!--main js-->
<script src="js/jquery-1.12.4.min.js"></script>
<!--bootstrap js-->
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/wow.min.js"></script>
<!--custom js-->
<script src="js/custom.js"></script>
</body>
</html>
