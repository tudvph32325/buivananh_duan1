  <?php
    //session_start(); // việc với phiên 
    require_once "/buivananh_duan1/admin/inc/essential.php";
    require_once "/buivananh_duan1/admin/inc/db_config.php";
    // chức năng đăng ký
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dangky'])) {
        // lấy dư liệu từ form và sử lí với hàm lọc
        $name = loc($_POST['name']);
        $email = loc($_POST['email']);
        $sdt = loc($_POST['sdt']);
        $diachi = loc($_POST['diachi']);
        $cmnd = loc($_POST['cmnd']);
        $pass = loc($_POST['pass']);
        $confirm_pass = loc($_POST['confirm_pass']);

        // check các trường 
        // check sdt phải là số  // is_numeric kiểm tra xem chuỗi đó có phải là số hay ko 
        // nếu khác is_numeric thì báo lỗi
        if (!is_numeric($sdt)) {
            echo "<script>alert('SDT phải là số !!!'); window.location='index.php';</script>";
            return;
        }

        // check cmnd phải là số //is_numeric kiểm tra xem chuỗi đó có phải là số hay ko 
        // nếu khác is_numeric thì báo lỗi
        if (!is_numeric($cmnd)) {
            echo "<script>alert('CMND phải là số !!!'); window.location='index.php';</script>";
            return;
        }

        // Kiểm tra mật khẩu xác nhận
        if ($pass !== $confirm_pass) {
            echo "<script>alert('Mật khẩu không khớp !!!'); window.location='index.php';</script>";
            return;
        }

        // mã hóa pass
        $pass_mahoa = password_hash($pass, PASSWORD_DEFAULT);

        // kiểm tra xem email có tồn tại chưa
        $checkEmailQuery = "SELECT email FROM nguoi_dung WHERE email = ?";
        $stmt = mysqli_prepare($conn, $checkEmailQuery);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        // nếu trong các cột khi truy vấn ở bảng nguoi_dung đã có email rồi báo lỗi 
        if (mysqli_stmt_num_rows($stmt) > 0) {
            // lớn hơn 0 echo ra lỗi
            echo "<script>alert('Email đã tồn tại !!!'); window.location='index.php';</script>";
            return;
        }
        // thêm ng dung vao csdl 
        //$insertQuery = "INSERT INTO nguoi_dung (name, email, sdt, diachi, cmnd, pass) VALUES (?, ?, ?, ?, ?, ?)";

        $insertQuery = "INSERT INTO `nguoi_dung`(`name`, `email`, `sdt`, `diachi`, `cmnd`, `pass`) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "ssssis", $name, $email, $sdt, $diachi, $cmnd, $pass_mahoa);

        // thực thi câu lệnh dc chuẩn bị tr đó với mysqli_stmt_execute và check kiểm tra 
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Đăng ký thành công'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Đăng ký Thất Bại !!!'); window.location='index.php';</script>";
        }
    }

    // chuc năng đăng nhập
    // chuc nang dang nhap
    // xu lí chức năng đăng nhập
    // kiểm tra 
    if (isset($_POST['dangnhap'])) {
        // lấy thông tin đăng nhập 
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        // kiểm tra trong csdl bằng email xem đã có tk đó chưa 
        $stmt = $conn->prepare("SELECT id, name, pass FROM nguoi_dung WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        // check điều kiện 
        if ($row = $result->fetch_assoc()) {
            // kiểm tra mật khẩu 
            if (password_verify($pass, $row['pass'])) {
                // lưu thông tin vào $_SESSION
                // lưu biên đăng nhâp băng user_id user_name = id va name user_id se dùng cho xuất thông tin ngươi dùng sau này
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];
                //$_SESSION['user_name'] = $row['name'];
                //echo "<script>alert('Đăng Nhập Thành Công .'); window.location='index.php';</script>";
                header("Location: index.php");
            } else {
                echo "<script>alert('Mật khẩu không đúng !!!'); window.location='index.php';</script>";
            }
        } else {
            echo "<script>alert('Email không đúng !!!'); window.location='index.php';</script>";
        }
    }
    //
    $isLoggedIn = isset($_SESSION['user_id']); // Kiểm tra xem có session user_id không
    // end chuc nang dang nhap

    // check xem người dùng đã đăng nhập hay chưa mới được book phòng 
    // kiểm tra xem đã băt đầu làm việc với phiên hay chưa 
    if (session_status() === PHP_SESSION_NONE) {
        // khởi đông lại session_start():
        session_start();
    }
    // kiểm tra trạng thái đăng nhập ơ trên đã kiểm tra rồi
    // $isLoggedIn 

    ?>
  <!-- menu-->
  <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm -stickky-top">
      <div class="container-fluid">
          <a class="navbar-brand me-5 fw-bold fs-3 h-font " href="index.php">AYBITI</a>
          <button class="navbar-toggler shodow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                      <a class="nav-link active me-2" aria-current="page" href="index.php"><i class="bi bi-house-door-fill"></i>Trang chủ</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link me-2" href="/phong.php"><i class="bi bi-hospital-fill"></i>Phòng</a>
                  </li>
                  <!-- <li class="nav-item">
                      <a class="nav-link me-2" href="/giaodien.php"><i class="bi bi-hospital-fill"></i>test</a>
                  </li> -->
                  <li class="nav-item">
                      <a class="nav-link me-2" href="/trang_coso.php"><i class="bi bi-bank"></i>Cơ sở Khách sạn</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link me-2" href="/blog.php"><i class="bi bi-journal-text"></i>Bài Viết</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link me-2" href="/lienhe.php"><i class="bi bi-headset"></i>Liên Hệ </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link me-2" href="/gioithieu.php"><i class="bi bi-exclamation-circle-fill"></i>Giới Thiệu</a>
                  </li>

              </ul>

              <!-- hiển thị các nút này theo trạng thái đăng nhập -->
              <!-- đăng nhập đănng ký xem thông tin-->

              <div class="d-flex">
                  <!--   dangnhapModal    dangkyModel hiện đăng ký và đăng nhâp    -->

                  <?php if (!isset($_SESSION['user_id'])) : ?>
                      <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#dangnhapModal">
                          <i class="bi bi-person-circle"></i>Đăng Nhập
                      </button>

                      <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#dangkyModal">
                          <i class="bi bi-person-lines-fill"></i>Đăng Ký
                      </button>

                  <?php else : ?>
                      <button type="button" class="btn btn-outline-dark shadow-none">
                          <a href="thongtin_user.php"> <i class="bi bi-person-circle"></i>Vào Trang Tài Khoản </a>
                      </button>
                  <?php endif; ?>
              </div>
              <!-- end đăng nhập đănng ký xem thông tin-->
          </div>
      </div>
  </nav>
  <!-- end menu-->

  <!-- modal hiện đăng nhập -->
  <div class="modal fade" id="dangnhapModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <!-- Form đăng ký đăng nhập tài khoản  -->
              <form method="POST">
                  <div class="modal-header">
                      <h5 class="modal-title ">
                          <i class="bi bi-person-circle fs-3 me-2 "></i> Đăng nhập Tài Khoản
                      </h5>
                      <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="mb-3">
                          <label class="form-label">Nhập Emaii : </label>
                          <input type="email" name="email" class="form-control shdow-none" required>
                      </div>
                      <div class="mb-3">

                          <label class="form-label">Nhập Mật Khẩu : </label>
                          <input type="password" name="pass" class="form-control shdow-none" required>

                      </div>
                      <div class="d-flex align-items-center justify-content-between">

                          <button type="submit" name="dangnhap" class="btn btn-dark shodow-none">Đăng Nhập</button>

                          <a href="/quenmk.php" class="text-secondary text-deconration-none">Lấy Lại mật khẩu ? </a>
                      </div>
                  </div>
              </form>
              <!-- end Form đăng ký đăng nhập tài khoản  -->
          </div>
      </div>
  </div>
  <!-- end modal hiện đăng nhập -->

  <!-- modal hiện đăng ký -->
  <div class="modal fade" id="dangkyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <!-- Form đăng ký đăng nhập tài khoản  -->
              <form method="POST">
                  <div class="modal-header">
                      <h5 class="modal-title ">
                          <i class="bi bi-person-circle fs-3 me-2 "></i> Đăng ký Tài Khoản
                      </h5>
                      <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <span class="badge rounded-pill bg-light text-dark mb-3 texr-wrap lh-base">Lưu ý :Thông tin phải đúng với(Thấy tờ tùy nhân ,liên hệ chính chủ v.v) Để có thể xác nhận danh tính khi nhận phòng trân trọng</span>
                      <div class="container-fluid">

                          <div class="row">

                              <div class="col-md-6 ps-0 mb-3">
                                  <label class="form-label">Tên : </label>
                                  <input type="text" name="name" class="form-control shdow-none" required>
                              </div>

                              <div class="col-md-6 ps-0 mb-3">
                                  <label class="form-label">Email : </label>
                                  <input type="email" name="email" class="form-control shdow-none" required>
                              </div>

                              <div class="col-md-6 ps-0 mb-3">
                                  <label class="form-label">Số Điện Thoại: </label>
                                  <input style="width: 755px;" type="number" name="sdt" class="form-control shdow-none" required>
                              </div>


                              <div class="col-md-12 ps-0">
                                  <label class="form-label">Địa chỉ <span class="badge rounded-pill bg-light text-dark mb-3 texr-wrap lh-base">Lưu ý : Địa chỉ phải có Số nhà , phường , huyện , tỉnh , thành phố !</span></label>
                                  <textarea name="diachi" class="form-control shadow-none" rows="4" required></textarea>
                              </div>

                              <div class="col-md-6 ps-0 mb-3">
                                  <label class="form-label">Căn Cước Công Dân</label>
                                  <input name="cmnd" type="number" class="form-control shdow-none" required>
                              </div>

                              <div class="col-md-6 ps-0 mb-3">
                                  <label class="form-label">HELOO bạn</label>
                                  <label class="form-label">HELOO bạn</label>
                                  <!-- <input class="form-control shdow-none" > -->
                              </div>

                              <div class="col-md-6 ps-0 mb-3">
                                  <label class="form-label">Mật Khẩu: </label>
                                  <input name="pass" type="password" class="form-control shdow-none" required>
                              </div>

                              <div class="col-md-6 ps-0 mb-3">
                                  <label class="form-label">Xác Nhận Mật Khẩu: </label>
                                  <input name="confirm_pass" type="password" class="form-control shdow-none" required>
                              </div>

                          </div>
                      </div>
                      <div class="text-center my-1">
                          <button type="submit" name="dangky" class="btn btn-dark shadow-none"> Đăng Ký</button>
                      </div>
                  </div>
              </form>
              <!-- end Form đăng ký đăng nhập tài khoản  -->
          </div>
      </div>
  </div>

  <!-- end modal hiện đăng ký -->