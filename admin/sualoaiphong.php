<?php
require "/buivananh_duan1/admin/inc/db_config.php";
require "/buivananh_duan1/admin/inc/essential.php";

adminLogin();

// Kiểm tra xem có ID loại phòng được truyền từ trang danh sách không
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Truy vấn thông tin loại phòng dựa trên ID
    $query = "SELECT * FROM `loai_phong` WHERE `id`=?";
    $result = select($query, [$id], 'i');
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Xử lý việc cập nhật thông tin loại phòng khi form được gửi đi
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $loc_data = loc($_POST);
            $name = $loc_data['name'];
            $mota = $loc_data['mota'];

            // Truy vấn cập nhật thông tin loại phòng
            $update_query = "UPDATE `loai_phong` SET `name`=?, `mota`=? WHERE `id`=?";
            $update_result = update($update_query, [$name, $mota, $id], 'ssi');

            if ($update_result) {
                echo "<script>alert('Cập nhật loại phòng thành công'); window.location='loaiphong.php';</script>";
            } else {
                echo "<script>alert('Lỗi khi cập nhật loại phòng');</script>";
            }
        }
    } else {
        echo "<script>alert('Không tìm thấy loại phòng với ID này'); window.location='loaiphong.php';</script>";
    }
} else {
    echo "<script>alert('Thiếu thông tin ID loại phòng'); window.location='loaiphong.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Loại Phòng</title>
    <link rel="stylesheet" href="/admin/css/style.css">
    <?php
    require "/buivananh_duan1/admin/inc/link_admin.php";
    ?>
</head>

<body class="bg-light">
    <?php require "/buivananh_duan1/admin/inc/header.php"; ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-6 ms-auto p-4">
                <h3 class="mb-4">Sửa Loại Phòng</h3>
                <form method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tên Loại Phòng</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="mota" class="form-control" rows="5" style="resize: none;" required><?php echo $row['mota']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <a href="loaiphong.php" class="btn btn-secondary">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require "/buivananh_duan1/admin/inc/scripts.php"; ?>
</body>

</html>