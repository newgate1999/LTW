<?php
require_once("models.php");
require_once("connection.php");

if (isset($_GET['id'])) {
    require_once("item_controller.php");
    $item_controller = new ItemController();
    $item = $item_controller->getItem($_GET['id']);
}

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

    if (isset($_GET['id'])) {
        require_once("category_controller.php");
        $category_controller = new CategoryController();
        $category_controller->delete_item($_GET['id']);
    }

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
    exit();
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
                    <input type="text" class="form-control" value="<?php if (isset($item)) echo $item['name'] ?>" placeholder="Tên mặt hàng" name="name" required="required">
                </div>
                <div class="col-sm-3">
                    <label>
                        Loại mặt hàng:
                        <select id="type" class="form-control select2" name="type">
                            <option value="Sofa">Sofa</option>
                            <option value="Ghế gỗ">Ghế gỗ</option>
                            <option value="Ghế nệm phòng">Ghế nệm phòng</option>
                            <option value="Ghế gỗ không tay">Ghế gỗ không tay</option>
                        </select>
                        <script>
                            selectElement('type', '<?php if (isset($item)) echo $item['type'];?>')

                            function selectElement(id, valueToSelect) {
                                let element = document.getElementById(id);
                                element.value = valueToSelect;
                            }

                        </script>
                    </label>
                </div>
                <div class="col-sm-3">
                    <label>
                        Giá:
                    </label>
                    <input type="text" class="form-control" placeholder="Giá" name="price" value="<?php if (isset($item)) echo $item['price'] ?>" required="required">
                </div>
                <div class="col-sm-3">
                    <label>
                        Vật liệu sản xuất:
                    </label>
                    <input type="text" class="form-control" placeholder="Vật liệu sản xuất" name="material" value="<?php if (isset($item)) echo $item['material'] ?>" required="required">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>
                Mô tả:
            </label>
            <textarea class="form-control" name="description" required="required"><?php if (isset($item)) echo $item['description']; ?></textarea>
        </div>
        <div class="form-group">
            <div class="row">
                    <label class="col-sm-6">
                        Chiều dài:
                        <input type="text" class="form-control" placeholder="Chiều dài" name="width" value="<?php if (isset($item)) echo $item['width'] ?>" required="required">
                    </label>
                <label class="col-sm-6">
                    Chiều rộng:
                    <input type="text" class="form-control" placeholder="Chiều rộng" name="height" value="<?php if (isset($item)) echo $item['height']; ?>" required="required">
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="col-sm-6">
                        Nhập khẩu từ:
                    <select id = "country" name = "imported_from" class = "form-control select2" required>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Åland Islands">Åland Islands</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antarctica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Bouvet Island">Bouvet Island</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Cote D'ivoire">Cote D'ivoire</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="French Southern Territories">French Southern Territories</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guernsey">Guernsey</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-bissau">Guinea-bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Isle of Man">Isle of Man</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jersey">Jersey</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                        <option value="Korea, Republic of">Korea, Republic of</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macao">Macao</option>
                        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                        <option value="Moldova, Republic of">Moldova, Republic of</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn">Pitcairn</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Romania">Romania</option>
                        <option value="Russian Federation">Russian Federation</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Helena">Saint Helena</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                        <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                        <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Timor-leste">Timor-leste</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Viet Nam">Viet Nam</option>
                        <option value="Virgin Islands, British">Virgin Islands, British</option>
                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                        </select>
                </label>
                <script>
                    selectElement('country', '<?php if (isset($item)) echo $item['imported_from'];?>')

                    function selectElement(id, valueToSelect) {
                        let element = document.getElementById(id);
                        element.value = valueToSelect;
                    }

                </script>
                <label class="col-sm-6">
                    Bảo hành:
                    <select id="warranty" class="form-control select2" name="warranty">
                        <option value="1">1 năm</option>
                        <option value="2">2 năm</option>
                    </select>
                    <script>
                        selectElement('warranty', '<?php if (isset($item)) echo $item['warranty'];?>')

                        function selectElement(id, valueToSelect) {
                            let element = document.getElementById(id);
                            element.value = valueToSelect;
                        }

                    </script>
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
        <?php if (!isset($_GET['id'])) { ?>
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-primary btn-block">Thêm mặt hàng</button>
            </div>
        <?php } else { ?>
        <div class="form-group">
            <button name="submit" type="submit" class="btn btn-primary btn-block">Chỉnh sửa mặt hàng</button>
        </div>
        <?php  } ?>
    </form>
</div>
</body>