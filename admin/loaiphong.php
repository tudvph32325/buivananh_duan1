<?php
require "/buivananh_duan1/admin/inc/db_config.php";
require "/buivananh_duan1/admin/inc/essential.php";

adminLogin();
// chuc nang xoa 
if (isset($_GET['delete'])) {
    // xoa theo id
    $id = $_GET['delete'];
    // truy van xoa 
    $q = "DELETE FROM `loai_phong` WHERE `id`=?";
    $result = xoa($q, [$id], 'i');

    // kiểm tra va xóa
    if ($result) {
        echo "<script>alert('Xóa loại phòng thành công'); window.location='loaiphong.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa loại phòng'); window.location='loaiphong.php';</script>";
    }
}
// chuc nang sua du lieu
// lam sau 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Phòng </title>
    <link rel="stylesheet" href="/admin/css/style.css">
    <?php
    require "/buivananh_duan1/admin/inc/link_admin.php";
    ?>
</head>
<body class="bg-light">
    <?php require "/buivananh_duan1/admin/inc/header.php"; ?>
    <div class="container-fluid" id="main-content">
        <div class="row">

            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Admin - Loại Phòng </h3>
                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">
                        <div class="text-end mb-4">
                            <button type="button" class="btn btn-darks shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room"><i class="bi bi-plus-square"></i>Thêm</button>
                        </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">id</th>
                                        <th scope="col">Tên Loại Phòng</th>
                                        <th scope="col">Mô tả</th>
                                        <th scope="col"><i class="bi bi-box-arrow-up-left"></i>Sửa</th>
                                        <th scope="col"><i class="bi bi-trash-fill"></i>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody id="room=-data">
                                    <?php
                                    // xuat truy van tu bang user_lienhe nhóm lại theo order by lấy theo id từ lớn đến : tức thêm trước xuất hiện trước ví dụ 5 4 3 2 1 
                                    $q = "SELECT * FROM `loai_phong` ORDER BY `id` DESC ";
                                    // thục thi câu lệnh truy vấn và dc lưu trong csdl là $con 
                                    // va thục thi cậu lệnh truy vấn $q
                                    $data = mysqli_query($conn, $q);
                                    $i = 1;
                                    // mysqli_fetch_assoc trích xuất dự liêu dc lưu trong mảng data ở csdl dc gắn vào biến $row
                                    // mang mysqli_fetch_assoc tra ve 1 mangg assoc kết hợp chứa các bản ghi từ truy vấn $data = mysqli_query($conn, $q);
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        echo <<<query
                                        <tr>
                                        <td>$i</td>
                                        <td>$row[name]</td>
                                        <td>$row[mota]</td>
                                        
                                        <td><a href="sualoaiphong.php?id={$row['id']}">Sửa</a></td>
                                        <td><a href="?delete=$row[id]" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a></td>
                                        </tr>
                                        query;
                                        $i++;
                                        //<td><a href="?edit=$row[id]">Sửa</a></td> // modal chinhr sua sss
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--modal them loai phong-->
    <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="add_room" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm Lọai Phòng</h5>
                    </div>
                    <div class="row">
                        <div class="modal-body">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tên</label>
                                <input type="text" name="name" class="form-control shadow" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả: </label>
                            <textarea name="mota" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Thoat</button>
                        <button name="them" type="submit" class="btn bg-custom text-dark shadow-none">Them</button>
                    </div>

                </div>
            </form>
        </div>

    </div>

    <?php
    // them du lieu vao csdl
    if (isset($_POST['them'])) {
        $loc_data = loc($_POST);
        $name = $loc_data['name'];

        // truy vấn kiểm tra xem có loại phòng này chưa
        $q = "SELECT * FROM `loai_phong` WHERE `name` =?";
        // truy van voi name loai phong type = s vì kiểu dữ liệu là chuỗi
        $result = select($q, [$name], 's');

        //mysqli_num_rows trả về số hàng kết quả từ truy vấn kết quả mà > 0 là đa có sẽ báo lỗi
        if (mysqli_num_rows($result) > 0) {
            // báo lỗi khi đa có
            //echo "<script>alert('Loại phòng này đã có rồi || Hãy thêm loại Phòng khác !!!');</script>";
            alert('error', 'Loại phòng này đã có rồi || Hãy thêm loại Phòng khác !!!');
        } else {
            // thuc hiện truy vấn
            $mota = $loc_data['mota'];
            $q = "INSERT INTO `loai_phong`(`name`,`mota`) VALUES (?,?)";
            // them dl 
            $result = insert($q, [$name, $mota], 'ss');
            if ($result) {
                echo "<script>alert('Thêm loại phòng thành công '); window.location='loaiphong.php';</script>";
            } else {
                echo "<script>alert('Thêm loại Phòng không thành công !!!');</script>";
            }
        }
    }

    // cap nhat du lieu lam sau
    ?>

    <?php require "/buivananh_duan1/admin/inc/scripts.php"; ?>
</body>

</html>