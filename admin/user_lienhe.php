<?php
require "/buivananh_duan1/admin/inc/db_config.php";
require "/buivananh_duan1/admin/inc/essential.php";

adminLogin();
// chuc nang seen đánh dấu là đã đọc liên hệ & đánh dấu đã đọc all
// kiểm tra xem đã ấn út đanh dấu đa đọc chưa và thực hiện chức năng isset 
if (isset($_GET['seen'])) {
    // lọc data url để đánh dấu là đã đọc với phương thức GET
    $loc_data = loc($_GET);
    if ($loc_data['seen'] == 'all') {
        // xu li doc tat ca 
        // đánh dấu đọc tất cả
        // xóa tất cả du lieu ơ bang lien he 
        $q = "UPDATE `user_lienhe` SET `seen`=?";
        // tao 1 bien moi $values gắn là 1 tức khi đã đánh đầu tất cả là 1 đã đọc tất cả  
        $values = [1];
        // i như 1 tham số cho hàm update tham số i liên quan đến kiêu dữ liệu trong $values i đại diện cho kiểu int và các giá trị trong mảnng  $values là số nguyên 
        if (update($q, $values, 'i')) {
            alert('success', 'Đã đánh dấu tất cả đọc');
        } else {
            // nếu lỗi sẽ hiện lỗi error
            alert('error', 'Không thể đánh dấu đã đọc tất cả !!!');
        }
    } else {
        // cap nhat du lieu da đọc trong csdl với UPDATE seen là đa đọc 
        // seen ? id ? // ? đại đien cho tham số với điều kiện chưa xác đinh cứ thêm vào các cột có tên là seen và id 
        $q = "UPDATE `user_lienhe` SET `seen`=? WHERE `id`=?";
        // cập nhật giá trị khi ấn seen là 1 ở bảng user_lienhe với seen từ 0 thành 1 gắn nó vào biến khởi tạo là $values 
        $values = [1, $loc_data['seen']];
        // nếu ấn là đã đọc sẽ hiện thông báo là đã đọc và update trong csdl là 1
        // và mất nút đánh dấu là đã đọc trên list 
        if (update($q, $values, 'ii')) {
            alert('success', 'Đã đánh dấu là đã đọc');
        } else {
            // nếu lỗi sẽ hiện lỗi error
            alert('error', 'Không thể đánh dấu là đã đọc !!!');
        }
    }
}

// chức năng xóa liên hệ & xóa all 
if (isset($_GET['del'])) {
    // lọc data url để đánh dấu là đã đọc với phương thức GET
    // tạo biến loc_data gắn hàm loc để lọc dữ liệu từ mảng trong csdl và sử lí công việc xóa
    $loc_data = loc($_GET);

    // xoa tat ca các lien he có trong bảng
    // nếu loc_data có type = del và giá trị == all thì thực hiện xóa tất cả
    if ($loc_data['del'] == 'all') {
        // xoa tat ca các lien he có trong bảng
        $q = "DELETE FROM `user_lienhe`";
        // $values = [$loc_data['del']];
        if (mysqli_query($conn, $q)) {
            // nếu truy vấn trong csdl ở bảng user_lienhe có thì thực hiến xóa tất cả thành công sẽ hiện xóa hết tất cả thành công
            alert('success', 'Xóa tất cả thành công ');
        } else {
            // nếu lỗi sẽ hiện lỗi error
            alert('error', 'Xóa tất cả thất bại !!!');
        }
    } else {
        $q = "DELETE FROM `user_lienhe` WHERE `id`=?";
        $values = [$loc_data['del']];
        if (xoa($q, $values, 'i')) {
            alert('success', 'Xóa thành công ');
        } else {
            // nếu lỗi sẽ hiện lỗi error
            alert('error', 'Xóa thất bại !!!');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - dashboard </title>
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
                <h3 class="mb-4">Admin - Người dùng liên hệ</h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <!-- danh dau doc all & xoa all-->
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm"><i class="bi bi-check-all"></i>Đánh dấu đọc Tất cả</a>

                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm"><i class="bi bi-trash"></i>Xóa Tất cả</a>
                        </div>
                        <!-- end danh dau doc all & xoa all-->

                        <!-- bang hien thong tin lien he-->
                        <div class="table-responsive-md" style="height:450px; overflow-y:scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">Id</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Email</th>
                                        <th scope="col" style="width: 20%;">Chủ thể</th>
                                        <th scope="col" style="width: 30%;">Lời Nhắn</th>
                                        <th scope="col">Ngày Tháng</th>
                                        <th scope="col">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // xuat truy van tu bang user_lienhe nhóm lại theo order by lấy theo id từ lớn đến : tức thêm trước xuất hiện trước ví dụ 5 4 3 2 1 
                                    $q = "SELECT * FROM `user_lienhe` ORDER BY `id` DESC ";
                                    // thục thi câu lệnh truy vấn và dc lưu trong csdl là $con 
                                    // va thục thi cậu lệnh truy vấn $q
                                    $data = mysqli_query($conn, $q);
                                    $i = 1;

                                    // mysqli_fetch_assoc trích xuất dự liêu dc lưu trong mảng data ở csdl dc gắn vào biến $row
                                    // mang mysqli_fetch_assoc tra ve 1 mangg assoc kết hợp chứa các bản ghi từ truy vấn $data = mysqli_query($conn, $q);
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        // check seen 
                                        // tao 1 bien seen rong de kiem tra
                                        $seen = '';
                                        // neu seen khac 1 thì xuat ra thong bao la da đọc tin nhắn liên hệ gửi từ người dùng
                                        if ($row['seen'] != 1) {
                                            // nếu đánh đầu là đã đọc thì về trang 
                                            // http://localhost:3000/admin/user_lienhe.php?seen=5
                                            $seen = "<a href='?seen=$row[id]' class='btn btn-sm rounded-pill btn-primary'>Đánh dấu<br>là đã đọc</a>";
                                        }
                                        // nối chuổi thêm chức năng xóa 
                                        $seen .= "<a href='?del=$row[id]' class='btn btn-sm rounded-pill btn-danger mt-2'>Xóa liên hệ</a>";
                                        echo <<<query
                                        <tr>
                                        <td>$i</td>
                                        <td>$row[name]</td>
                                        <td>$row[email]</td>
                                        <td>$row[subject]</td>
                                        <td>$row[message]</td>
                                        <td>$row[date]</td>
                                        <td>$seen</td>
                                        </tr>
                                        query;
                                        $i = 1;
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