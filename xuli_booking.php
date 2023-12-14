<?php
//session_start();
require_once "/buivananh_duan1/admin/inc/db_config.php";
require_once "/buivananh_duan1/admin/inc/essential.php";
$phuongThucThanhToan  = [
    'Thanh Toán Khi Trả Phòng' => 'Thanh toán khi trả Phòng',
    // 'thanh_toan_truc_tuyen' => 'Thanh toán trực tuyến',
];

if (isset($_POST['datphong'])) {
    $phong_id = $_POST['phong_id'];
    $NgayBatDau = $_POST['NgayBatDau'];
    $NgayKetThuc = $_POST['NgayKetThuc'];
    $ghichu = $_POST['ghichu'];
    $phuongthuc = $_POST['phuongthuc'];

    $userId = $_SESSION['user_id']; // lấy thông tin người từ phiên thông tin đn đã lưu để thêm 

    $Query = "SELECT gia FROM  phong WHERE id = ?";
    // mysqli_prepare chuẩn bị câu lệnh trước khi thực thi trả về đôi tượng và gán giá trị vào mysqli_stmt_bind_param
    $stmt = mysqli_prepare($conn, $Query);
    mysqli_stmt_bind_param($stmt, "i", $phong_id);
    // chạy câu lênh sql dc chuẩn bị trước đo 
    mysqli_stmt_execute($stmt);
    //khởi tạo biến  lấy kết trả về từ câu lệnh  mysqli_prepare chứa các kết quả
    $result = mysqli_stmt_get_result($stmt);
    // khởi tạo 1 biến để lấy 1 hàng kết quả từ 1 tập kết quả trả về trước đó
    $row = mysqli_fetch_assoc($result);
    // tạo biến giá phòng để lưu gía phòng đã lấy đc 
    $giaPhong = isset($row['gia']) ? $row['gia'] : 0; // Sử dụng giá trị mặc định nếu không tìm thấy

    $NgayBatDau = new DateTime($_POST['NgayBatDau']);
    $NgayKetThuc = new DateTime($_POST['NgayKetThuc']);
    // thực hiện tính tổng tiền theo checkin checkout 
    // tính toán số ngày
    
    $soNgay = $NgayBatDau->diff($NgayKetThuc)->days;
   
    $tongTien = $giaPhong  * $soNgay;

    $FormatNgayBatDau = $NgayBatDau->format('Y-m-d');

    $FormatNgayKetThuc = $NgayKetThuc->format('Y-m-d');
    

    $datPhongQuery = "INSERT INTO dat_phong (phong_id, NgayBatDau, NgayKetThuc, tongTien, ghichu, phuongthuc, trangthai ,nguoidung_id) VALUES (?, ?, ?, ?, ?, ?, 0 , ?)";
    $stmt = mysqli_prepare($conn, $datPhongQuery);
    mysqli_stmt_bind_param($stmt, "ississi", $phong_id, $FormatNgayBatDau,  $FormatNgayKetThuc, $tongTien, $ghichu, $phuongthuc, $userId);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // lấy id của đơn đặt phòng mới
        $datPhongId = mysqli_insert_id($conn);
        // lấy id của session 
        $_SESSION['datPhongId'] = $datPhongId; // luư thông tin id vào sesson 
        // in ra thông báo và chuyển hướng 
        echo "<script>alert('Đặt phòng thành công , Xin hãy chờ khách sạn xác nhận !!!'); window.location='user_hoadon.php';</script>";
        // sang user_hoadon viêts truy vấn xuất thông tin và trang thai cho người dùng xem
        //header('Location:user_hoadon.php'); 


        // set trạng thái sau khi người dùng đặt phòng thành công 
        $updatePhongSQL = "UPDATE phong SET trangthai = 1 WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updatePhongSQL);
        mysqli_stmt_bind_param($stmt, 'i', $phong_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Đặt phòng thất bại.";
    }

    mysqli_stmt_close($stmt);
}

//mysqli_close($conn);
