<?php
require_once('models.php');
require_once('cart_controller.php');
require_once('category_controller.php');

if (!empty($_POST['action'])) {
    if ($_POST['action'] === "add") {
        $cart_controller = new CartController();
        $id = $_POST['id'];
        $cart_controller->addToCart($id);
    }
    else if ($_POST['action'] === "delete") {
        $category_controller = new CategoryController();
        $id = $_POST['id'];
        $category_controller->delete_item($id);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
   <head>
      <meta charset="UTF-8">
      <title>Chamb - Responsive E-commerce HTML5 Template</title>
       <meta property="fb:app_id" content="247099903415355" />
       <meta property="og:url" content="URL" />
       <meta property="og:title" content="TITLE" />
       <meta property="og:description" content="DESC" />
       <meta property="og:image" content="IMG" />
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
      <link rel="stylesheet" href="css/select2.min.css">
      <!--responsive css-->
      <link rel="stylesheet" href="css/responsive.css">
   </head>
   <body>
   <div id="fb-root"></div>
   <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=247099903415355&autoLogAppEvents=1" nonce="9GQXnMpL"></script>
   <div id="fb-root"></div>
   <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=247099903415355&autoLogAppEvents=1" nonce="cYU0vw3Z"></script>
   <header>
       <?php include('nav_bar.php');
       require('item_controller.php');
       $item_controller = new ItemController();
       $item = $item_controller->getItem($_GET['id']);
       ?>
   </header>
      <div class="terms-conditions product-page">
         <div class="terms-title">
            <div class="container">
               <div class="row">
                  <ol class="breadcrumb">
                     <li><a href="#">Trang chủ </a></li>
                     <li class="active">Nội thất</li>
                     <li class="active"><?=$item['type']?></li>
                     <li><a href="#"><?=$item['name']?></a></li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <div class="product-page-main">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="prod-page-title">
                     <h2><?=$item['name']?></h2>
                     <p>Nhập khẩu từ <span><?=$item['imported_from']?></span></p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md col-sm-9">
                  <div class="md-prod-page">
                     <div class="md-prod-page-in">
                        <div class="page-preview">
                           <div class="preview">
                               <div class="preview-pic tab-content">
                               <?php
                               require_once('category_controller.php');
                               $category_controller = new CategoryController();
                               $i = 0;
                               $result = $category_controller->getImage($_GET['id'], 4);
                               while ($row = mysqli_fetch_array($result)) { ?>
                                     <div class="tab-pane <?php if ($i === 0) echo 'active';?>" id="pic-<?=$i+1?>"><img src="uploads/<?=$row['path']?>" alt="#" style="width: 811px; height: 330px"/></div>
                                   <?php $i ++;} ?>
                               </div>
                               <ul class="preview-thumbnail nav nav-tabs">
                               <?php
                               $i = 0;
                               $result = $category_controller->getImage($_GET['id'], 5);
                               while ($row = mysqli_fetch_array($result)) { ?>
                                     <li <?php if ($i === 0) echo 'class="active"'?>>
                                         <a data-target="#pic-<?=$i+1?>" data-toggle="tab"><img src="uploads/<?=$row['path']?>" alt="#" style="width: 192px; height: 102px"/></a></li>
                               <?php $i++;} ?>
                              </ul>
                           </div>
                        </div>
                        <div class="btn-dit-list clearfix">
                           <div class="left-dit-p">
                              <div class="prod-btn">
                                  <div class="fb-like" data-href="http://localhost:8000/index.php" data-layout="standard" data-action="like" data-size="small" data-share="true"></div>
                              </div>
                           </div>
                           <div class="right-dit-p">
                              <div class="like-list">
                                 <ul>
                                    <li>
                                       <div class="im-b"><img class="" src="images/list-img-01.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="images/list-img-02.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="images/list-img-03.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="images/list-img-04.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="images/list-img-05.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><img src="images/list-img-06.png" alt=""></div>
                                    </li>
                                    <li>
                                       <div class="im-b"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></div>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="description-box">
                        <div class="dex-a">
                           <h4>Mô tả</h4>
                           <p><?=$item['description']?>
                           </p>
                           <br>
                           <p>Kích cỡ: Dài <?=$item['width']?> / Cao <?=$item['height']?></p>
                        </div>
                        <div class="spe-a">
                           <h4>Thông số</h4>
                           <ul>
                              <li class="clearfix">
                                 <div class="col-md-4">
                                    <h5>Kích cỡ</h5>
                                 </div>
                                 <div class="col-md-8">
                                    <p>Dài <?=$item['width']?> /  <?=$item['height']?> </p>
                                 </div>
                              </li>
                              <li class="clearfix">
                                 <div class="col-md-4">
                                    <h5>Chất liệu</h5>
                                 </div>
                                 <div class="col-md-8">
                                    <p><?=$item['material']?></p>
                                 </div>
                              </li>
                              <li class="clearfix">
                                 <div class="col-md-4">
                                    <h5>Nhập khẩu từ</h5>
                                 </div>
                                 <div class="col-md-8">
                                    <p><?=$item['imported_from'] ?></p>
                                 </div>
                              </li>
                              <li class="clearfix">
                                 <div class="col-md-4">
                                    <h5>Giao hàng</h5>
                                 </div>
                                 <div class="col-md-8">
                                    <p>Toàn quốc</p>
                                 </div>
                              </li>
                              <li class="clearfix">
                                 <div class="col-md-4">
                                    <h5>Bảo hành</h5>
                                 </div>
                                 <div class="col-md-8">
                                    <p><?=$item['warranty'];?> năm</p>
                                 </div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="similar-box">
                     <h2>Sản phẩm tương tự</h2>
                     <div class="row cat-pd">
                         <?php
                         $result = $category_controller->getItems($item['type'], null, null, null);
                         while ($row = mysqli_fetch_array($result)) {
                             if ($row['id'] !== $item['id']) {
                         ?>
                        <div class="col-md-6">
                            <a href="product_page.php?id=<?php echo $row['id']?>" style="border: 0px">
                           <div class="small-box-c">
                              <div class="small-img-b">
                                 <img class="img-responsive" style="width: 384px; height: 320px" src="uploads/<?=mysqli_fetch_array($category_controller->getImage($row['id'], 1))['path']?>" alt="#" />
                              </div>
                              <div class="dit-t clearfix">
                                 <div class="left-ti">
                                     <h4><?=$row['name']?></h4>
                                    <p>Nhập khẩu từ <span><?=$row['imported_from']?></span></p>
                                 </div>
                                  <div style="text-align: right">
                                      <p style="color: black; font-size: 14px; font-weight: light"><strong>Giá: <?=$row['price']?> đ</strong> </p>
                                  </div>
                              </div>
                            </a>
                           </div>
                            </div>
                       <?php }
                         }?>
                     </div>
                  </div>
                   <div class="fb-comments" data-href="http://localhost:8000/index.php" data-width="100%" data-numposts="5"></div>

               </div>
               <div class="col-md-3 col-sm-12">
                  <div class="price-box-right">
                     <h4>Giá bán</h4>
                     <h3><?=$item['price']?> đ <span>một bộ</span></h3>
                     <button class="price-box-right-button" onclick="action('add')"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</button>
                      <?php if (isset($_SESSION['user']) && $_SESSION['user']->getRole() === 'admin') { ?>
                          <button class="btn btn-warning" style="padding: 10px; margin-top:10px" onclick="action('edit')"><strong><i class="fa fa-pencil"></i> Sửa mặt hàng này</strong></button>
                          <button class="btn btn-danger" style="padding: 10px; margin-top:10px" onclick="action('delete')"><strong><i class="fa fa-trash"></i> Xóa mặt hàng này</strong></button>
                      <?php } ?>
                      <h5><i class="fa fa-clock-o" aria-hidden="true"></i> Giao hàng trong <strong>1 ngày</strong></h5>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php include('footer.php'); ?>
      <!--main js--> 
      <script src="js/jquery-1.12.4.min.js"></script>
      <!--bootstrap js--> 
      <script src="js/bootstrap.min.js"></script>
      <script src="js/bootstrap-select.min.js"></script>
      <script src="js/slick.min.js"></script>
      <script src="js/select2.full.min.js"></script>
      <script src="js/wow.min.js"></script>
      <!--custom js--> 
      <script src="js/custom.js"></script>
   <script>
       function action(action) {

           if (action === 'edit')
               window.location.href = "add_new_product.php?id=<?=$_GET['id'];?>";

           else {
               var queryString = 'action=' + action + '&id=' + <?=$item['id']?>;
               jQuery.ajax({
                   url: "product_page.php",
                   data: queryString,
                   type: "POST",
                   success: function (data) {
                       $("#cart-div").load(location.href + " #cart-badge");

                       if (action === "delete") {
                           window.location.href = "category.php?type=all";
                       }
                   },
                   error: function () {
                   }
               });
           }
       }
   </script>
   </body>
</html>