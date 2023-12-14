<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ</title>
    <?php require "./inc/link.php" ?>
</head>
<body class="gb-light">
    <?php require "./inc/header.php" ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Liên hệ với chúng tôi</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Repellat, atque rerum deleniti rem odit animi accusantium.
        </p>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 ">
                    <div class="col-lg-8 col-md-8 p-4 mg-lg-0 mb-3 bg-white rounded">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29790.497151170155!2d105.72194384933717!3d21.040201309136805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134548cc813331b%3A0x9c7e53e5b23f1a5c!2zWHXDom4gUGjGsMahbmcsIE5hbSBU4burIExpw6ptLCBIw6AgTuG7mWksIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1701271163328!5m2!1svi!2s" width="500" height="400"></iframe>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 ">
                    <form method="POST" >
                        <h5>Mọi Thắc mắc xin liên hệ với chúng tôi </h5>

                        <div class="mb-3">
                            <label class="form-label">Tên : </label>
                            <input name="name" required type="text" class="form-control shadow-none">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email : </label>
                            <input name="email" required type="email" class="form-control shadow-none">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject :  </label>
                            <input name="subject" required type="text" class="form-control shadow-none">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lời nhắn : </label>
                            <textarea name="message" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
                        </div>
                        <button  type="submit" name="gui" class="btn btn-dark custum-gb shadow-none">Gửi</button>
                    </form>
                </div>
            </div>


        </div>
    </div>

    <?php 
    // kiểm tra xem người dùng đã ấn send chưa 
    if(isset($_POST['gui'])){
        // hàm loc dữ liệu từ form loc(); ở db_config.php
        $loc_data = loc($_POST);
        // chèn dữ liệu và csdl với INTERT 
        $q = "INSERT INTO `user_lienhe`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
        // gắn giá tri của trường name , email , subject , message từ mảng lọc vào biến khởi tạo là $values sau đó thực hiện thêm giá trị vào csdl xampp
        $values = [$loc_data['name'],$loc_data['email'],$loc_data['subject'],$loc_data['message']];

        //
        $result = insert($q , $values,'ssss');
        if($result == 1){
            // gui thanh cong them vao csdl in thông báo cho người dùng , thành công
            alert('success',' Đã Gủi Đi Hãy Chờ Phản Hồi ở Email của bạn !!!');
        }else{
            // xuat loi neu ko gui dc
            alert('error','Không Gửi đi được Sever đang lỗi !!!');
        }
        
    }
    ?>

    <?php require "./inc/footer.php" ?>
</body>
</html>