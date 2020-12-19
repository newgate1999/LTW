<?php
require_once('cart_controller.php');
require_once('models.php');

if (!empty($_POST['action'])) {
    if ($_POST['action'] === "add") {
        $cart_controller = new CartController();
        $id = $_POST['id'];
        $cart_controller->addToCart($id);
    }
}
?>
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
       <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
   </head>
   <body>
      <!-- Modal -->
      <?php include('nav_bar.php'); ?>
      <div class="furniture-box">
         <div class="terms-title">
            <div class="container">
               <div class="row">
                  <ol class="breadcrumb">
                     <li><a href="#">Trang chủ</a></li>
                     <li>Danh mục sản phẩm</li>
                      <li class="active"><?php $type = $_GET['type']; if ($type === 'all') $type = 'Tất cả sản phẩm'; echo($type) ?></li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <div class="furniture-box">
         <div class="container">
            <div class="row">
               <div class="furniture-main">
                  <h2>Nội thất</h2>
                  <div class="col-md-3 col-sm-4">
                     <div class="furniture-left">
                        <h3>Lọc sản phẩm</h3>
                        <div class="by-box">
                           <h5>Theo giá</h5>
                           <div id="slider-range"></div>
                           <p>
                              <input type="text" id="amount" readonly style="">
                           </p>
                        </div>
                            <div class="left-list-f">
                           <div class="panel-group" id="accordion">
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title expand">
                                       <div class="right-arrow pull-right"><span class="caret"></span></div>
                                       <a href="#">Sắp xếp theo</a>
                                    </h4>
                                 </div>
                                 <div id="collapse1" class="panel-collapse collapse">
                                    <div class="panel-body">Lorem ipsum dolor sit amet,</div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-8">
                     <div class="furniture-middle">
                         <?php
                            include('category_controller.php');
                            $category_controller = new CategoryController();
                            $result = $category_controller->getItems($_GET['type'], $_GET['start'], $_GET['end'], $_GET['name']);
                            while ($row = mysqli_fetch_array($result)) { ?>
                        <div class="big-box">
                           <div class="big-img-box">
                              <img src="images/lag-60.png" alt="#" />
                           </div>
                           <div class="big-dit-b clearfix">
                              <div class="col-md-6">
                                 <div class="left-big">
                                    <h3> <?php echo($row['name']) ?> </h3>
                                    <p>Loại: <span><?php echo($row['type']) ?></span></p>
                                    <div class="prod-btn">
                                       <a href="#"><i class="fa fa-star" aria-hidden="true"></i> Lưu vào wishlist </a>
                                       <a href="#"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like this</a>
                                       <p>23 likes</p>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="right-big-b">
                                    <div class="tight-btn-b clearfix">
                                       <a class="view-btn" href="productpage.php?id=<?php echo $row['id']?>">Xem chi tiết</a>
                                       <button id="add-item_<?php echo($row['id'])?>" onClick="action('add', '<?php echo($row['id'])?>')" type="submit"><?php echo($row['price'])?> đ</button>
                                    </div>
                                    <div class="like-list">
                                       <ul>
                                          <li>
                                             <div class="im-b"><img class="" src="images/list-img-01.png" alt="" /></div>
                                          </li>
                                          <li>
                                             <div class="im-b"><img src="images/list-img-02.png" alt="" /></div>
                                          </li>
                                          <li>
                                             <div class="im-b"><img src="images/list-img-03.png" alt="" /></div>
                                          </li>
                                          <li>
                                             <div class="im-b"><img src="images/list-img-04.png" alt="" /></div>
                                          </li>
                                          <li>
                                             <div class="im-b"><img src="images/list-img-05.png" alt="" /></div>
                                          </li>
                                          <li>
                                             <div class="im-b"><img src="images/list-img-06.png" alt="" /></div>
                                          </li>
                                          <li>
                                             <div class="im-b"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></div>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                         <?php } ?>
                     </div>
                  </div>
                  <div class="col-md-3 hidden-xs">
                     <div class="furniture-right">
                         <h3><a href="?type=all&start=<?=$_GET['start']?>&end=<?=$_GET['end']?>">Danh mục sản phẩm</a></h3>
                        <div class="right-list-f">
                           <ul>
                               <li><a href="?type=Ghế gỗ&start=<?=$_GET['start']?>&end=<?=$_GET['end']?>"><img width="32" src="images/product/1.png" alt="#" /> Ghế gỗ</a></li>
                              <li><a href="?type=Ghế nệm phòng&start=<?=$_GET['start']?>&end=<?=$_GET['end']?>"><img width="32" src="images/product/2.png" alt="#" /> Ghế nệm phòng</a></li>
                              <li><a href="?type=Ghế gỗ không tay&start=<?=$_GET['start']?>&end=<?=$_GET['end']?>"><img width="32" src="images/product/1.png" alt="" /> Ghế gỗ không tay </a></li>
                              <li><a href="?type=Sofa&start=<?=$_GET['start']?>&end=<?=$_GET['end']?>"><img width="32" src="images/product/4.png" alt="" /> Sofa </a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="loading-box">
                     <a href="#">
                        <div class="sk-wave">
                           <div class="sk-rect sk-rect1"></div>
                           <div class="sk-rect sk-rect2"></div>
                           <div class="sk-rect sk-rect3"></div>
                           <div class="sk-rect sk-rect4"></div>
                           <div class="sk-rect sk-rect5"></div>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php include('footer.php'); ?>
      <!--main js--> 
      <!--bootstrap js-->
      <script src="js/bootstrap.min.js"></script>
      <script src="js/bootstrap-select.min.js"></script>
      <script src="js/slick.min.js"></script>
      <script src="js/jquery-ui.js"></script>
      <script src="js/wow.min.js"></script>
      <!--custom js--> 
      <script src="js/custom.js"></script>
      <script>
         $( function() {
         	$( "#slider-range" ).slider({
         		range: true,
         		min: 0,
         		max: 10000000,
         		values: [ <?php
         		if (isset($_GET['start']) && isset($_GET['end'])) {
         		    $start = $_GET['start'];
         		    $end = $_GET['end'];
         		    echo("$start, $end");
         		    }
         		else {
         		    echo('158, 1230');
         		    } ?>],
         		slide: function( event, ui ) {
         			$( "#amount" ).val( ui.values[ 0 ] + "đ" + " - " + ui.values[ 1 ] + "đ");
         		}
         	});
         	$( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) + "đ" +
         		" - " + $( "#slider-range" ).slider( "values", 1 ) + "đ");
         } );

        $("#slider-range").slider().on( 'slidestop', function(event, ui) {
            window.location.replace('category.php?type=<?=$_GET['type'];?>&start='+ui.values[0]+'&end='+ui.values[1]);
        });
      </script>
      <script src="js/jquery.nicescroll.min.js"></script>
      <script>
         $(document).ready(function() {
           $("#boxscroll").niceScroll({cursorborder:"",cursorcolor:"#ededed",boxzoom:true}); // First scrollable DIV
         });
      </script>
    <script>
        function action(action, id) {
            var queryString = "";
            if(action !== "") {
                switch(action) {
                    case "add":
                        queryString = 'action='+action+'&id='+ id;
                        break;
                    case "remove":
                        queryString = 'action='+action+'&id='+ id;
                        break;
                    case "empty":
                        queryString = 'action='+action;
                        break;
                }
            }
            jQuery.ajax({
                url: "category.php",
                data:queryString,
                type: "POST",
                success:function(data){
                    $("#cart-div").load(location.href + " #cart-badge");
                },
                error:function (){}
            });
        }
    </script>
   </body>
</html>