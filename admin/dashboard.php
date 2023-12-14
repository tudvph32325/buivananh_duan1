<?php

require "/buivananh_duan1/admin/inc/essential.php";
adminLogin();
// tao 1 id moi thay the id cu de bao mat 
// dang nhap thanh cong va thay doi id phien , thay doi id cu thanh moi
session_regenerate_id(true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - dashboard </title>
    <link rel="stylesheet" href="/admin/css/style.css">
    <?php
    require "/buivananh_duan1/admin/inc/link_admin.php";
    ?>
</head>

<body class="bg-light">
   <?php
   require "/buivananh_duan1/admin/inc/header.php";
   ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden" >
               <h1>Chào Mừng Ánh Admin</h1>
    </div>




    <?php
    require "/buivananh_duan1/admin/inc/scripts.php";
    ?>
</body>

</html>