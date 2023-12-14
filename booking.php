<?php
require_once "xuli_booking.php";
require_once "/buivananh_duan1/admin/inc/db_config.php";
require_once "/buivananh_duan1/admin/inc/essential.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điền Thông tin đặt phòng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php require "./inc/link.php" ?>
</head>
<body class="gb-light">
    <?php require "./inc/header.php";
    $nguoiDung = null;
    $phongFrom = null;

    if (isset($_GET['id'])) {
        $phong_id = $_GET['id'];
        $phongQuery = "SELECT * FROM phong WHERE id = $phong_id";
        $phongResult = mysqli_query($conn, $phongQuery);

        if ($phongResult && mysqli_num_rows($phongResult) > 0) {
            $phongFrom = mysqli_fetch_assoc($phongResult);
        } else {
            echo "Không tìm thấy thông tin phòng.";
        }
    }

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $userId = $_SESSION['user_id']; // user_id lưu phỉên đăng nhập theo id người dùng 
    $userQuery = "SELECT * FROM nguoi_dung WHERE id = $userId";
    $userResult = mysqli_query($conn, $userQuery);
    if ($userResult && mysqli_num_rows($userResult) > 0) {
        $nguoiDung = mysqli_fetch_assoc($userResult);
    } else {
        echo "Không tìm thấy thông tin người dùng.";
    }
    ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Điền Thông Tin Đặt Phòng</h2>
        <div class="h-line bg-dark"></div>
    </div>
    <div class="container">
        <div class="row">
            <!-- Phần thông tin người dùng -->
            <div class="col-lg-6">
                <h2>Thông tin người đặt</h2>
                <?php if ($nguoiDung) : ?>
                    <p>Tên Người Đặt : <?php echo htmlspecialchars($nguoiDung['name']); ?> </p>
                    <p>SDT :<?php echo htmlspecialchars($nguoiDung['sdt']); ?> </p>
                    <p>Email : <?php echo htmlspecialchars($nguoiDung['email']); ?> </p>
                    <p>CMND : <?php echo htmlspecialchars($nguoiDung['cmnd']); ?></p>
                    <p>Địa chỉ : <?php echo htmlspecialchars($nguoiDung['diachi']); ?></p>
                <?php else : ?>
                    <p>Thông tin người dùng ko xuất dc.</p>
                <?php endif; ?>

                <!-- Phần thông tin phòng -->
                <h2 class="text-center mb-4">Thông Tin Phòng</h2>
                <h5 class=" mb-4">Ảnh :</h5>
                <?php if ($phongFrom) : ?>
                    <img src="<?php echo htmlspecialchars($phongFrom['image']); ?>" style="width: 500px;" class="img-fluid mb-3" alt="Ảnh Phòng">
                    <h3>Tên Phòng: <?php echo htmlspecialchars($phongFrom['name']); ?> </h3>
                    <p>Loại Phòng: <?php echo htmlspecialchars($phongFrom['loaiphong_id']); ?> </p>
                    <p>Giá: <?php echo htmlspecialchars(number_format($phongFrom['gia'], 0, '.', ',')); ?> VND / Đêm </p>
                    <p>Dịch Vụ: <?php echo htmlspecialchars($phongFrom['dichvu']); ?></p>
                    <p>Số người: 2 người lớn , 2 trẻ em </p>
                <?php else : ?>
                    <p>Thông tin phòng không có sẵn.</p>
                <?php endif; ?>
            </div>

            <!-- Phần form đặt phòng -->
            <div class="col-lg-6">
                <h2 class="text-center mb-4">Đặt Phòng</h2>
                <form action="xuli_booking.php" method="POST">

                    <input type="hidden" name="phong_id" value="<?php echo $phong_id; ?>">

                    <div class="mb-3">
                        <p class="badge rounded-pill bg-light text-dark texr-wrap">Lưu ý : Khách sạn sẽ lấy thông tin tài khoản của bạn để làm thông tin đặt phòng để Checkin và Checkout cho quý khách !!!</p>
                        <div class="mb-3">
                            <label for="ngayBatDau" class="form-label">Check In:</label>
                            <p class="control">Ngày / Tháng / Năm</p>
                            <input type="date" class="form-control" id="ngayBatDau" name="NgayBatDau" required>
                        </div>

                        <div class="mb-3">
                            <label for="ngayKetThuc" class="form-label">Check Out:</label>
                            <p class="control">Ngày / Tháng / Năm</p>
                            <input type="date" class="form-control" id="ngayKetThuc" name="NgayKetThuc" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ghi Chú :</label>
                            <textarea class="form-control" id="ghiChu" name="ghichu" rows="5" placeholder="Bạn có thể viết lưu ý cho khách sạn hoặc không ."></textarea>
                        </div>

                        <div class="mb-3">
                            <h5>Phương thức thanh toán</h5>
                            <select name="phuongthuc" class="form-control shadow" required>
                                <?php foreach ($phuongThucThanhToan as $key => $value) : ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="datphong" class="btn btn-primary">Đặt Phòng</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <?php require "./inc/footer.php" ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // check chặn check out khi book 
    // JavaScript để cập nhật ngày check-out dựa trên ngày check-in
    document.getElementById('ngayBatDau').addEventListener('change', function() {
        var checkInDate = this.value;
        var checkOutDateInput = document.getElementById('ngayKetThuc');
        checkOutDateInput.min = checkInDate; // Cập nhật giá trị min cho check-out date
    });
</script>
</html>