<?php
// nhúng file các hàm và các check điều kiện
require_once "/buivananh_duan1/classphp_password.php";
?>

<?php
// $email = $_SESSION['email'];
// if ($email == false) {
//     header('Location:index.php');
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuyển đến trang đn</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="/CSS_rieng/css_quenmk.css">
    <?php require "./inc/link.php" ?>
</head>
<body class="gb-light">
    <?php //require "./inc/header.php" ?>
    <h2 class="mt-5 pt-4 mb-4 text-center">Chức năng Quên mật khẩu </h2>
    <div class="container">
    <div class="row">
            <div class="col-md-4 offset-md-4 form login-form">
                <?php
                if (isset($_SESSION['info'])) {
                ?>
                    <div class="alert alert-success text-center">
                        <?php echo $_SESSION['info']; ?>
                    </div>
                <?php
                }
                ?>
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="login-now" value="Đến trang đăng nhập">
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