<?php
require "/buivananh_duan1/admin/inc/db_config.php";
require "/buivananh_duan1/admin/inc/essential.php";

// ma hoa check xem phien da lam viec voi  adminLogin hay chua neu roi thi vao trang quan tri
// neu chua dang nhap voi tu cach admin voi tk bao gio thi ko cho vao trang admin 
// neu da tung lam viec va dang nhap admin truoc do 1 lan roi thi chuyen huong den trang dashboard.php dc dang nhap vao amdin
// test http://localhost:3000/admin/dashboard.php admin =>> thay the dashboard.php http://localhost:3000/admin/index.php da xac nhan da tung dang nhap admin 1 lan roi se chuyen de http://localhost:3000/admin/dashboard.php

//session_start();
// kiem tra xem là admin đã login lần nào chưa trên nếu là admin đưa đến trang chủ admin
if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
    //
    pageadmin('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Đăng nhập</title>
    <?php require "/buivananh_duan1/admin/inc/link_admin.php" ?>
    <link rel="stylesheet" href="./css/style.css">
</head>
<style>
    div.login-form {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
    }

    body {
        background-image: url('/images/about/rose.jpg');
        /* Thay thế 'path/to/your/image.jpg' bằng đường dẫn chính xác tới ảnh nền của bạn */
        background-size: cover;


    }

   form{
    position: absolute;
    right: -600px;
   }
</style>

<body class="bg-light">
    <div class="login-form text-center rounded bg-white shadow overflow-none ">

        <form method="post" id="ok">
            <h4>Chào mừng Ánh Admin </h4>
            <div class="mb-3">
                <input name="admin_name" type="text" class="form-control shdow-none text-center" placeholder="Admin tên " required>
            </div>
            <div class="mb-4">
                <input name="admin_pass" type="password" class="form-control shadow-none text-center" placeholder="mật khẩu" required>
            </div>
            <button name="Login" type="submit" class="btn custom-bg shadow-none">Đăng nhập</button>
        </form>
    </div>

    <?php
    if (isset($_POST['Login'])) {
        $loc_data = loc($_POST);

        $query = "SELECT * FROM `admin` WHERE `admin_name`=? AND `admin_pass`=?";
        // chuyen cac gia tri mysqli_stmt_bind_param vo dat values
        $values = [$loc_data['admin_name'], $loc_data['admin_pass']];
        //
        $result = select($query, $values, "ss");

        if ($result->num_rows == 1) {
            // echo "Got user chao mung ban den voi trang admin";
            // tien hanh dang nhap 
            // lay ket qua duoi dang mang , tra ve 1 ket qua
            $row = mysqli_fetch_assoc($result);

            // ma hao xoa bo phien lam viec
            //session_start(); // lam viec voi phien
            // echo"ok";

            $_SESSION['adminLogin'] = true;
            $_SESSION['adminId'] = $row['id']; // lay thong tin tu id o bang admin csdl xampp
            // khi dung thong tin chuyen huong den trang amdin 
            pageadmin('dashboard.php');
        } else {
            // canh bao neu ko nhap dung tk  
            alert('error', 'Login That bai - sai thong tin');
        }
    }
    ?>

    <?php require "/buivananh_duan1/admin/inc/scripts.php" ?>
</body>

</html>