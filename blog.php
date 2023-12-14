<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Viết </title>
    <?php require "/buivananh_duan1/inc/link.php" ?>
</head>

<body class="gb-light">
    <?php require "./inc/header.php" ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Các bài viết HOT</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Hãy lựa chọn đúng đắn cho bản thân khi quyết định đặt phòng khách sạn của chúng tôi qua những bài phê bình và đánh giá khách quan nhất của những người viết bài về khách sạn của chúng tôi .
        </p>
    </div>

    <div class="container">
        <div class="row ">

            <!-- bai viet 1 -->
            <div class="col-lg-4 col-md-6 my-3">
                <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                    <img src="./pulic/images/rooms/IMG_11892.png" class="card-img-top">

                    <!-- phong -->
                    <div class="card-body">
                        <h4>Review cơ sở khách sạn </h4>
                        <h6 class="mb-4">Tác giả : Rose</h6>
                        <p class="mb-4">Với cơ sở tốt nhất ở mọi nơi trên Hà Nội khách sạn luôn đi đôi</p>
                        <div class="features mb-4">
                            <h6 class="mb-1">Lượt đọc :</h6>
                            <span class="badge rounded-pill bg-light text-dark texr-wrap">149 lượt đọc</span>
                        </div>

                        <div class="rating mb-4">
                            <h6 class="mb-1">Đánh giá</h6>
                            <span class="badge rounded-pill bg-light ">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </span>
                        </div>

                        <div class="d-flex justify-content-evenly mb-2">
                            <a href="/blog/bai1.php" class="btn btn-sm btn-outline-dark shadow-none">Đọc Bài Viết</a>
                        </div>
                    </div>
                    <!--end phong-->

                </div>
            </div>
            <!-- 2 end cac phong theo ô xuông xuất hiện ở trang chủ-->
            <!-- end bai viet 1-->






        </div>
    </div>

    <?php require "./inc/footer.php" ?>
</body>

</html>