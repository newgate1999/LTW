<?php
require_once('cart_controller.php');
require_once('models.php');
require_once('order_controller.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}

if (!empty($_POST['action'])) {
    $cart_controller = new CartController();
    if (isset($_POST['id']))
        $id = $_POST['id'];

    switch ($_POST['action']) {
        case "add":
            $cart_controller->addToCart($id);
            break;
        case "remove_from_cart":
            $cart_controller->removeFromCart($id);
            break;
        case "remove_from_array":
            $cart_controller->removeFromArray($id);
            break;
        case "place_order":
            $order_controller = new OrderController();
            $order_controller->placeOrder($_POST['recipient_name'], $_POST['recipient_phone'], $_POST['recipient_address']);
            break;
    }
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
    <link rel="stylesheet" href="css/jquery-ui.css">
    <!--responsive css-->
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body style="background: #f4f9fd">
<header>
    <?php include('nav_bar.php')?>
</header>
<div class="furniture-box">
    <div class="terms-title">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="#">Trang chủ</a></li>
                    <li class="active">Thông tin đặt hàng</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row" style="padding: 0px 250px 0px 250px">
    <div class="col-sm-12 furniture-box" >
        <h2 style="padding: 10px">Thông tin đặt hàng</h2>
        <div class="col-sm-4">
            <div class="row" style="padding: 0px">
                        <div class="col-sm-6" style="padding: 0px">
                            <div class="form-group input-group" style="width: 80%">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> Họ và tên người nhận: </span>
                                </div>
                                <input placeholder="Họ và tên" value="<?php echo($_SESSION['user']->getName()); ?>" type="text" id="recipient_name" class="form-control">
                            </div> <!-- form-group// -->
                        </div>
                        <div class="col-sm-6" style="padding: 0px">
                            <div class="form-group input-group" style="width: 80%">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-phone"></i> Số điện thoại người nhận: </span>
                                </div>
                                <input id='recipient_phone' value="<?php echo($_SESSION['user']->getPhone());?>" class="form-control" placeholder="SĐT"/>
                            </div> <!-- form-group// -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group input-group" style="width: 90%">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-location-arrow"></i> Địa chỉ người nhận: </span>
                            </div>
                            <textarea class="form-control" required="required" placeholder="Địa chỉ nhận hàng" type="text" id="recipient_address"></textarea>
                        </div> <!-- form-group// -->
                    </div>
            </div>
            <div id="cart-items-col-div" class="col-sm-8">

            <?php
            if (!isset($_SESSION['cart'])) {
                ?>
                <strong style="float: right">
                    Không có mặt hàng trong giỏ
                </strong>
                <?php
            }
            else {
            $cart = $_SESSION['cart'];
            ?>
                <div class="cart-list" id="cart-items-div">
                <ul>
                        <?php foreach ($cart->items as $item) {?>
                        <li>
                            <div class="row">
                                <div class="col-sm-6">
                                    <span class="helper">
                                    <a href="#" >
                                        <img src="images/lag-60.png" alt="img">
                                        <?php echo($item['item']['name'])?>
                                    </a>
                                    </span>
                                </div>
                                <div class="col-sm-6" style="text-align: right">
                                        <button style="border: 0 transparent; background: transparent">
                                            <i class="fa fa-minus-circle" onClick="action('remove_from_cart', '<?php echo($item['item']['id'])?>')"></i>
                                        </button>
                                        <span>
                                        Số lượng: <?php echo($item['quantity']) ?>
                                    </span>
                                        <button style="border: 0 transparent; background: transparent" onClick="action('add', '<?php echo($item['item']['id'])?>')">
                                            <i class="fa fa-plus-circle"></i>
                                        </button>
                                        <span>
                                        Tổng giá: <?php echo($item['price']) ?> đ
                                        </span>
                                        <button type="submit" class="btn btn-danger" onClick="action('remove_from_array', '<?php echo($item['item']['id'])?>')">
                                            <i class="fa fa-times"></i>
                                        </button>
                                </div>
                            </div>
                        </li>
                        <?php }?>
                    </ul>
                <button name="place_order" type="submit" class="order-b" onClick="action('place_order', 0)">Đặt hàng</button>

            </div>
    </div>
    </div>
            <?php
    }
    ?>
</div>
<script type="text/javascript">
    function action(action, id) {
        var queryString = "";
        if(action !== "") {
            switch(action) {
                case "add":case"remove_from_cart":case"remove_from_array":
                    queryString = 'action='+action+'&id='+ id;
                    break;
                case "place_order":
                    if ($('#recipient_name').val() === '' || $('#recipient_phone').val() === '' || $('#recipient_address').val() === '' )
                        alert("Điền đầy đủ thông tin");
                    else if ($('#recipient_phone').val().match(/^\d{10,}$/) === null)
                        alert("Sai định dạng số điện thoại. Số điện thoại chỉ được phép chứa các kí tự số")
                    else {
                        queryString = 'action=' + action + '&recipient_name=' + $('#recipient_name').val() + '&recipient_phone=' + $('#recipient_phone').val() +
                            '&recipient_address=' + $('#recipient_address').val();
                    }
                    break;
            }
        }
        jQuery.ajax({
            url: "cart_view.php",
            data:queryString,
            type: "POST",
            success:function(data){
                $("#cart-badge").load(location.href + " #cart-badge > *");
                $("#cart-items-col-div").load(location.href + " #cart-items-col-div > *");

                if (action === "place_order" && $('#recipient_name').val() !== '' && $('#recipient_phone').val() !== '' && $('#recipient_address').val() !== '' && $('#recipient_phone').val().match(/^\d{10,}$/) !== null) {
                    window.location.replace('category.php?type=all');
                }
            },
            error:function (){}
        });
    }
</script>


</body>

</html>
