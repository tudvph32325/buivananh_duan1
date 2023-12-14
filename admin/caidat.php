<?php
require "/buivananh_duan1/admin/inc/essential.php";
adminLogin();
// tao 1 id moi thay the id cu de bao mat 
// dang nhap thanh cong va thay doi id phien , thay doi id cu thanh moi
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài Đặt</title>
    <link rel="stylesheet" href="/admin/css/style.css">
    <?php
    require "/buivananh_duan1/admin/inc/link_admin.php";
    ?>
</head>

<body class="bg-light">
    <?php
    require "/buivananh_duan1/admin/inc/header.php";
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">cài đặt</h3>

                <!-- dat dau các o cai dat-->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="card-title mb-0">
                                Cài Đặt Chung //// Đang lỗi fix sau</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#caidatchung">
                                <i class="bi bi-pencil-square"></i>Chỉnh sửa
                            </button>
                        </div>
                        <h5 class="card-title"></h5>
                        <h6 class="card-subtitle mb-1 fw-bold">Tiêu đề trang</h6>
                        <p class="card-text" id="site_title"> </p>
                        <h6 class="card-subtitle mb-1 fw-bold">Về chúng tôi</h6>
                        <p class="card-text" id="site_about" > </p>
                    </div>
                </div>
                <!-- end cài đặt -->

                <!--bat dau  Modal chinh sua -->
                <div class="modal fade" id="caidatchung" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">

                        <form>

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cài đặt chung</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class=" mb-3">
                                        <label class="form-label">Tiêu đề trang WED</label>
                                        <input type="text" name="site_title" class="form-control shadow-none">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"> Về chúng tôi :</label>
                                        <textarea name="site-about" class="form-control shadow-none" rows="6"></textarea>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Thoát</button>
                                    <button name="" type="button" class="btn custom-bg shadow-none">Thiết Lập</button>
                                </div>
                            </div>


                        </form>

                    </div>
                </div>
                <!-- end chinh sua-->
            </div>
        </div>

        <?php
        require "/buivananh_duan1/admin/inc/scripts.php";
       
        ?>
</body>

<script>
    let general_data;
    function get_general() {
        // truy van tim gach chan duoi tieu de 
        let site_title = document.getElementById('site_title');
        let site_about = document.getElementById('site_about');
        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/caidat_curd.php",true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form=urlencoded');
      
        xhr.onload = function() {
            general_data = JSON.parse(this.responseText);
            site_title.innerText = general_data.site_title;
            site_about.innerText = general_data.site_about;
        }
        //
        xhr.send('get_general');
    }
    window.onload = function(){
        get_general();
    }
</script>
</html>

