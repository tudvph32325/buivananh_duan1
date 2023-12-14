<?php
session_start();
$hostname = "localhost";
$svnname = "root";
$pass = "";
$dbname = "buivananh_duan1";
// kết nối 
$conn = mysqli_connect($hostname, $svnname, $pass, $dbname);

// hàm loc du lieu dc gui tu bieu mau form 
// loại bỏ những lí tự khoảng trắng vs bảo vệ dự liệu loại bỏ thẻ html và php ở chuổi , tránh xử
// lí dữ liệu ko đúng cách 

//xoa boi den doi thanh loc 
// function fflocffff($data)
// {
//     // fix loi khi chuyền 1 chuõio thành 1 mảng 
//     // ham dc viết đẻ xử lí các gía trị cuả 1 mảng
//     if(!is_array($data)){
//         //su li gan gía tri giá cho biến data($data) thành 1 mangg
//         $data = array($data); 

//     }

//     foreach ($data as $key => $value) {
//         // $data[$key] = trim($value);
//         // $data[$key] = stripslashes($value);
//         // $data[$key] = htmlspecialchars($value);
//         // $data[$key] = strip_tags($value);

//         $value = trim($value);
//         $value = stripslashes($value); //Loại bỏ ký tự backslashes ("") để tránh việc xử lý dữ liệu không đúng cách.
//         $value = htmlspecialchars($value); //Chuyển đổi các ký tự đặc biệt thành các thẻ HTML tương ứng để tránh tấn công XSS (Cross-Site Scripting).
//         $value = strip_tags($value); //Loại bỏ các thẻ HTML và PHP khỏi chuỗi.

//         //$data[$key] 
//         // lọc giá trị va ghi đè lẫn nhau nhiều lần và trả về gía trị value
//         $data[$key]  = $value;
//         // bao ve ung dung khoi cac cuoc tan cong va toan ven du lieu 
//     }
//     return $data;
// }
// 

// 
// function locloichuafix($data) {
//     // Loại bỏ các khoảng trắng thừa ở đầu và cuối chuỗi
//     $data = trim($data);

//     // Loại bỏ các dấu backslashes (\)
//     $data = stripslashes($data);

//     // Chuyển đổi các ký tự đặc biệt thành thực thể HTML
//     // Điều này ngăn chặn tấn công XSS
//     $data = htmlspecialchars($data);

//     // Loại bỏ các thẻ HTML và PHP khỏi chuỗi
//     $data = strip_tags($data);

//     return $data;
// }

// fix lỗi hàm loc
function loc($data)
{
    if (is_array($data)) {
        //  neu data la mot mang ap dung ham loc cho moi phan tu cua cua mang
        foreach ($data as $key => $value) {
            //
            $data[$key] = loc($value);
        }
        return $data;
    } else if (is_string($data)) {
        // neu data la mot chuoi ap dubg cac ham lam sach chuop 
        $data = trim($data); // Loại bỏ khoảng trắng thừa
        $data = stripslashes($data); // Loại bỏ backslashes
        $data = htmlspecialchars($data); // Chuyển đổi ký tự đặc biệt thành thực thể HTML
        $data = strip_tags($data); // Loại bỏ các thẻ HTML và PHP
        return $data;
    } else {
        // neu data ko phai 1 chuoi mag se tra ve 1 mang nguyen ban 
        return $data;
    }
}

// ham truy van du 
function select($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];
    //mysqli_prepare truy van du lieu nhieu lan 
    // chuyen tham so la conn va sql
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // stmt bien trong prepared statement la cau lenh chuan bi truy van 1 lan va nhieu lan
        // lien ket cac bien voi tham so truy van mysqli_prepare
        //...$value xu li du lieu tham so ko xac dinh khi lam viec 
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        // chuc nang thuc thi 
        if (mysqli_stmt_execute($stmt)) {
            // tai len va luu tru du lieu 
            $result = mysqli_stmt_get_result($stmt);
            //
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            mysqli_stmt_close($stmt);
            // ko truy van dc se die
            die("Khong tra ve ket qua truy van va du lieu tu executed - SELECT !!!");
        }
    } else {
        // ko truy van dc se die
        die("Khong tra ve ket qua truy van va du lieu tu preparad- SELECT !!!");
    }
}

// ham truy van tat ca du lieu
function selectALL($table)
{
    $conn = $GLOBALS['conn'];
    $result = mysqli_query($conn, "SELECT * FROM $table ");
    return $result;
}

// ham cap nhat du lieu
function update($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        // chuc nang thuc thi 
        if (mysqli_stmt_execute($stmt)) {
            // tai len va luu tru du lieu 
            $result = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            mysqli_stmt_close($stmt);
            // ko truy van dc se die
            die("Khong cap nhat va truy van du lieu tu executed - UPDATE !!!");
        }
    } else {
        // ko truy van dc se die
        die("Khong cap nhat va truy van du lieu tu preparad - Update !!!");
    }
}

// ham them du lieu
function insert($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        // chuc nang thuc thi 
        if (mysqli_stmt_execute($stmt)) {
            // tai len va luu tru du lieu 
            $result = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            mysqli_stmt_close($stmt);
            // ko truy van dc se die
            die("Khong cap nhat va truy van du lieu tu executed - INSERT!!!");
        }
    } else {
        // ko truy van dc se die
        die("Khong cap nhat va truy van du lieu tu preparad - INSERT !!!");
    }
}

// hàm xoa du lieu 
function xoa($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        // chuc nang thuc thi 
        if (mysqli_stmt_execute($stmt)) {
            // tai len va luu tru du lieu 
            $result = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            mysqli_stmt_close($stmt);
            // ko truy van dc se die
            die("Khong cap nhat va truy van du lieu tu executed - DELETE !!!");
        }
    } else {
        // ko truy van dc se die
        die("Khong cap nhat va truy van du lieu tu preparad - DELETE !!!");
    }
}

// ham thay doi  trang thai 

// dat trang thai phong khi them 
// nguoi dùng book phong và dc xác nhận đặt phòng phòng sẽ có trạng thái ko thẻ thuê
function trangThaiPhong($trangThai)
{
    return $trangThai == 0 ? "Có thể thuê" : "Không thể thuê";
} 

function danhxuat(){
    if (isset($_POST['dangxuat'])) {
        session_start();
        session_destroy(); // Xóa tất cả session
        header("Location:index.php"); // Chuyển hướng người dùng về trang chủ
        exit;
        //require "/buivananh_duan1/index.php";
    }
}


