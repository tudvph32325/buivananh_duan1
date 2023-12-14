
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Thông Tin Người Dùng</title>
    <link rel="stylesheet" href="CSS_rieng/css_cntaikhoan.css">
</head>
<style>
    
/* Đặt phông nền và màu cho cả trang */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
}

/* Định dạng cho form */
form {
    max-width: 500px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Định dạng cho các phần tử div chứa các trường input */
form div {
    margin-bottom: 10px;
}

/* Định dạng cho các trường input */
input[type="text"],
input[type="email"] {
    width: calc(100% - 22px);
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 3px;
}

/* Định dạng cho nút submit */
input[type="submit"] {
    background-color: #5cb85c;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #4cae4c;
}

/* Định dạng cho nút 'Quay về' */
button {
    background-color: #f0ad4e;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

button:hover {
    background-color: #ec971f;
}

</style>
<body>

<?php
// Kết nối cơ sở dữ liệu
require_once "/buivananh_duan1/admin/inc/db_config.php";

// truy vấn xuất thông tin ng dung de chỉnh sửa
if(isset($_GET['id']) && !empty($_GET['id'])){
    $user_id = $_GET['id'];
    $query = "SELECT name, email, sdt, diachi, cmnd FROM nguoi_dung WHERE id = '$user_id'";
    $result = mysqli_query($conn, $query);
    if($result){
        $user_data = mysqli_fetch_assoc($result);
    } else {
        die("Lỗi khi truy vấn thông tin người dùng");
    }
} else {
    header('Location: user_taikhoan.php');
    exit();
}

// Xử lý việc cập nhật thông tin người dùng
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];
    $cmnd = $_POST['cmnd'];
    
    // Cập nhật cơ sở dữ liệu
    $update_query = "UPDATE nguoi_dung SET name='$name', email='$email', sdt='$sdt', diachi='$diachi', cmnd='$cmnd' WHERE id='$user_id'";
    if(mysqli_query($conn, $update_query)){
        // Chuyển hướng về trang thông tin người dùng sau khi cập nhật thành công
        header('Location: user_taikhoan.php');
        exit();
    } else {
        echo "Lỗi cập nhật thông tin người dùng";
    }
}
?>


<form action="user_cntaikhoan.php?id=<?php echo $user_id; ?>" method="post">
    <div>
        Tên: <input type="text" name="name" value="<?php echo $user_data['name']; ?>">
    </div>
    <div>
        Email: <input type="email" name="email" value="<?php echo $user_data['email']; ?>">
    </div>
    <div>
        Số điện thoại: <input type="text" name="sdt" value="<?php echo $user_data['sdt']; ?>">
    </div>
    <div>
        Địa chỉ: <input type="text" name="diachi" value="<?php echo $user_data['diachi']; ?>">
    </div>
    <div>
        CMND/CCCD: <input type="text" name="cmnd" value="<?php echo $user_data['cmnd']; ?>"><br>
    </div>
    <div>
        <input type="submit" value="Cập nhật" onclick="return confirm('Bạn chắc chắn muốn cập nhật lại không?')">
        <button type="button" onclick="window.location='user_taikhoan.php';">Quay về</button>
    </div>
</form>
</body>
</html>