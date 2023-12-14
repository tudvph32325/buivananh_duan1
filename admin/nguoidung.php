<?php
require "/buivananh_duan1/admin/inc/db_config.php";
require_once "/buivananh_duan1/admin/inc/essential.php";

adminLogin();
// chuc năng xóa người dùng
if (isset($_GET['delete'])) {
    // xoa theo id
    $id = $_GET['delete'];
    // truy van xoa 
    $q = "DELETE FROM `nguoi_dung` WHERE `id`=?";
    $result = xoa($q, [$id], 'i');
    // kiểm tra va xóa
    if ($result) {
        echo "<script>alert('Xóa loại tài khoản người dùng thành công.'); window.location='nguoidung.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa tài khoản lỗi !!!'); window.location='nguoidung.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Thông tin người dùnb </title>
    <link rel="stylesheet" href="/admin/css/style.css">
    <?php
    require "/buivananh_duan1/admin/inc/link_admin.php";
    ?>
</head>

<body class="bg-light">
    <?php
    require "/buivananh_duan1/admin/inc/header.php";
    ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Admin - Người dùng </h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <!-- bang hien thong tin lien he-->
                        <div class="table-responsive-md" style="height:450px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">Id</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">SDT</th>
                                        <th scope="col">Địa chỉ</th>
                                        <th scope="col">CMND</th>
                                        <th scope="col">Chức Vụ</th>
                                        
                                        <th scope="col">Time tạo tài khoản</th>
                                        <th scope="col">Phân Quyền</th>

                                        <th scope="col">Hành Động </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    //xuat các tài khoản
                                    $q = "SELECT * FROM `nguoi_dung` ORDER BY `id` DESC ";
                                    $data = mysqli_query($conn, $q);
                                    
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($data)) {
                                      
                                        echo <<<query
                                <tr>
                                <td>$i</td>
                                <td>$row[name]</td>
                                <td>$row[email]</td>
                                <td>$row[sdt]</td>
                                <td>$row[diachi]</td>
                                <td>$row[cmnd]</td>
                                <td>$row[vaitro]</td>
                                
                                <td>$row[datetimeacc]</td>
                                <td>lam phan quyen</td>
                                <td><a href="?delete=$row[id]" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a></td>
                                </tr>
                                query;
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end bang hien thong tin lien he-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    require "/buivananh_duan1/admin/inc/scripts.php";
    ?>
</body>

</html>