<?php
require_once "/buivananh_duan1/admin/inc/essential.php";
require_once "/buivananh_duan1/admin/inc/db_config.php";
danhxuat();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tài khảon</title>
    <?php require "/buivananh_duan1/inc/link.php" ?>
    <?php
    require "/buivananh_duan1/admin/inc/link_admin.php";
    ?>
</head>
<body class="bg-light">
    <?php
    //session_start();
    require "/buivananh_duan1/inc/header.php";
    // xuat thong tin tai khoan cho nguoi dung
    //  viết truy vấn xuất ra thông tin tài khoản cho người dùng 
    // lấy thông tin người dùng từ  đã  lưu trên session khi đăng nhập là user_id hoặc user_email 
    // đã lấy có ở trên phần dang nhap ko can viet nua
    //session_destroy();

    $user_id = $_SESSION['user_id'];  // lấy thông tin bằng user_id

    // truy vấn lấy thông tin người dùng ở csdk table nguoi_dung bang email  
    $Query = "SELECT * FROM nguoi_dung WHERE id = '$user_id'";
    // chayj truy vấn 
    $result = mysqli_query($conn, $Query);
    // kiểm tra 
    if ($result) {
       
        $user_data = mysqli_fetch_assoc($result);
    
    } else {
        // nếu truy vấn ko thành công xuất lỗi
        echo "khong lay dc thong tin nguoi dung";
    }
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
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Thông tin tài khoản người dùng</h2>
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
                                <!-- <li class="nav-item">
                                    <a class="nav-link text-white" href="user_binhluan.php">Bình luận đã viết</a>
                                </li> -->
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

                                            <th scope="col">Tên</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">SDT</th>
                                            <th scope="col">Địa chỉ</th>
                                            <th scope="col">CMND</th>
                                            <th scope="col">Time tạo tài khoản</th>
                                            <th scope="col">Hành Động </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php if (isset($user_data)) : ?>
                                            <tr>

                                                <td><?php echo $user_data['name']; ?></td>
                                                <td><?php echo $user_data['email']; ?></td>
                                                <td><?php echo $user_data['sdt']; ?></td>
                                                <td><?php echo $user_data['diachi']; ?></td>
                                                <td><?php echo $user_data['cmnd']; ?></td>
                                                <td><?php echo $user_data['datetimeacc']; ?></td>

                                                <td><a href="user_cntaikhoan.php?id=<?php echo $user_data['id'];?>">Chỉnh sửa</a>.</td>
                                            </tr>
                                        <?php else : ?>
                                            <h6>Không thể hiển thị thông tin người dùng</h6>
                                        <?php endif; ?>




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