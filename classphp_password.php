<?php
session_start();
require "/buivananh_duan1/admin/inc/db_config.php";
require("PHPMailer-master/src/PHPMailer.php");
require("PHPMailer-master/src/SMTP.php");
require("PHPMailer-master/src/Exception.php");
// 
$email = "";
$name = "";
$errors = array();
// Xu ly gui email cấu hình hàm gửi email lất mã code và nhập xác minh và đổi mk
function sendVerificationEmail($email, $subject, $message)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "buianh2592003@gmail.com";
    $mail->Password = "hacrqlxgredgyqze";
    $mail->SetFrom("buianh2502003@gmail.com", " : "); // your email address and name
    $mail->Subject = $subject;

    $mail->Body = $message;
    $mail->AddAddress($email);
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}

//if user click continue button in forgot password form
// nếu người dùng ấn vào nút contine thì sẽ kiểm tra email đã có 
// kiểm tra xem người dùng đã ân nút check-email chưa và bắt đầu công việc
if (isset($_POST['check-email'])) {
    // lấy thông tin với hàm hoc đã đc xử lí các thông tin nhập vào
    $email = $_POST['email'];
    //$email = $_POST['email'];'
    // tạo truy vấn kiểm tra
    $check_email = "SELECT * FROM nguoi_dung WHERE email='$email'";
    // chay câu lệnh truy vấn kiểm tra
    $run_sql = mysqli_query($conn, $check_email);
    // kiểm tra điều kiện emai trong csdl này phải lớn hơn 0 tức là phải có trong csdl
    //
    if (mysqli_num_rows($run_sql) > 0) {
        // tạo biến code random code ngẫu nhiện gủi về email đó đã đăng ký để lấy nhập code và đổi mk mới
        $code = rand(999999, 111111);
        // lưu code vào csdl bẳng code 
        $insert_code = "UPDATE nguoi_dung SET code = $code WHERE email = '$email'";
        // chạy truy vấn kiểm tra và chạy lưu mã code mới
        $run_query =  mysqli_query($conn, $insert_code);
        // kiểm tra điều kiện 
        if ($run_query) {
            $subject = "Code dat lai mat khau cua ban ";
            $message = "Bui Van Anh Amdin gui code dat lai mat khau la : $code";
            //
            if (sendVerificationEmail($email, $subject, $message)) {
                $info = "Chúng tôi đã gửi mã otp mã code để đặt lại mật khẩu của bạn hãy vào - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: quenmk_resret-code.php');
                exit();
            } else {
                // nếu ko đc xuất hết các lỗi //
                $errors['otp-error'] = "Không gửi được mã đi !!!";
            }
        } else {
            $errors['db-error'] = "Đã xảy ra lỗi database khi  truy vấn !!!";
        }
    } else {
        $errors['email'] = "Địa chỉ email này không tồn tại hoặc chưa đăng ký tài khoản !!!";
    }
}

// //nếu người dùng nhấp vào kiểm tra nút đặt lại otp
if (isset($_POST['check-reset-otp'])) {
    $_SESSION['info'] = "";
    $otp_code = $_POST['otp'];

    $check_code = "SELECT * FROM nguoi_dung WHERE code = $otp_code";

    $code_res = mysqli_query($conn, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Vui lòng tạo một mật khẩu mới mà bạn không sử dụng trên bất kỳ trang web nào khác";
        $_SESSION['info'] = $info;
        header('location: quenmk_passnew.php');
        exit();
    } else {
        $errors['otp-error'] = "Bạn đã nhập sai mã !!!";
    }
}

// ////nếu người dùng nhấp vào nút thay đổi mật khẩu
if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    if ($pass !== $cpass) {
        $errors['pass'] = "Mật khẩu không giống nhau !!!";
    } else {
        //
        $code = 0;
        $email = $_SESSION['email']; //nhận email này bằng phiên

        // ma hóa pass khi lưu vào csdl

        $mahoa_pass = password_hash($pass, PASSWORD_BCRYPT);

        $update_pass = "UPDATE nguoi_dung SET code = $code, pass = '$mahoa_pass' WHERE email = '$email'";
        //mysqli_error($conn);
        // chạy câu lệnh truy vấn và check kiểm tra
        $run_query = mysqli_query($conn, $update_pass);

        if ($run_query) {
            $info = "Mật khẩu của bạn đã thay đổi. Bây giờ bạn có thể đăng nhập bằng mật khẩu mới của mình";
            $_SESSION['info'] = $info;
            header('Location: quenmk_login.php');
        } else {
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}

/// loginki đoi mk xong 
if(isset($_POST['login-now'])){
    header('Location: index.php');
}

