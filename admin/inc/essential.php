<?php
require_once "/buivananh_duan1/admin/inc/db_config.php";
// frontend purpose data // du lieu cho muc dinh giao dien người dùng 
//http://localhost:3000/buivananh_duan1
//http://127.0.0.1:80/buivananh_duan1, where ":80" is the default port for HTTP traffic. 
//http://127.0.0.1/dashboard/
define('SITE_URL','http://127.0.0.1/buivananh_duan1/');
define('ABOUT_IMG_PATH',SITE_URL.'/images/about');


// su lí upload anh
// backend upload process needs this data // qua trình tải lên dữ liệu cần những biến hằng này
define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/images');
define('ABOUT_FOLDER','about');

//essential file thiet yeu
// in canh bao
function alert($type, $msg)
{
    // kiem tra xem du lieu co banf success hay ko neu la dung true thi gia tri dang sau se la alert-danger
    $bs_class =  ($type == "success") ? "alert-success" : "alert-danger";

    echo '<div class="alert ' . $bs_class . ' alert-warning alert-dismissible fade show custom-alert" role="alert">
    <strong class="me-3">' . $msg . '</strong> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>';
}

// chuyen huong den trang cua admin
function pageadmin($url)
{
    echo "
     <script>window.location.href='$url'</script>";
}

// ham check adminLogin
function adminLogin()
{
    //session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        // neu ko phai la ad thi ve trang dang nhap
        echo "
     <script>window.location.href='index.php'</script>";
    }
    // tao 1 id moi thay the id cu de bao mat 
    // dang nhap thanh cong va thay doi id phien , thay doi id cu thanh moi
    session_regenerate_id(true);
}

// hàm upload file ảnh vào folder
function uploadImage($image,$folder){
    // su li anh dua vao 
    $valid_mime = ['image/jpeg','image/png','image/webp'];
    $img_mine = $image['type'];

    if(!in_array($img_mine,$valid_mime)){
        return 'inv_img'; // kêt thuc bang dinh dang anh ko hop le 
    }
    //
    else if(($image['size']/(1024*1024))>2){
        //
        return 'inv_size'; // kich thuoc anh lon hon 2mb
    }
    else{
        $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
        $rname = 'IMG_'.random_int(11111,99999)."$ext";

        $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
        if( move_uploaded_file($image['tmp_name'],$img_path)){
            return $rname;
        }
        else{
            return 'upd_failed';
        }
    }
}

// ham xoa anh 
function deleteImage($image , $folder){
    if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
        return true;
    }
    else{
        return false;
    }

}


