<?php
require "/buivananh_duan1/admin/inc/db_config.php";
require "/buivananh_duan1/admin/inc/essential.php";

adminLogin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $phongQuery = "SELECT phong.*, loai_phong.name AS ten_loai_phong FROM phong INNER JOIN loai_phong ON phong.loaiphong_id = loai_phong.id WHERE phong.id = ?";
    $stmt = mysqli_prepare($conn, $phongQuery);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $phong = mysqli_fetch_assoc($result);
    if (!$phong) {
        die('Phòng không tồn tại');
    }
    mysqli_stmt_close($stmt);
} else {
    die('ID phòng không được chỉ định');
}

// Xử lý cập nhật thông tin phòng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnsubmit'])) {
    $tenPhong = loc($_POST['name']);
    $loaiPhong = loc($_POST['loaiphong_id']);
    $gia = loc($_POST['gia']);
    $dichvu = loc($_POST['dichvu']);
    $mota = loc($_POST['mota']);
    $trangThai = 0;//  checkbox cho trạng thái
    $imagePath = $phong['image']; // Mặc định giữ ảnh cũ



    // xu li ảnh khi cập nhật ảnh mới 
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $folderUpload = 'C:/buivananh_duan1/upload/';
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = time() . '-' . $_FILES['image']['name'];
        $destPath = $folderUpload . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $imagePath = $destPath;
            // fix lỗi ảnh đường dẫn tuyệt đối thành tuờng đối
            $imagePath = ' /upload/' . $fileName;


            $updateQuery = "UPDATE `phong` SET `name` = ?, `loaiphong_id` = ?, `image` = ?, `gia` = ? , `dichvu` = ? ,`mota` = ? , `trangthai` = ?  WHERE id = ? ";

            $stmt = mysqli_prepare($conn, $updateQuery);
           
            //mysqli_stmt_bind_param($stmt, 'sisdssi', $tenPhong, $loaiPhong, $imagePath, $gia, $dichvu, $mota, $trangThai);
            mysqli_stmt_bind_param($stmt, 'sisdssii', $tenPhong, $loaiPhong, $imagePath, $gia, $dichvu, $mota, $trangThai, $id);

            $result = mysqli_stmt_execute($stmt);
            // kiêm tra loi khi them phong loi mảng 
            mysqli_error($conn);

            if (!$result) {
                echo "Lỗi SQL: " . mysqli_error($conn);
            } else {
                header("Location: phong.php");
                //echo "<script>alert'Phòng đã được thêm thành công'</script>";
                //echo "<script>alert('Phòng đã được thêm thành công')</script>";
            }

            mysqli_stmt_close($stmt);
        } else {
            //echo "<script>alert('Thêm thành công'); window.location='phong.php';</script>";
            //echo "Phòng đã được thêm thành công.";
        }
    } else {
        //cho "Lỗi: Không có file được tải lên hoặc có lỗi xảy ra trong quá trình tải lên.";
        echo "<script>alert'Lỗi: Không có file được tải lên hoặc có lỗi xảy ra trong quá trình tải lên.'</script>";
    }
}

$loaiPhongQuery = "SELECT * FROM `loai_phong`";
$loaiPhongResult = mysqli_query($conn, $loaiPhongQuery);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Phòng</title>
    <!-- <link rel="stylesheet" href="/admin/css/style.css"> -->
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        select, input[type="text"], input[type="file"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="button"] {
            background-color: #ccc;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>

<body>
<div class="container">
        <h1>Chỉnh sửa thông tin phòng</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="loaiPhong">Danh mục phòng</label>
            <select name="loaiphong_id" id="loaiPhong">
                <?php while ($loai = mysqli_fetch_assoc($loaiPhongResult)) : ?>
<option value="<?php echo $loai['id']; ?>" <?php if ($loai['id'] == $phong['loaiphong_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($loai['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
           <div>
                <label for="tenPhong">Tên phòng</label>
                <input type="text" id="tenPhong" name="name" value="<?php echo htmlspecialchars($phong['name']); ?>" required>
           </div>
            
            <div>
                <label for="anhPhong">Ảnh phòng</label>
                <img src="<?php echo htmlspecialchars($phong['image']); ?>" alt="Ảnh phòng" style="width: 100px; height: auto;">
                <input type="file" id="anhPhong" name="image">
            </div>
            
            <div>
                <label for="giaPhong">Giá phòng</label>
                <input type="number" id="giaPhong" name="gia" value="<?php echo $phong['gia']; ?>" required>
            </div>

            <div>
                <label for="giaPhong">Giá phòng</label>
                <input type="text" id="giaPhong" name="dichvu" value="<?php echo $phong['dichvu']; ?>" required>
            </div>
            
            <div>
                <label for="moTa">Mô tả phòng</label>
                <textarea id="moTa" name="mota" rows="4" required><?php echo htmlspecialchars($phong['mota']); ?></textarea>
            </div>
            
            <button type="submit" name="btnsubmit">Chỉnh sửa</button>
            <button type="button" onclick="window.location='phong.php';">Quay về</button>
        </form>
    </div>
</body>
</html>