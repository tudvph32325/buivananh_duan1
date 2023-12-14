<?php
if (isset($_POST['dangxuat'])) {
    session_start();
    session_destroy(); // Xóa tất cả session
    header("Location: index.php"); // Chuyển hướng người dùng về trang chủ
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đặt phòng</title>
    <?php require "/buivananh_duan1/inc/link.php" ?>
    <?php
    require "/buivananh_duan1/admin/inc/link_admin.php";
    ?>

</head>

<body class="bg-light">
    <?php
    require "/buivananh_duan1/inc/header.php";
    ?>
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
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Lịch sử đặt phòngt</h2>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 bg-warning border-top border-3 border-secondary" id="dashboard-menu" style="height: 500px;">

                <nav class="navbar navbar-expand-lg ">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2 text-light ">Chức năng </h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#loc" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="loc">

                            <ul class="nav nav-pills flex-column">

                                <h4 class="mt-2 text-red ">Tổng quan</h4>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="/admin/index.php">Đăng Nhâp ADMIN</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="user_taikhoan.php">Thông tin tài khoản </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-white" href="user_hoadon.php">Hóa đơn đặt phòng</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-white" href="user_lichsu.php">Lịch sử đặt phòng</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-white" href="user_binhluan.php">Bình luận đã viết</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-white" href="phong.php">Xem thêm phòng</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-white" href="index.php">Về trang chủ</a>
                                </li>

                                <form method="post">
                                    <button type="submit" name="dangxuat" class="btn btn-outline-dark shadow-none me-lg-3 me-2">
                                        Đăng Xuất
                                    </button>
                                </form>

                            </ul>

                        </div>
                </nav>
            </div>

            <!-- Nội dung chính -->
            <div class="col-lg-10" id="main-content">

                <div class="card border-0 shadow-sm mb-4">
                    <!-- (Nội dung bảng thông tin người dùng) -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <!-- bang hien thong tin lien he-->
                            <div class="table-responsive-md" style="height:450px; overflow-y:scroll;">
                                <table class="table table-hover border">
                                    <thead class="sticky-top">
                                        <tr class="bg-dark text-light">
                                            <th scope="col">Id</th>
                                            <th scope="col">Tên</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <h1>xuất Lịch sử đặt phòng và chức năng xóa lich su </h1>

                                    </tbody>
                                </table>
                            </div>
                            <!-- end bang hien thong tin lien he-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    require "/buivananh_duan1/inc/footer.php";
    ?>
    <?php
    require "/buivananh_duan1/admin/inc/scripts.php";
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script src="./pulic/js/sile_header.js"></script>
<script src="./pulic/js/chuyen_anh.js"></script>

</html>