<?php

namespace App\Views\Client\Pages\Auth;

use App\Views\BaseView;
use App\Models\UserModel;

class Profile extends BaseView
{
   public static function render($data = null)
   {
?>
      <main class="p-2 profile d-flex justify-content-center align-items-center ">
         <section class="sec_profile d-flex col-10">
            <aside class="sec_profile_left col-3 ">
               <div class="box_logo">
                  <div class="logo"><img src="/public/assets/Client/image/icon/Logo2.png" alt>
                  </div>
                  <h3 class="mt-3">BLOOM</h3>
               </div>

               <ul class="menu">
                  <li> <span class="material-symbols-outlined">
                        manage_accounts
                     </span><a href="/user">Trang cá
                        nhân</a> </li>

                  <li><span class="material-symbols-outlined">
                        deployed_code_history
                     </span> <a href="/history">Đơn hàng của
                        tôi</a> </li>
                  <li><span class="material-symbols-outlined">
                        logout
                     </span> <a href="/logout">Đăng
                        xuất</a>
                  </li>

               </ul>
            </aside>

            <article class="sec_profile_right col-9 d-flex ">


               <div class="my_profile col-8 ">
                  <h4>Thông tin tài khoản</h4>
                  <form action="/user/<?= $data['id'] ?>" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="method" value="PUT" id="">
                     <div class="box_title">
                        <label for class="col-5">Tên đăng nhập:</label>
                        <input type="text" name="username" id="username" value="<?= $data['username'] ?>">
                     </div>

                     <div class="box_title">
                        <label class="col-5">Giới tính:</label> <br>
                        <div class="d-flex check_gender">
                           <span class="d-flex "> <input type="radio" name="gender" value="nam"><label for>
                                 Nam</label></span>
                           <span class="d-flex"> <input type="radio" name="gender" value="nu"> <label for>Nữ</label></span>
                           <span class="d-flex"> <input type="radio" name="gender" value="khac" checked> <label
                                 for>Khác</label></span>
                        </div>

                     </div>
                     <div class="box_title">
                        <label for class="col-5">Số điện thoại:</label>
                        <?php
                        if ($data['phone']):
                        ?>
                           <input type="text" name="phone" id="phone" value="<?= $data['phone'] ?>">
                        <?php
                        else:
                        ?>
                           <input type="text" name="phone" id="phone" value="Chưa có">
                        <?php
                        endif;
                        ?>
                     </div>

                     <div class="box_title">
                        <label for class="col-5">Email:</label>
                        <input type="text" name="email" id="email" value="<?= $data['email'] ?>">
                     </div>

                     <div class="box_title">
                        <label for class="col-5">Mật khẩu:</label>
                        <input type="password" id="password" name="password" value="<?= $data['password'] ?>">
                     </div>

                     <div class="box_title">
                        <label for class="col-5">Địa chỉ:</label>
                        <?php
                        if ($data['address']):
                        ?>
                           <input type="text" name="address" id="address" value="<?= $data['address'] ?>">
                        <?php
                        else:
                        ?>
                           <input type="text" name="address" id="address" value="Chưa có">
                        <?php
                        endif;
                        ?>
                        <div class="box_title">
                        <label for class="col-5">Avatar:</label>
                        <input type="file" name="avatar" id="avatar">
                     </div>
                     </div>

                     <div class="box_btn">
                        <button type="submit">Lưu thông tin</button>
                        <button type="reset">Reset</button>
                     </div>
                  </form>

               </div>
               <div class="box_profile col-4">

                  <?php
                  if ($data['avatar']):
                  ?>
                     <div class="avatar">
                        <img src="<?= APP_URL ?>/public/uploads/users/<?= $data['avatar'] ?>" alt>
                        <label for="file-upload">
                           <span class="material-symbols-outlined">
                              add_a_photo
                           </span>
                           <input id="file-upload" type="file" />
                        </label>
                     </div>
                  <?php
                  else:
                  ?>
                     <div class="avatar">
                        <img src="<?= APP_URL ?>/public/assets/Client/image/users/a9dd84dc03188b701f3da4d08172609f.jpg" alt>
                        <label for="file-upload">
                           <span class="material-symbols-outlined">
                              add_a_photo
                           </span>
                           <input id="file-upload" type="file" />
                        </label>
                     </div>
                  <?php
                  endif;
                  ?>

               </div>
            </article>
         </section>

      </main>

<?php }
} ?>