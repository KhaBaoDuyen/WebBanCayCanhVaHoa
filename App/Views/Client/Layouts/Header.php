<?php

namespace App\Views\Client\Layouts;

use App\Controllers\Client\AuthController;
use App\Views\BaseView;
use App\Models\UserModel;

class Header extends BaseView
{
   public static function render($data = null)
   {
      // Kiểm tra nếu người dùng đã đăng nhập
      $isLoggedIn = isset($_SESSION['user']); // Kiểm tra tồn tại session 'user'
      $userName = $isLoggedIn ? $_SESSION['user']['username'] : null;
      ?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>BLOOM</title>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
         <link rel="stylesheet" href="/public/assets/Client/scss/Client/index.css">
         <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
         <link rel="icon" type="image/png" href="/public/assets/Client/image/icon/Logo2.png">
      </head>

      <body>
         <header class="banner">
            <div class="box_top_bottom">
               <div class="banner_top border-1 d-flex justify-content-center">
                  <img src="/public/assets/Client/image/main/header.jpg" alt="" width="80%" height="100%">
               </div>

               <div class="banner_bottom">
                  <div class="menu d-flex align-items-center col-10 m-auto">
                     <div class="d-flex align-items-center box col-6">
                        <div class="logo">
                           <img src="/public/assets/Client/image/icon/Logo.png" width="100%" alt="logo">
                        </div>

                        <form class="search" action="/Search" method="get">
                           <div class="InputContainer">
                              <input placeholder="Search" id="input" class="input" name="keyword" type="keyword" />
                              <button type="submit" class="submit-button labelforsearch">
                                 <svg class="searchIcon" viewBox="0 0 512 512">
                                    <path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path>
                                 </svg>
                              </button>
                           </div>

                        </form>
                     </div>

                     <div class="d-flex align-items-center box col-6 justify-content-end">
                        <div class="account">
                           <?php if ($isLoggedIn): ?>
                              <!-- Hiển thị tên người dùng nếu đã đăng nhập -->
                              <a href="/user/<?=$_SESSION['user']['id']?>" class="d-flex account_title justify-content-center align-items-center">
                                 <p><?php echo htmlspecialchars($userName); ?></p>
                                 <img class="img-profile rounded-circle" src="/public/uploads/users/<?=$_SESSION['user']['avatar']?>" style="max-width: 40px">
                                 <!-- <span class="material-symbols-outlined"> account_circle </span> -->
                              </a>
                           <?php else: ?>
                              <!-- Hiển thị nút Đăng nhập / Đăng ký nếu chưa đăng nhập -->
                              <a href="/Account" class="d-flex account_title justify-content-center align-items-center">
                                 <p>Đăng nhập / Đăng ký</p>
                                 <span class="material-symbols-outlined"> account_circle </span>
                              </a>
                           <?php endif; ?>
                        </div>
                        <a href="/cart" class="cart_shopping col-2" title="Giỏ hàng">
                           <span class="material-symbols-outlined">shopping_cart</span>
                           <span class="cart_quantity">3</span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>

            <div class="banner_menu_main d-flex align-items-center">
               <ul class="d-flex col-10">
                  <li><a href="/">Trang chủ</a></li>
                  <li><a href="/about">Giới thiệu </a></li>
                  <li><a href="/shop">Sản phẩm</a></li>
                  <li><a href="/blog">Kỹ thuật</a></li>
                  <li><a href="/contact">Liên hệ </a></li>
               </ul>
            </div>
         </header>

   <?php
   }
}
   ?>
