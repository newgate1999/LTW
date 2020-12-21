<?php
require_once("models.php");
require_once("connection.php");

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $type = mysqli_real_escape_string($db, $_POST['type']);
    $user_id = mysqli_real_escape_string($db, $_SESSION['user']->getId());
    $price = mysqli_real_escape_string($db, $_POST['price']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $width = mysqli_real_escape_string($db, $_POST['width']);
    $height = mysqli_real_escape_string($db, $_POST['height']);
    $imported_from = mysqli_real_escape_string($db, $_POST['imported_from']);
    $warranty = mysqli_real_escape_string($db, $_POST['warranty']);
    $material = mysqli_real_escape_string($db, $_POST['material']);

    $sql = "INSERT INTO items(name, type, user_id, price, description, width, height, imported_from, warranty, material)
                            VALUES('$name', '$type', $user_id, $price, '$description', $width, $height, '$imported_from', $warranty, '$material')";
    mysqli_query($db, $sql);

    $targetDir = "uploads/";
    $allowTypes = array('jpg','png','jpeg','gif');

    $statusMsg = $errorMsg = $errorUpload = $errorUploadType = '';
    $fileNames = array_filter($_FILES['files']['name']);
    $id = mysqli_insert_id($db);

    if(!empty($fileNames)){
        $i = 0;
        foreach($_FILES['files']['name'] as $key=>$val){
            $insertValuesSQL = '';
            // File upload path
            $fileName = basename($_FILES['files']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            // Check whether file type is valid
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $file_name = $targetDir.$i."_".$id. ".". $fileType;
            if(in_array($fileType, $allowTypes)){
                // Upload file to server
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$key], $file_name)){
                    // Image db insert sql
                    $insertValuesSQL .="('".$i."_". $id. ".". $fileType."', ". $id.")";

                    if(!empty($insertValuesSQL)){
                        $insertValuesSQL = trim($insertValuesSQL, ',');
                        // Insert image file name into database
                        $insert = $db->query("INSERT INTO images (path, items_id) VALUES $insertValuesSQL");
                        echo "INSERT INTO images (path, items_id) VALUES $insertValuesSQL";
                        if($insert){
                            $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):'';
                            $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):'';
                            $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType;
                            $statusMsg = "Files are uploaded successfully.".$errorMsg;
                        }else{
                            $statusMsg = "Sorry, there was an error uploading your file.";
                        }
                    }
                    $i ++;
                }else{
                    $errorUpload .= $_FILES['files']['name'][$key].' | ';
                }
            }else{
                $errorUploadType .= $_FILES['files']['name'][$key].' | ';
            }
        }
    }else{
        $statusMsg = 'Please select a file to upload.';
    }
    header("Location: invoice.php");
}
?>
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
    <script src="js/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/custom.js"></script>
</head>
<body style="background: #f4f9fd">
<header>
    <?php include('nav_bar.php');?>
</header>
<div class="row" style="padding: 20px 600px 0px 600px">
    <h2 class="text-center">Thêm mặt hàng mới</h2>
    <form method="post" style="padding: 10px" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-3">
                    <label>
                        Tên mặt hàng:
                    </label>
                    <input type="text" class="form-control" placeholder="Tên mặt hàng" name="name" required="required">
                </div>
                <div class="col-sm-3">
                    <label>
                        Loại mặt hàng:
                    </label>
                    <input type="text" class="form-control" placeholder="Loại mặt hàng" name="type" required="required">
                </div>
                <div class="col-sm-3">
                    <label>
                        Giá:
                    </label>
                    <input type="text" class="form-control" placeholder="Giá" name="price" required="required">
                </div>
                <div class="col-sm-3">
                    <label>
                        Vật liệu sản xuất:
                    </label>
                    <input type="text" class="form-control" placeholder="Vật liệu sản xuất" name="material" required="required">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>
                Mô tả:
            </label>
            <textarea class="form-control" name="description" required="required"></textarea>
        </div>
        <div class="form-group">
            <div class="row">
                    <label class="col-sm-6">
                        Chiều dài:
                        <input type="text" class="form-control" placeholder="Chiều dài" name="width" required="required">
                    </label>
                <label class="col-sm-6">
                    Chiều rộng:
                    <input type="text" class="form-control" placeholder="Chiều rộng" name="height" required="required">
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-6">
                        Nhập khẩu từ:
                    <select id = "country" name = "imported_from" class = "form-control select2">
                            <option value = "Afganistan"> Afghanistan </option>
                            <option value = "Albania"> Albania </option>
                            <option value = "Algeria"> Algeria </option>
                            <option value = "American Samoa"> American Samoa </option>
                            <option value = "Andorra"> Andorra </option>
                            <option value = "Angola"> Angola </option>
                            <option value = "Anguilla"> Anguilla </option>
                            <option value = "Antigua & Barbuda"> Antigua & Barbuda </option>
                            <option value = "Argentina"> Argentina </option>
                            <option value = "Armenia"> Armenia </option>
                            <option value = "Aruba"> Aruba </option>
                            <option value = "Australia"> Úc </option>
                            <option value = "Austria"> Áo </option>
                            <option value = "Azerbaijan"> Azerbaijan </option>
                            <option value = "Bahamas"> Bahamas </option>
                            <option value = "Bahrain"> Bahrain </option>
                            <option value = "Bangladesh"> Bangladesh </option>
                            <option value = "Barbados"> Barbados </option>
                            <option value = "Belarus"> Belarus </option>
                            <option value = "Belgium"> Bỉ </option>
                            <option value = "Belize"> Belize </option>
                            <option value = "Benin"> Benin </option>
                            <option value = "Bermuda"> Bermuda </option>
                            <option value = "Bhutan"> Bhutan </option>
                            <option value = "Bolivia"> Bolivia </option>
                            <option value = "Bonaire"> Bonaire </option>
                            <option value = "Bosnia & Herzegovina"> Bosnia & Herzegovina </option>
                            <option value = "Botswana"> Botswana </option>
                            <option value = "Brazil"> Braxin </option>
                            <option value = "British Indian Ocean Ter"> British Indian Ocean Ter </option>
                            <option value = "Brunei"> Brunei </option>
                            <option value = "Bulgaria"> Bulgaria </option>
                            <option value = "Burkina Faso"> Burkina Faso </option>
                            <option value = "Burundi"> Burundi </option>
                            <option value = "Campuchia"> Campuchia </option>
                            <option value = "Cameroon"> Cameroon </option>
                            <option value = "Canada"> Canada </option>
                            <option value = "Canary Islands"> Canary Islands </option>
                            <option value = "Cape Verde"> Cape Verde </option>
                            <option value = "Cayman Islands"> Quần đảo Cayman </option>
                            <option value = "Cộng hòa Trung Phi"> Cộng hòa Trung Phi </option>
                            <option value = "Chad"> Chad </option>
                            <option value = "Channel Islands"> Channel Islands </option>
                            <option value = "Chile"> Chile </option>
                            <option value = "China"> Trung Quốc </option>
                            <option value = "Christmas Island"> Đảo Christmas </option>
                            <option value = "Cocos Island"> Đảo Cocos </option>
                            <option value = "Colombia"> Colombia </option>
                            <option value = "Comoros"> Comoros </option>
                            <option value = "Congo"> Congo </option>
                            <option value = "Cook Islands"> Quần đảo Cook </option>
                            <option value = "Costa Rica"> Costa Rica </option>
                            <option value = "Cote DIvoire"> Cote DIvoire </option>
                            <option value = "Croatia"> Croatia </option>
                            <option value = "Cuba"> Cuba </option>
                            <option value = "Curaco"> Curacao </option>
                            <option value = "Cyprus"> Cyprus </option>
                            <option value = "Czech Republic"> Cộng hòa Séc </option>
                            <option value = "Đan Mạch"> Đan Mạch </option>
                            <option value = "Djibouti"> Djibouti </option>
                            <option value = "Dominica"> Dominica </option>
                            <option value = "Cộng hòa Dominica"> Cộng hòa Dominica </option>
                            <option value = "East Timor"> Đông Timor </option>
                            <option value = "Ecuador"> Ecuador </option>
                            <option value = "Egypt"> Ai Cập </option>
                            <option value = "El Salvador"> El Salvador </option>
                            <option value = "Equatorial Guinea"> Equatorial Guinea </option>
                            <option value = "Eritrea"> Eritrea </option>
                            <option value = "Estonia"> Estonia </option>
                            <option value = "Ethiopia"> Ethiopia </option>
                            <option value = "Falkland Islands"> Quần đảo Falkland </option>
                            <option value = "Faroe Islands"> Faroe Islands </option>
                            <option value = "Fiji"> Fiji </option>
                            <option value = "Finland"> Phần Lan </option>
                            <option value = "France"> Pháp </option>
        <option value = "French Guiana"> Guiana thuộc Pháp </option>
                            <option value = "Polynesia thuộc Pháp"> Polynesia thuộc Pháp </option>
                            <option value = "French Southern Ter"> French Southern Ter </option>
                            <option value = "Gabon"> Gabon </option>
                            <option value = "Gambia"> Gambia </option>
                            <option value = "Georgia"> Georgia </option>
                            <option value = "Germany"> Đức </option>
                            <option value = "Ghana"> Ghana </option>
                            <option value = "Gibraltar"> Gibraltar </option>
                            <option value = "Great Britain"> Vương quốc Anh </option>
                            <option value = "Greek"> Hy Lạp </option>
                            <option value = "Greenland"> Greenland </option>
                            <option value = "Grenada"> Grenada </option>
                            <option value = "Guadeloupe"> Guadeloupe </option>
                            <option value = "Guam"> Guam </option>
                            <option value = "Guatemala"> Guatemala </option>
                            <option value = "Guinea"> Guinea </option>
                            <option value = "Guyana"> Guyana </option>
                            <option value = "Haiti"> Haiti </option>
                            <option value = "Hawaii"> Hawaii </option>
                            <option value = "Honduras"> Honduras </option>
                            <option value = "Hong Kong"> Hong Kong </option>
                            <option value = "Hungary"> Hungary </option>
                            <option value = "Iceland"> Iceland </option>
                            <option value = "Indonesia"> Indonesia </option>
                            <option value = "India"> Ấn Độ </option>
                            <option value = "Iran"> Iran </option>
                            <option value = "Iraq"> Iraq </option>
                            <option value = "Ireland"> Ireland </option>
                            <option value = "Isle of Man"> Đảo Man </option>
                            <option value = "Israel"> Israel </option>
                            <option value = "Ý"> Ý </option>
                            <option value = "Jamaica"> Jamaica </option>
                            <option value = "Japan"> Nhật Bản </option>
                            <option value = "Jordan"> Jordan </option>
                            <option value = "Kazakhstan"> Kazakhstan </option>
                            <option value = "Kenya"> Kenya </option>
                            <option value = "Kiribati"> Kiribati </option>
                            <option value = "Korea North"> Korea North </option>
                            <option value = "Korea Sout"> Hàn Quốc </option>
                            <option value = "Kuwait"> Kuwait </option>
                            <option value = "Kyrgyzstan"> Kyrgyzstan </option>
                            <option value = "Lào"> Lào </option>
                            <option value = "Latvia"> Latvia </option>
                            <option value = "Lebanon"> Lebanon </option>
                            <option value = "Lesotho"> Lesotho </option>
                            <option value = "Liberia"> Liberia </option>
                            <option value = "Libya"> Libya </option>
                            <option value = "Liechtenstein"> Liechtenstein </option>
                            <option value = "Lithuania"> Lithuania </option>
                            <option value = "Luxembourg"> Luxembourg </option>
                            <option value = "Macau"> Macau </option>
                            <option value = "Macedonia"> Macedonia </option>
                            <option value = "Madagascar"> Madagascar </option>
                            <option value = "Malaysia"> Malaysia </option>
                            <option value = "Malawi"> Malawi </option>
                            <option value = "Maldives"> Maldives </option>
                            <option value = "Mali"> Mali </option>
                            <option value = "Malta"> Malta </option>
                            <option value = "Marshall Islands"> Quần đảo Marshall </option>
                            <option value = "Martinique"> Martinique </option>
                            <option value = "Mauritania"> Mauritania </option>
                            <option value = "Mauritius"> Mauritius </option>
                            <option value = "Mayotte"> Mayotte </option>
                            <option value = "Mexico"> Mexico </option>
                            <option value = "Midway Islands"> Quần đảo Midway </option>
                            <option value = "Moldova"> Moldova </option>
                            <option value = "Monaco"> Monaco </option>
                            <option value = "Mongolia"> Mông Cổ </option>
                            <option value = "Montserrat"> Montserrat </option>
                            <option value = "Morocco"> Morocco </option>
                            <option value = "Mozambique"> Mozambique </option>
                            <option value = "Myanmar"> Myanmar </option>
                            <option value = "Nambia"> Nambia </option>
                            <option value = "Nauru"> Nauru </option>
                            <option value = "Nepal"> Nepal </option>
                            <option value = "Netherland Antilles"> Netherland Antilles </option>
                            <option value = "Hà Lan"> Hà Lan (Hà Lan, Châu Âu) </option>
                            <option value = "Nevis"> Nevis </option>
                  <option value = "New Caledonia"> New Caledonia </option>
                            <option value = "New Zealand"> New Zealand </option>
                            <option value = "Nicaragua"> Nicaragua </option>
                            <option value = "Niger"> Niger </option>
                            <option value = "Nigeria"> Nigeria </option>
                            <option value = "Niue"> Niue </option>
                            <option value = "Norfolk Island"> Đảo Norfolk </option>
                            <option value = "Na Uy"> Na Uy </option>
                            <option value = "Oman"> Oman </option>
                            <option value = "Pakistan"> Pakistan </option>
                            <option value = "Palau Island"> Palau Island </option>
                            <option value = "Palestine"> Palestine </option>
                            <option value = "Panama"> Panama </option>
                            <option value = "Papua New Guinea"> Papua New Guinea </option>
                            <option value = "Paraguay"> Paraguay </option>
                            <option value = "Peru"> Peru </option>
                            <option value = "Phillipines"> Philippines </option>
                            <option value = "Pitcairn Island"> Pitcairn Island </option>
                            <option value = "Poland"> Ba Lan </option>
                            <option value = "Portugal"> Bồ Đào Nha </option>
                            <option value = "Puerto Rico"> Puerto Rico </option>
                            <option value = "Qatar"> Qatar </option>
                            <option value = "Republic of Montenegro"> Cộng hòa Montenegro </option>
                            <option value = "Republic of Serbia"> Cộng hòa Serbia </option>
                            <option value = "Reunion"> Đoàn tụ </option>
                            <option value = "Romania"> Romania </option>
                            <option value = "Russia"> Nga </option>
                            <option value = "Rwanda"> Rwanda </option>
                            <option value = "St Barthelemy"> St Barthelemy </option>
                            <option value = "St Eustatius"> St Eustatius </option>
                            <option value = "St Helena"> St Helena </option>
                            <option value = "St Kitts-Nevis"> St Kitts-Nevis </option>
                            <option value = "St Lucia"> St Lucia </option>
                            <option value = "St Maarten"> St Maarten </option>
                            <option value = "St Pierre & Miquelon"> St Pierre & Miquelon </option>
                            <option value = "St Vincent & Grenadines"> St Vincent & Grenadines </option>
                            <option value = "Saipan"> Saipan </option>
                            <option value = "Samoa"> Samoa </option>
                            <option value = "Samoa American"> Samoa American </option>
                            <option value = "San Marino"> San Marino </option>
                            <option value = "Sao Tome & Principe"> Sao Tome & Principe </option>
                            <option value = "Saudi Arabia"> Saudi Arabia </option>
                            <option value = "Senegal"> Senegal </option>
                            <option value = "Seychelles"> Seychelles </option>
                            <option value = "Sierra Leone"> Sierra Leone </option>
                            <option value = "Singapore"> Singapore </option>
                            <option value = "Slovakia"> Slovakia </option>
                            <option value = "Slovenia"> Slovenia </option>
                            <option value = "Solomon Islands"> Quần đảo Solomon </option>
                            <option value = "Somalia"> Somalia </option>
                            <option value = "Nam Phi"> Nam Phi </option>
                            <option value = "Spain"> Tây Ban Nha </option>
                            <option value = "Sri Lanka"> Sri Lanka </option>
                            <option value = "Sudan"> Sudan </option>
                            <option value = "Suriname"> Suriname </option>
                            <option value = "Swaziland"> Swaziland </option>
                            <option value = "Thụy Điển"> Thụy Điển </option>
                            <option value = "Switzerland"> Thụy Sĩ </option>
                            <option value = "Syria"> Syria </option>
                            <option value = "Tahiti"> Tahiti </option>
                            <option value = "Taiwan"> Đài Loan </option>
                            <option value = "Tajikistan"> Tajikistan </option>
                            <option value = "Tanzania"> Tanzania </option>
                            <option value = "Thailand"> Thái Lan </option>
                            <option value = "Togo"> Togo </option>
                            <option value = "Tokelau"> Tokelau </option>
                            <option value = "Tonga"> Tonga </option>
                            <option value = "Trinidad & Tobago"> Trinidad & Tobago </option>
                            <option value = "Tunisia"> Tunisia </option>
                            <option value = "Turkey"> Thổ Nhĩ Kỳ </option>
                            <option value = "Turkmenistan"> Turkmenistan </option>
                            <option value = "Turks & Caicos Is"> Turks & Caicos Is </option>
                            <option value = "Tuvalu"> Tuvalu </option>
                            <option value = "Uganda"> Uganda </option>
                            <option value = "United Kingdom"> Vương quốc Anh </option>
                            <option value = "Ukraine"> Ukraine </option>
                            <option value = "United Arab Erimates"> United Arab Emirates </option>
                            <option value = "United States of America"> United States of America </option>
                            <option value = "Uraguay"> Uruguay </option>
                            <option value = "Uzbekistan"> Uzbekistan </option>
                            <option value = "Vanuatu"> Vanuatu </option>
                            <option value = "Vatican City State"> Vatican City State </option>
                            <option value = "Venezuela"> Venezuela </option>
                            <option value = "Vietnam"> Việt Nam </option>
                            <option value = "Virgin Islands (Brit)"> Quần đảo Virgin (Brit) </option>
                            <option value = "Virgin Islands (Hoa Kỳ)"> Quần đảo Virgin (Hoa Kỳ) </option>
                            <option value = "Wake Island"> Đảo Wake </option>
                            <option value = "Wallis & Futana Is"> Wallis & Futana Is </option>
                            <option value = "Yemen"> Yemen </option>
                            <option value = "Zaire"> Zaire </option>
                            <option value = "Zambia"> Zambia </option>
                            <option value = "Zimbabwe"> Zimbabwe </option>
                        </select>
                    </label>
                <label class="col-sm-6">
                    Bảo hành:
                    <select class="form-control select2" name="warranty">
                        <option value="1">1 năm</option>
                        <option value="2">2 năm</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-12">
                    Ảnh sản phẩm:
                    <input type="file" name="files[]" multiple />
                </label>
            </div>
        </div>
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary btn-block">Thêm mặt hàng</button>
        </div>
    </form>
</div>
</body>