<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phòng của khách sạn </title>
    <?php require "./inc/link.php" ?>
</head>
<style>
    .room img {
        width: 100%;
        height: auto;
    }

    .room h2 {
        color: #333;
        font-size: 1.5em;
    }

    .room p {
        color: #666;
        font-size: 1em;
    }

    .room {
        margin-bottom: 20px;
    }
</style>
<body class="gb-light">
    <?php require "./inc/header.php" ?>
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Tất cả các phòng Sang Trọng của khách sạn</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">Các phòng Sang Trọng của khách sạn </p>
            
    </div>
    <div class="container-fluid">
        <div class="row ">

            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2" style="text-align: center;">Xin chào đặt phòng yêu thích của bạn ngay bây giờ</h4>
                       
                </nav>

            </div>
            <!-- bat dau form xuat phong-->
            <div class="col-lg-9 col-md-12 px-4">

                <div class="container mt-4">
                    <div class="row">
                        <?php
                        require_once "/buivananh_duan1/admin/inc/db_config.php";
                        // truy vấn csdl // thuc hien INNER JOIN hien ten phong chứ ko phải hiện id as gia dinh 1 cot moi chua ten cua loai phong và dùng nó chưa tên loai phòng để xuất tên loại phòng
                        $phongQuery = "SELECT  phong.*, loai_phong.name AS ten_loai_phong FROM phong INNER JOIN loai_phong ON phong.loaiphong_id = loai_phong.id WHERE trangthai = 0";
                        // thực hiện gắn truy vấn gắn báo biến khởi tạo $phongResult
                        //mysqli_query có tác dụng trả về tập hợp dữ liệu chứa nhiều hàng dữ liệu kết hơp với mysqli_fetch_assoc lấy từng hàng dữ liệu lấy trong mysqli_query là tập hợp chứa nhiều dữ liệu 

                        $phongResult = mysqli_query($conn, $phongQuery);

                        // xuat phong voi mysqli_fetch_assoc // tác dụng của  mysqli_fetch_assoc là lấy từng hàng dữ liệu khi kết hợp với mysqli_query là tập hợp chưá nhiều dữ liệu 
                        //mysqli_query va mysqli_fetch_assoc làm việc với nhau 
                        // xu li xuat phong 

                        ?>

                        <?php while ($row = mysqli_fetch_assoc($phongResult)) : ?>
                            <div class="row g-0 align-items-center">
                                <div class="col-md-5 ">
                                    <img class="img-fluid rounded" src=" <?php echo $row['image']; ?> " alt="Ảnh lỗi">
                                </div>
                                <div class="col-md-5 ">
                                    <h5 class="mb-3">Tên Phòng : <?php echo $row['name']; ?> </h5>
                                    <h6 class="mb-3"> Loại Phòng : <?php echo $row['ten_loai_phong'] ?></h6>

                                    <div class="features mb-4">
                                        <h6 class="mb-1">Nội Thất :</h6>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-bed"></i> Giường</span>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-telephone"></i>Điện Thoại Bàn</span>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-snow"></i>Điều Hòa</span>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap"> <i class="bi bi-door-open"></i>cửa xổ </span>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-bath"></i> 1 Phòng Tắm</span>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-house-door"></i>1 Vệ Sinh</span>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-chair"></i>Ghế</span>
                                    </div>
                                    <div class="features2 mb-4">
                                        <h6 class="mb-1">Dịch Vụ :</h6>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap"> <?php echo $row['dichvu']; ?> </span>
                                    </div>
                                    <div class="songuoi mb-4">
                                        <h6 class="mb-1">Số người :</h6>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap">2 người lớn</span>
                                        <span class="badge rounded-pill bg-light text-dark texr-wrap">2 trẻ em</span>
                                        <div class="features2 mb-4">
                                            <h6 class="mb-1">Chất lượng</h6>
                                            <span class="badge rounded-pill bg-light ">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>

                                            </span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <h5 class="mb-4"><?php echo  number_format($row['gia'], 0, '.', ',') ?>  VND/Đêm</h5>
                                                
                                            </div>
                                            <div class="col-md-6 text-center">
                                                <h6 class="mb-4">  <?php echo trangThaiPhong($row['trangthai']); ?> </h6>

                                            </div>
                                        </div>

                                        <?php if ($isLoggedIn) : ?>
                                            <a href="booking.php?id=<?php echo $row['id']; ?>" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Đặt Ngay</a>

                                        <?php else : ?>

                                            <a href="#" onclick="alert('Bạn cần đăng nhập để thực hiện đặt phòng.');" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Đặt Ngay</a>

                                        <?php endif; ?>

                                        <a href="phong_chitiet.php?id=<?php echo $row['id']; ?>" name="chitiet" class="btn btn-sm w-100 btn-outline-dark shadow-none mb-2">Xem chi tiết</a>

                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end form xuat phong-->
    </div>
    </div>
    <?php require "./inc/footer.php" ?>
</body>
</html>