<?php
// nhúng file các hàm và các check điều kiện
require_once "/buivananh_duan1/classphp_password.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lấy lại mật khẩu</title>
    <link rel="stylesheet" href="/CSS_rieng/css_quenmk.css">
    <?php require "./inc/link.php" ?>
</head>
<body class="gb-light">
    <?php //require "./inc/header.php" ?>
    <h2 class="mt-5 pt-4 mb-4 text-center">Chức năng Quên mật khẩu </h2>
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1 form">
            <button><a href="index.php"> <i class="bi bi-arrow-left"></i> Quay lại trang chủ</a></button>
                <form action="quenmk.php" method="POST" autocomplete="">
                    <h2 class="text-center">Lấy lại mật khẩu </h2>
                  
                    <p class="text-center">Nhập Email của bạn để lấy lại mật khẩu</p>
                    <!-- xuất lỗi ở trên đầu form lấy lại mk -->
                    <?php
                    // kiểm tra đếm nếu lớn hơn 0 thì xuất ra thông báo lỗi bên dưới
                    if (count($errors) > 0) {
                    ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            //uất ra thông báo lỗi bên dưới
                            foreach ($errors as $error) {
                                echo $error;
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Enter email address" required value="<?php echo $email  //xuat email ra cho lỗi   ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="check-email" value="Continue">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require "./inc/footer.php" ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script src="./pulic/js/sile_header.js"></script>
<script src="./pulic/js/chuyen_anh.js"></script>

</html>