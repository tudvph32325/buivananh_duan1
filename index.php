<?php
require_once "/buivananh_duan1/admin/inc/db_config.php";
require_once "/buivananh_duan1/admin/inc/essential.php";

$loaiPhongQuery = "SELECT * FROM `loai_phong`";
$loaiPhongResult = mysqli_query($conn, $loaiPhongQuery);

$phongQuery = "SELECT  phong.*, loai_phong.name AS ten_loai_phong FROM phong INNER JOIN loai_phong ON phong.loaiphong_id = loai_phong.id WHERE phong.trangthai = 0 LIMIT 9";

$phongResult = mysqli_query($conn, $phongQuery);

// xu li book phòng khi người dùng đặt phòng thành công sẽ mất phòng đó đi trên giao diện

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ </title>
    <?php require "./inc/link.php" ?>
</head>
<body class="gb-light">
    <?php require "./inc/header.php" ?>
    <!-- sile ảnh -->
    <div class="container-fluid px-lg-4 mt-4 ">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="pulic/images/carousel/1.png" class="w-100 d-block" />
                </div>
                <div class="swiper-slide">
                    <img src="pulic/images/carousel/2.png" class="w-100 d-block" />
                </div>
                <div class="swiper-slide">
                    <img src="pulic/images/carousel/3.png" class="w-100 d-block" />
                </div>
                <div class="swiper-slide">
                    <img src="pulic/images/carousel/4.png" class="w-100 d-block" />
                </div>
                <div class="swiper-slide">
                    <img src="pulic/images/carousel/5.png" class="w-100 d-block" />
                </div>
            </div>

        </div>
    </div>
    <!-- end sile ảnh -->

    <!-- tìm kiếm  tra form có sẵn -->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Phòng </h5>

                <form action="timkiem_phong.php" method="POST" > 
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Ngày đi :</label>
                            <input type="date" class="form-control shadow-none">
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;">Ngày đến :</label>
                            <input type="date" class="form-control shadow-none">
                        </div>

                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight: 500;">Chọn loại phòng</label>
                            <select name="loaiphong_id" class="form-control shadow" required>
                                <option value="">Chọn loại phòng</option>
                                <?php while ($row = mysqli_fetch_assoc($loaiPhongResult)) : ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight: 500;">Chọn số người</label>
                            <select class="form-control shadow" required>
                                <option selected>Chọn số người</option>
                                <option value="1">2 người lớn 2 trẻ em</option>
                            </select>
                        </div>

                        <div class="col-lg-2 mb-lg-3 mt-2  ">
                            <button type="submit" name="timkiem" class="btn text-white shadow-none custom-bg">Tìm Phòng</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!--end fom check phong -->

    <!-- phong trang chủ-->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font"> Phòng Sang trọng của chúng tôi</h2>

    <div class="container">
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($phongResult)) : ?>
                <div class="col-lg-4 col-md-6 my-3">
                    <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="<?php echo  $row['image']; ?>" style=" width: 350px; height: 300px;" alt="Ảnh đang lỗi fix sau" class="card-img-top">
                        <div class="card-body">
                            <h5> Tên Phòng :<?php echo $row['name']; ?> </h5>
                            <h6>Tên loại phòng :<?php echo $row['ten_loai_phong']; ?></h6>
                            <h6 class="mb-4">Giá phòng : <?php echo  number_format($row['gia'], 0, '.', ','); ?> VNĐ / Đêm </h6>
                            <div class="features mb-4">
                                <h6 class="mb-1">Nội Thất :</h6>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap"> Giường</span>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap">Điện Thoại Bàn</span>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap">Điều Hòa</span>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap">cửa xổ </span>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap">1 Phòng Tắm</span>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap">1 Vệ Sinh</span>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap">Ghế</span>
                            </div>
                            <div class="features mb-4">
                                <h6 class="mb-1">Dịch vụ</h6>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap"><?php echo $row['dichvu']; ?></span>
                            </div>
                            <div class="songuoi mb-4">
                                <h6 class="mb-1">Số người </h6>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap">2 người lớn</span>
                                <span class="badge rounded-pill bg-light text-dark texr-wrap">2 trẻ em </span>
                            </div>
                            <div class="rating mb-4">
                                <h6 class="mb-1">Chất Lượng</h6>
                                <span class="badge rounded-pill bg-light ">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>

                                </span>
                            </div>
                            <div class="rating mb-4">
                                <h6 class="mb-1"><?php echo trangThaiPhong($row['trangthai']); ?></h6>
                            </div>
                            <div class="d-flex justify-content-evenly mb-2">

                                <?php if ($isLoggedIn) : ?>
                                    <a href="booking.php?id=<?php echo $row['id']; ?>" class="btn btn-sm text-white custom-bg shadow-none">Đặt Ngay</a>

                                <?php else : ?>

                                    <a href="#" onclick="alert('Bạn cần đăng nhập để thực hiện đặt phòng.');" class="btn btn-sm text-white custom-bg shadow-none">Đặt Ngay</a>

                                <?php endif; ?>

                                <a href="phong_chitiet.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-dark shadow-none">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <!--3 end cac phong theo ô xuông xuất hiện ở trang chủ-->
            <div class="col-lg-12 text-center mt-5">
                <a href="phong.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow">Xem Thêm</a>
            </div>
        </div>
    </div>
    <!-- end phong ơ trang chu-->

    <!-- cac dich vu them cua khach san-->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font"> Các dịch vụ của khách sạn</h2>
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
    <div class="col-lg-12 text-center mt-5">
        <a href="/trang_coso.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow">Xem Thêm Các dịch vụ</a>
    </div>
    </div>
    <!-- end các dịch vu them cua khach san-->

    <!-- các bài đánh gía về khách sạn-->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Đánh giá về khách sạn</h2>
    <div class="container mt-5">
        <div class="swiper swiper-testimonials">
            <div class="swiper-wrapper">
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center p-4">
                        <img src="" alt="">
                        <h6 class="m-0">Bùi Văn Ánh</h6>
                    </div>
                    <p>Tôi là một cá nhân yêu thích công nghệ và tri thức. Tôi luôn hứng thú với việc học hỏi và chia sẻ kiến thức với mọi người. Tôi có kinh nghiệm trong lĩnh vực lập trình và công nghệ thông tin</p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center p-4">
                        <img src="" alt="">
                        <h6 class="m-0">Đỗ Trọng Bằng</h6>
                    </div>
                    <p>Khách sạn tuyệt lắm Tôi luôn hứng thú với việc học hỏi và chia sẻ kiến thức với mọi người. Tôi có kinh nghiệm trong lĩnh vực lập trình và công nghệ ,Tôi có kinh nghiệm trong lĩnh vực lập trình và công nghệ</p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center p-4">
                        <img src="" alt="">
                        <h6 class="m-0">Tú</h6>
                    </div>
                    <p>Tôi là một cá nhân yêu thích việc ngủ tại khách sạn này Tôi luôn hứng thú với việc học hỏi và chia sẻ kiến thức với mọi người. Tôi có kinh nghiệm trong lĩnh vực lập trình và công nghệ </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center p-4">
                        <img src="" alt="">
                        <h6 class="m-0">Ronaldo CR7</h6>
                    </div>
                    <p> khách sạn này Tôi luôn hứng thú với việc học hỏi và chia sẻ kiến thức với mọi người. Tôi có kinh nghiệm trong lĩnh vực lập trình và công nghệ , luôn hứng thú với việc học hỏi và chia sẻ kiến thức với mọi người. Tôi có kinh nghiệm trong lĩnh vực lập trình và công nghệ </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="col-lg-12 text-center mt-5">
            <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow">Xem Thêm Các đánh giá</a>
        </div>
    </div>
    <!-- end các bài viết blog về khách san-->
    <?php require "./inc/footer.php" ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script src="./pulic/js/sile_header.js"></script>
<script src="./pulic/js/chuyen_anh.js"></script>
</html>