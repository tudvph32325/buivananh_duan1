<?php
require_once "/buivananh_duan1/admin/inc/db_config.php";
danhxuat();

// xuat thong tin dat phong thong tin nguoi dung va thông tin phòng phong da dat gom cả thông tin đã điền ở from 
// xuat thong tin va check in check out cho người dùng 
$userId = $_SESSION['user_id']; // lấy id người dùng đã đăng nhập đã lưu ở user_id
// truy vấn
$xuatThongTin = "SELECT nguoi_dung.name AS nguoiDungTen, nguoi_dung.email, nguoi_dung.sdt, nguoi_dung.diachi, nguoi_dung.cmnd, 
        phong.name AS tenPhong, phong.loaiphong_id, phong.image, phong.dichvu, dat_phong.id,
        dat_phong.NgayBatDau, dat_phong.NgayKetThuc, dat_phong.ghichu, dat_phong.tongTien, dat_phong.phuongthuc, dat_phong.trangthai 
        FROM dat_phong 
        JOIN nguoi_dung ON dat_phong.nguoidung_id = nguoi_dung.id 
        JOIN phong ON dat_phong.phong_id = phong.id 
        WHERE nguoi_dung.id = ?";

//
$stmt = mysqli_prepare($conn, $xuatThongTin);
mysqli_stmt_bind_param($stmt, "i", $userId); // xuất theo các thông tin đặt theoo user_id người dùng đă 
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// chức năng xóa đặt phòng
if (isset($_GET['delete'])) {
    // Lấy ID đặt phòng cần hủy
    $id = $_GET['delete'];

    // Thực hiện cập nhật trạng thái phòng bằng 0
    $updateQuery = "UPDATE phong SET trangthai = 0 WHERE id IN (SELECT phong_id FROM dat_phong WHERE id = ?)";
    $updateStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "i", $id);
    mysqli_stmt_execute($updateStmt);

    // Sau khi cập nhật trạng thái phòng, thực hiện xóa đặt phòng
    $deleteQuery = "DELETE FROM `dat_phong` WHERE `id`=?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "i", $id);

    if (mysqli_stmt_execute($deleteStmt)) {
        echo "<script>alert('Hủy đặt phòng thành công'); window.location='user_hoadon.php';</script>";
    } else {
        echo "<script>alert('Hủy đặt phòng thất bại !!! ); window.location='user_hoadon.php';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn</title>
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
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Hóa Đơn đặt phòng & Thông tin đặt phòng</h2>
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
                                            <!-- <th scope="col">id</th> -->
                                            <th scope="col">Tên</th>
                                            <th scope="col">SDT</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Địa Chỉ</th>
                                            <th scope="col">CMND</th>
                                            <th scope="col">Tên Phòng</th>
                                            <th scope="col">Loại phòng</th>
                                            <th scope="col">Ảnh phòng </th>
                                            <th scope="col">Dịch vụ</th>
                                            <th scope="col">Check in</th>
                                            <th scope="col">Check out</th>
                                            <th scope="col">Tổng Tiền</th>
                                            <th scope="col">Ghi chú</th>
                                            <th scope="col">Hình Thức Thanh toán</th>
                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">hành động</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                            <input type="hidden" <?php echo htmlspecialchars($row['id']); ?>>
                                            <th scope="col"><?php echo htmlspecialchars($row['nguoiDungTen']); ?></th>
                                            <th scope="col"><?php echo htmlspecialchars($row['email']); ?></th>
                                            <th scope="col"><?php echo htmlspecialchars($row['sdt']); ?></th>
                                            <th scope="col"><?php echo htmlspecialchars($row['diachi']); ?></th>
                                            <th scope="col"><?php echo htmlspecialchars($row['cmnd']); ?></th>
                                            <th scope="col"><?php echo htmlspecialchars($row['tenPhong']); ?></< /th>
                                            <th scope="col"> <?php echo htmlspecialchars($row['loaiphong_id']); ?> </th>
                                            <th scope="col"><img src="<?php echo htmlspecialchars($row['image']); ?>" width="150px" height="100px"></th>
                                            <th scope="col"><?php echo htmlspecialchars($row['dichvu']); ?></th>
                                            <th scope="col"><?php echo htmlspecialchars($row['NgayBatDau']); ?></th>
                                            <th scope="col"><?php echo htmlspecialchars($row['NgayKetThuc']); ?></th>
                                            <th scope="col"><?php echo number_format($row['tongTien'], 0, '.', ','); ?> VNĐ</th>
                                            <!-- number_format($row['tongTien'], 0, '.', ','); ?> -->
                                            <th scope="col"><?php echo htmlspecialchars($row['ghichu']); ?></th>
                                            <th scope="col"><?php echo htmlspecialchars($row['phuongthuc']); ?></th>
                                            <th scope="col">

                                                <?php
                                                // xuất trạng thái ra cho người dùng 
                                                if ($row['trangthai'] == 0) {
                                                    echo "Chờ xác nhận";
                                                } elseif ($row['trangthai'] == 1) {
                                                    echo "Đã xác nhận";
                                                } elseif ($row['trangthai'] == 2) {
                                                    echo "Đã hủy";
                                                } else {
                                                    echo "Không xác định";
                                                }
                                                ?>
                                            </th>
                                            <th scope="col"><a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc muốn hủy đặt phòng chứ ?')">Hủy</a></th>
                                    </tbody>
                                <?php endwhile; ?>

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
    require "/buivananh_duan1/admin/inc/scripts.php";
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script src="./pulic/js/sile_header.js"></script>
<script src="./pulic/js/chuyen_anh.js"></script>

</html>