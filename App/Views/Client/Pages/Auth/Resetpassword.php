<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;

class Resetpassword extends BaseView
{
   public static function render($data = null)
   {
      ?>
 <!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <img src="" alt="">
   <title>BLOOM</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="/public/assets/Client/scss/Client/index.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
   <link rel="icon" type="image/png" href="/public/assets/Client/image/icon/Logo2.png">
</head>

<body>
    <div class="Page-login">
        <div class="container">
            <div class="form-container sign-up">
                <form>
                    <h1>Tạo tài khoản</h1>
                    <input type="text" placeholder="Tên">
                    <input type="text" placeholder="Email">
                    <input type="password" placeholder="Password">
                    <button class="button">Đăng ký</button>
                    <!-- <div class="social-icons">
                    <a href="#" class="icon"><i class='bx bxl-google-plus' style='color:#0f8809'  ></i></a>
                    <a href="#" class="icon"><i class='bx bxl-facebook-circle' style='color:#0f8809'  ></i></a>
                </div> -->
                </form>
            </div>
            <div class="form-container sign-in">
                <form>
                    <h1>Mật khẩu mới</h1>
                    <input type="password" placeholder="Mật khẩu mới">
                    <input type="password" placeholder="Nhập lại mật khẩu mới">
                    <div class="checkbox">
                        <div class="input-checkbox">
                            <input type="checkbox" name id>
                            <label>Ghi nhớ mật khẩu</label>
                        </div>
                        <a href="/Account">Quay về</a>
                    </div>
                    <button class="button">Gửi yêu cầu</button>
                </form>
            </div>
            <div class="toggle-container">
                <div class="toggle">
                </div>
            </div>
        </div>
    </div>

      <?php
   }
}
?>