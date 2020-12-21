<?php
require_once('models.php');
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
      <link rel="stylesheet" href="css/select2.min.css">
      <!--responsive css-->
      <link rel="stylesheet" href="css/responsive.css">
   </head>
   <body>
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
                     <p>Nhập khẩu từ <span>Đức</span></p>
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
                                     <div class="tab-pane <?php if ($i === 0) echo 'active';?>" id="pic-<?=$i+1?>"><img src="uploads/<?=$row['path']?>" alt="#" /></div>
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
                                 <a href="#"><i class="fa fa-star" aria-hidden="true"></i> Lưu vào wishlist</a>
                                 <a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like</a>
                                 <p>23 likes</p>
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
                                    <h5>Nhập khẩu từ/h5>
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
                           <div class="small-box-c">
                              <div class="small-img-b">
                                 <img class="img-responsive" src="images/tr1.png" alt="#" />
                              </div>
                              <div class="dit-t clearfix">
                                 <div class="left-ti">
                                    <h4><?=$row['name']?></h4>
                                    <p>Nhập khẩu từ <span><?=$row['imported_from']?></span></p>
                                 </div>
                                 <a href="#" tabindex="0"><?=$row['price']?> đ</a>
                              </div>
                              <div class="prod-btn">
                                 <a href="#"><i class="fa fa-star" aria-hidden="true"></i> Lưu vào wishlist</a>
                                 <a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like </a>
                                 <p>23 likes</p>
                              </div>
                           </div>
                            </div>
                       <?php }
                         }?>
                     </div>
                  </div>
               </div>
               <div class="col-md-3 col-sm-12">
                  <div class="price-box-right">
                     <h4>Giá bán</h4>
                     <h3><?=$item['price']?> đ <span>một bộ</span></h3>
                     <button onclick="add_to_cart(<?=$item['id']?>)">Thêm vào giỏ hàng</button>
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
   </body>
</html>