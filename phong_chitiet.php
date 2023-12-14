<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Phòng</title>
    <!-- Đảm bảo đã kết nối Bootstrap 5 -->
    <?php require "./inc/link.php" ?>
</head>
<body class="gb-light">
    <?php require "./inc/header.php" ?>
    <?php
    require_once "/buivananh_duan1/admin/inc/db_config.php";

    if (isset($_GET['id'])) {
        // lấy thông tin và xem chi tiết phòng bằng id 
        $phong_id = $_GET['id'];

        // truy vấn lấy thông tin chi tiết của phòng dựa theo id
        // truy vấn 
        //$phongchitietQuery = "SELECT * FROM phong WHERE id = $phong_id";
        $phongchitietQuery = "SELECT phong.*, loai_phong.name AS loai_phong FROM phong 
                     JOIN loai_phong ON phong.loaiphong_id = loai_phong.id
                     WHERE phong.id = $phong_id";
        // fix hiên thi tên loai phòng sau

        // trả kết quả về với biến tạo kết quả 
        $phongchitietResult = mysqli_query($conn, $phongchitietQuery);

        if ($phongchitietResult) {
            // nêu có các thông tin truy vấn đc cho vào phongchitietResult thì khai báo 1 biến mới dùng mysqli_fetch_assoc lấy dữ liêụ từ mảng kết hợp 
            $phongchitiet = mysqli_fetch_assoc($phongchitietResult);
            // xuát chi tiết xuống form bên dưới
        } else {
            echo "Lỗi truy vấn chi tiết phòng";
        }
    }
    ?>

    <!-- Phần thông tin chi tiết phòng -->
    <section class="container my-5">
        <h2>Chi tiết phòng :</h2>
        <div class="row">
            <!-- Cột ảnh phòng -->
            <div class="col-lg-8 mb-3">
                <h4>Ảnh</h4>
                <img src="<?php echo  $phongchitiet['image'] ?>" class="img-fluid" alt="Ảnh Phòng">
            </div>

            <!-- Cột thông tin phòng -->
            <div class="col-lg-4">
                <div class="mb-3">
                    <h3 class="h-font fw-bold">Tên phòng : <?php echo $phongchitiet['name']; ?> </h3>
                    <p class="mb-1"> <?php //echo $phongchitiet['loaiphong_id']; ?> </p>
                    <p class="mb-1"> Loại Phòng : <?php echo $phongchitiet['loai_phong']; ?> </p>

                    <div class="features mb-4">
                        <h6 class="mb-1">Nội Thất :</h6>
                        <span class="badge rounded-pill bg-light text-dark texr-wrap">Giường</span>
                        <span class="badge rounded-pill bg-light text-dark texr-wrap">cửa xổ </span>
                        <span class="badge rounded-pill bg-light text-dark texr-wrap">Phòng Tắm</span>
                        <span class="badge rounded-pill bg-light text-dark texr-wrap">Phòng Vệ Sinh</span>
                        <span class="badge rounded-pill bg-light text-dark texr-wrap">Ghế</span>
                    </div>

                    <div class="features2 mb-4">
                        <h6 class="mb-1">Dịch Vụ :</h6>
                        <span class="badge rounded-pill bg-light text-dark texr-wrap"><?php echo $phongchitiet['dichvu']  ?></span>

                    </div>

                    <div class="songuoi mb-4">
                        <h6 class="mb-1">Số người :</h6>
                        <span class="badge rounded-pill bg-light text-dark texr-wrap">2 người lớn</span>
                        <span class="badge rounded-pill bg-light text-dark texr-wrap">2 trẻ em</span>
                    </div>

                    <div class="mb-2">
                        <h6>Chất Lượng :</h6>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>

                    <div class="mb-2">
                        <h6>Tình Trạng :</h6>
                        <span style="font-size: 20px;" class="badge rounded-pill bg-light text-dark texr-wrap"><?php echo trangThaiPhong($phongchitiet['trangthai']); ?></span>

                    </div>

                    <!-- <h4 class="mb-4"> . number_format($row['gia'], 0, '.', ',') .  </h4> -->
                    <h4 class="mb-4"> <?php echo number_format($phongchitiet['gia'], 0, '.', ',') ?> VND / Đêm</h4>
                    <div class="d-grid gap-2">

                        <?php if ($isLoggedIn) : ?>
                            <a href="booking.php?id=<?php echo $phongchitiet['id'] ?>" class="btn btn-dark">Đặt Ngay</a>
                        <?php else : ?>
                            <a href="#" onclick="alert('Bạn cần đăng nhập để thực hiện đặt phòng.');" class="btn btn-dark">Đặt Ngay</a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h3 class="h-font fw-bold">Dịch vụ mỗi phòng có khách sạn đều có : </h3>
                <div class="container">
                    <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
                        <div class="col-lg-1 col-md-2 text-center bg-white rounded">
                            <img src="./pulic/images/facilities/w.svg" width="80px">
                            <h5 class="mt-3">Wifi</h5>
                        </div>
                        <div class="col-lg-1 col-md-2 text-center bg-white rounded">
                            <img src="./pulic/images/facilities/d.svg" width="80px">
                            <h5 class="mt-3">Máy lạnh</h5>
                        </div>
                        <div class="col-lg-1 col-md-2 text-center bg-white rounded">
                            <img src="./pulic/images/facilities/giat.jpg" width="80px">
                            <h5 class="mt-3">Giặt ủi</h5>
                        </div>
                        <div class="col-lg-1 col-md-2 text-center bg-white rounded">
                            <img src="./pulic/images/facilities/dien.svg" width="80px">
                            <h5 class="mt-3">Điện</h5>
                        </div>
                        <div class="col-lg-1 col-md-2 text-center bg-white rounded">
                            <img src="./pulic/images/facilities/r.svg" width="80px">
                            <h5 class="mt-3">Radio</h5>
                        </div>
                        <div class="col-lg-1 col-md-2 text-center bg-white rounded">
                            <img src="./pulic/images/facilities/t.svg" width="80px">
                            <h5 class="mt-3">Tivi</h5>
                        </div>
                        <div class="col-lg-1 col-md-2 text-center bg-white rounded">
                            <img src="https://th.bing.com/th/id/OIP.rLGYYFSpoakm4F0OQVhoGAHaHx?rs=1&pid=ImgDetMain" width="80px">
                            <h5 class="mt-3">Điện Thoại Bàn</h5>
                        </div>

                    </div>
                </div>


            </div>
        </div>
        <!-- Phần mô tả chi tiết -->
        <div class="row mt-4">
            <div class="col-12">
                <h3 class="h-font fw-bold">Thông tin chi tiết</h3>
                <p><?php echo $phongchitiet['mota'] ?></p>
                <!-- Thêm mô tả chi tiết khác tại đây -->
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h3 class="h-font fw-bold">Khách sạn AYBITI</h3>
                <p>Khách sạn AYBITI là một khách sạn sang trọng tọa lạc tại Hà Nội, Việt Nam. Sứ mệnh của khách sạn là mang đến cho khách hàng những trải nghiệm nghỉ dưỡng tuyệt vời nhất, với chất lượng dịch vụ tốt nhất và không gian sống đẳng cấp.

                    Khách sạn AYBITI cung cấp nhiều loại phòng khác nhau, bao gồm phòng Standard, Superior, Deluxe, Suite, President Suite, honeymoon, Twin, Double và Bungalow . Ngoài ra, khách sạn còn cung cấp các dịch vụ như wifi, giặt ủi, điện, điều hòa, radio và tivi .

                    Nếu bạn muốn tận hưởng một kỳ nghỉ đầy đủ tiện nghi và sang trọng, hãy đến với khách sạn AYBITI. Chúng tôi cam kết sẽ mang đến cho bạn những trải nghiệm nghỉ dưỡng tuyệt vời nhất.</p>
                <h4 class="h-font fw-bold">Các dịch vụ có sẵn theo phòng :</h4>
                <ul>
                    <li><img src="/pulic/images/facilities/dien.svg" style="width: 60px;">Dịch vụ Điện</li>
                    <li><img src="/pulic/images/facilities/d.svg" style="width: 60px;">Dịch vụ Điều Hòa</li>
                    <li><img src="/pulic/images/facilities/giat.jpg" style="width: 60px;">Dịch vụ Giặt Ủi</li>
                    <li><img src="/pulic/images/facilities/w.svg" style="width: 60px;">Dịch vụ WIFI</li>
                    <li><img src="/pulic/images/facilities/r.svg" style="width: 60px;">Dịch vụ Radio</li>
                    <li><img src="/pulic/images/facilities/t.svg" style="width: 60px;">Dịch vụ Tivi</li>
                    <li><img src="https://th.bing.com/th/id/OIP.rLGYYFSpoakm4F0OQVhoGAHaHx?rs=1&pid=ImgDetMain" style="width: 60px;">Dịch vụ Điện Thoại Bàn</li>

                </ul>
            </div>
            <h4 class="h-font fw-bold">Không gian khách sạn :</h4>

            <div class="container">
                <div class="row">

                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="/pulic//images/rooms/anh.jpg" style=" width: 400px; height: 400px;" alt="Ảnh đang lỗi fix sau" class="card-img-top">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="/pulic//images/rooms/anh2.jpg" style=" width: 400px; height: 400px;" alt="Ảnh đang lỗi fix sau" class="card-img-top">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="/pulic//images/rooms/anh3.jpg" style=" width: 400px; height: 400px;" alt="Ảnh đang lỗi fix sau" class="card-img-top">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="/pulic//images/rooms/anh4.jpg" style=" width: 400px; height: 400px;" alt="Ảnh đang lỗi fix sau" class="card-img-top">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="/pulic//images/rooms/anh5.jpg" style=" width: 400px; height: 400px;" alt="Ảnh đang lỗi fix sau" class="card-img-top">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                            <img src="/pulic//images/rooms/anh6.jpg" style=" width: 400px; height: 400px;" alt="Ảnh đang lỗi fix sau" class="card-img-top">
                        </div>
                    </div>


                </div>
            </div>


    </section>
    <?php require "./inc/footer.php" ?>
</body>
</html>