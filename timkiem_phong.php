<?php
require_once "/buivananh_duan1/admin/inc/db_config.php";
require_once "/buivananh_duan1/admin/inc/essential.php";

$loaiPhongQuery = "SELECT * FROM `loai_phong`";

$loaiPhongResult = mysqli_query($conn, $loaiPhongQuery);
// khởi tạo 1 biến chứa kết quả là rỗng để dùng chứa kết quả 
$result = null;
// xu lí xuat phong cho người dùng với điều kiện người dùng trọn loaiphong
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST['timkiem'])) {

    // lấy thông tin khi post lên 
    $loaiPhong = $_POST['loaiphong_id'];

    // xu li truy vấn tìm kiềm ra cho người dùng xen dựa theo yêu cầu ngưoì dung tìm kiếm theo loại phòng 
    //$query = "SELECT * FROM phong WHERE loaiphong_id = $loaiPhong";
    $query = "SELECT phong.*, loai_phong.name AS ten_loai_phong FROM phong
              INNER JOIN loai_phong ON phong.loaiphong_id = loai_phong.id
              WHERE phong.loaiphong_id = $loaiPhong";
    // tạo 1 biến mới truy vấn và chứa kểt quả 
    $result = mysqli_query($conn, $query);

    // xuất và kiểm tra điều kiện 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm phòng </title>
    <?php require "./inc/link.php" ?>
</head>
<style>
    .room img {
        width: 100%;
        height: auto;
    }

    .room h2 {
        color: #333;
        font-size: 1.5em;
    }

    .room p {
        color: #666;
        font-size: 1em;
    }

    .room {
        margin-bottom: 20px;
    }
</style>
<body class="gb-light">
    <?php require "./inc/header.php"; ?>
    <div class="my-5 px-4">
        <h3 class="fw-bold h-font text-center"> Phòng Theo Yêu Cầu của Qúy khách</h3>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Phòng Theo Yêu Cầu của Qúy khách

        </p>
    </div>
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid flex-lg-column align-items-stretch">
                        <h4 class="mt-2">Bộ Lọc</h4>
                        <form action="timkiem_phong.php" method="POST">
                            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#loc" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="loc">
                                <div class="border bg-light p-3 rounded mb-3">
                                    <h5 class="mb-3" style="font-size: 18px;">Kiểm tra phòng có và đặt ngày :</h5>
                                    <label  for="" class="form-label">Ngày đi</label>
                                    <input required type="date" class="form-control shadow-none">
                                    <label for="" class="form-label">Ngày đến</label>
                                    <input required type="date" class="form-control shadow-none">
                                </div>



                                <div class="border bg-light p-3 rounded mb-3">
                                    <label class="form-label" style="font-weight: 500;">Chọn loại phòng</label>
                                    <select name="loaiphong_id" class="form-control shadow" required>
                                        <option value="">Chọn loại phòng</option>
                                        <?php while ($row = mysqli_fetch_assoc($loaiPhongResult)) : ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div  class="border bg-light p-3 rounded mb-3">
                                    <label class="form-label" style="font-weight: 500;" >Chọn số người</label>
                                    <select class="form-control shadow" required>
                                        <option  selected>Chọn số người</option>
                                        <option value="1">2 người lớn 2 trẻ em</option>
                                    </select>
                                </div>

                                <button type="submit" name="timkiem">Lọc Phòng</button>
                            </div>
                    </div>
                    </form>
                </nav>

            </div>
            <!-- bat dau form xuat phong-->

            <div class="col-lg-9 col-md-12 px-4">
                <?php if ($result && mysqli_num_rows($result) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <div class="container mt-4">
                            <div class="row">
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-5 ">
                                        <img class="img-fluid rounded" src="<?php echo  $row['image']; ?>" alt="Ảnh lỗi">
                                    </div>
                                    <div class="col-md-5 ">
                                        <h5 class="mb-3">Tên Phòng : <?php echo $row['name']; ?> </h5>
                                        <h6 class="mb-3"> Loại Phòng : <?php echo $row['ten_loai_phong']; ?> </h6>

                                        <div class="features mb-4">
                                            <h6 class="mb-1">Nội Thất :</h6>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-bed"></i> Giường</span>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-telephone"></i>Điện Thoại Bàn</span>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-snow"></i>Điều Hòa</span>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap"> <i class="bi bi-door-open"></i>cửa xổ </span>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-bath"></i> 1 Phòng Tắm</span>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-house-door"></i>1 Vệ Sinh</span>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap"><i class="bi bi-chair"></i>Ghế</span>
                                        </div>
                                        <div class="features2 mb-4">
                                            <h6 class="mb-1">Dịch Vụ : <?php echo $row['dichvu']; ?></h6>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap"> </span>
                                        </div>
                                        <div class="songuoi mb-4">
                                            <h6 class="mb-1">Số người :</h6>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap">2 người lớn</span>
                                            <span class="badge rounded-pill bg-light text-dark texr-wrap">2 trẻ em</span>
                                            <div class="features2 mb-4">
                                                <h6 class="mb-1">Chất lượng</h6>
                                                <span class="badge rounded-pill bg-light ">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                    <i class="bi bi-star-fill text-warning"></i>

                                                </span>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 text-center">
                                                    <h5 class="mb-4">  <?php echo  number_format($row['gia'], 0, '.', ','); ?> VND/Đêm</h5>

                                                </div>
                                                <div class="col-md-6 text-center">
                                                    <h6 class="mb-4"> <?php echo trangThaiPhong($row['trangthai']); ?></h6>

                                                </div>
                                            </div>

                                            <?php if ($isLoggedIn) : ?>
                                                <a href="booking.php?id=<?php echo $row['id']; ?>" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Đặt Ngay</a>

                                            <?php else : ?>

                                                <a href="#" onclick="alert('Bạn cần đăng nhập để thực hiện đặt phòng.');" class="btn btn-sm w-100 text-white custom-bg shadow-none mb-2">Đặt Ngay</a>

                                            <?php endif; ?>

                                            <a href="phong_chitiet.php?id=<?php echo $row['id']; ?>" name="chitiet" class="btn btn-sm w-100 btn-outline-dark shadow-none mb-2">Xem chi tiết</a>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        <?php endwhile; ?>
                    <?php else : ?>
                        <p>Không có phòng như bạn yêu cầu . </p>
                    <?php endif; ?>

                        </div>
            </div>
        </div>
        <!-- end form xuat phong-->

    </div>
    </div>
    <?php require "./inc/footer.php" ?>
</body>

</html>