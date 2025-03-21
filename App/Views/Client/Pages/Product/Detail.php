<?php

namespace App\Views\Client\Pages\Product;

use App\Helpers\AuthHelper;
use App\Models\ImageProductModel;
use App\Views\BaseView;

class Detail extends BaseView
{
   public static function render($data = null)
   {
      $is_login = AuthHelper::checkLogin();
      // var_dump($_SESSION);

?>

      <main class="product_detail col-10 m-auto">

         <section class="sec_title d-flex">
            <aside class="d-flex justify-content-between align-content-center col-6">
               <div class="click_slide col-2 m-1">
                  <div class="box_image">
                     <img src="/public/uploads/products/<?= $data['product']['image'] ?>"
                        alt="<?= $data['product']['image'] ?>" width="100%" onclick="changeImage(this)">
                  </div>
                  <?php
                  if (isset($data['images']) && !empty($data['images'])) {
                     if (is_string($data['images'])) {
                        $images = json_decode($data['images'], true);
                        if (!is_array($images)) {
                           $images = [];
                        }
                     } else {
                        $images = is_array($data['images']) ? $data['images'] : [];
                     }
                     if (!empty($images)) {
                        foreach ($images as $key => $images) {
                  ?>
                           <div class="box_image">
                              <img src="/public/uploads/products/<?= htmlspecialchars($images) ?>" alt="Image [<?= $key ?>]"
                                 width="100%" onclick="changeImage(this)">
                           </div>
                  <?php
                        }
                     } else {
                        echo "<p>Dữ liệu ảnh không hợp lệ.</p>";
                     }
                  }
                  ?>

               </div>

               <div class="image col-10 m-1">
                  <img id="myImage" src="<?= APP_URL ?>/public/uploads/products/<?= $data['product']['image'] ?>"
                     alt="Ảnh sản phẩm">
                  <div id="magnifier"></div>
               </div>
            </aside>
            <form method="POST" action="/cart/<?= $data['product']['id'] ?>" enctype="multipart/form-data" class="col-5">
               <article class="col-12 ms-5 ">
                  <h5 class="name_categogy" style='text-transform: uppercase; font-weight: 550;'>
                     <?= $data['product']['name_categogy'] ?>
                  </h5>
                  <h3 class="name_product"><?= $data['product']['name'] ?></h3>
                  <p class="describe " style="text-align: justify;"><?= $data['product']['short_description'] ?></p>

                  <?php if (isset($data['product']['discount_price']) && !empty($data['product']['discount_price'])) { ?>
                     <div class="price_product">
                        <h5 class="price_old" id="product-price" data-price="<?= $data['product']['discount_price'] ?>">
                           <?= number_format($data['product']['discount_price'], 0, ',', '.') ?> VND
                        </h5>
                        <h5 class="price_new">
                           <?= number_format($data['product']['price'], 0, ',', '.') ?> VND
                        </h5>
                     </div>
                  <?php } else { ?>
                     <div class="price_product">
                        <h5 class="price_old" id="product-price" data-price="<?= $data['product']['price'] ?>">
                           <?= number_format($data['product']['price'], 0, ',', '.') ?> VND
                        </h5>
                     </div>
                  <?php } ?>


                  <?php if (isset($data['Arr_variant']) && is_array($data['Arr_variant']) && !empty($data['Arr_variant'])) { ?>
                     <div class="variants d-flex flex-column mt-2">
                        <h6 class="variant_title col-2">Phân loại: </h6>
                        <div class="variant row">
                           <?php foreach ($data['Arr_variant'] as $key => $variant) { ?>
                              <?php
                              $price = htmlspecialchars($variant['priceVariant'] ?? '');
                              $name = htmlspecialchars($variant['nameVariant'] ?? '');
                              ?>
                              <label style="width: max-content;">
                                 <input class="selected_variant" id="selected-variant"
                                    type="radio" name="selected_variant" value="<?= $key ?>"
                                    data-price="<?= $price ?>" data-name="<?= $name ?>">
                                 <span> <?= $name ?> </span>
                              </label>
                           <?php } ?>
                        </div>
                     </div>

                  <?php } else { ?>

                  <?php } ?>

                  </div>

                  <div class="box_count d-flex mt-3">
                     <h6 class="box_count_title col-2">Số lượng: </h6>
                     <div class="box_count_btn d-flex">
                        <button type="button" onclick="decreaseQuantity()"
                           class="justify-content-center align-content-center">
                           <span class="material-symbols-outlined">remove</span>
                        </button>
                        <input type="number" name="product_quantity" id="product_quantity" value="1" min="1"
                           onchange="updatePrice()">

                        <button type="button" onclick="increaseQuantity()"
                           class="justify-content-center align-content-center">
                           <span class="material-symbols-outlined">add</span>
                        </button>
                     </div>
                  </div>


                  <div class="box_btn mt-3 d-flex justify-content-between" style="">
                     <input type="hidden" name="method" value="POST">
                     <button type="submit" class="cartBtn" style="width: max-content;">
                        Thêm giỏ hàng
                        <svg class="cart" fill="white" viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg">
                           <path
                              d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z">
                           </path>
                        </svg>
                     </button>

                     <!-- <form action="/cartBuy" method="POST" style="display: inline;">
                        <input type="hidden" name="product_id" value="">
                        <button type="submit" class="buyBtn">
                           Mua ngay
                           <div class="icon-1">
                              <svg xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58.56 116.18"
                                 style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                                 version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                 <defs></defs>
                                 <g id="Layer_x0020_1">
                                    <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                                    <path
                                       d="M51.68 79.32c-5.6,0.48 -18.01,6.61 -22.08,10.58 -0.8,0.78 -1.48,1.77 -2.33,2.43 0.46,-1.76 1.17,-3.5 1.71,-5.18 2.05,-6.36 0.6,-3.94 6.72,-6.92 4.39,-2.13 7.93,-4.39 11.48,-7.91 2.87,-2.84 6.6,-7.49 8.43,-10.95 -3.22,0.75 -8.91,3.73 -12.2,5.14 -3.4,1.56 -7.64,4.64 -10.05,7.42l1.92 -7.77c0.18,-0.6 12.35,-10.32 15.54,-15.33 3.24,-5.07 5.83,-12.73 7.72,-18.52 -3.83,2.95 -11.19,10.7 -14.1,14.29 -2.1,2.58 -4.06,5.29 -6.05,7.95 0.13,-1.52 1.01,-4.66 1.36,-6.17 2.16,-9.19 5.06,-41.4 -1.01,-48.38 0,3.22 -1.49,12.51 -2.05,15.9 -1.29,7.79 -4.08,25.67 -3.07,33.01l0.47 8.51c0.07,2.12 -0.24,6.17 -1.45,7.91 0,-8.9 -9.67,-35.19 -16.51,-40.2 0,5.82 4.29,23.1 6.2,27.9 1.71,4.29 4.8,10.38 7.54,14 1.93,2.55 2.5,2.41 -0.02,9.43l-3.29 11.08 -3.9 -12.16c-2.78,-6.77 -11.01,-23.67 -15.86,-26.92 0,11.78 8.37,33.86 19.11,40.13 -0.29,2.07 -3.42,10.31 -4.93,11.77 -1.78,-10.97 -7.2,-20.86 -13.98,-29.49l-7.03 -8.05c0.06,2.73 1.9,7.3 2.51,10.1 0.36,0.47 3.98,11.12 9.2,19.09 2.49,3.81 6.41,7.11 8.48,10.28 -1.04,3.19 -5.75,9.78 -8.03,12.98l1.81 0.91c2.75,-2.62 8.6,-12.41 9.74,-15.89 6.1,-3.14 7.06,-2.33 14.56,-7.45 5.18,-3.54 5.49,-4.51 8.86,-8.02 1.06,-1.1 4.21,-4.24 4.55,-5.5z"
                                       class="fil0"></path>
                                 </g>
                              </svg>
                           </div>
                        </button>
 
 </form> -->
                  </div>
           </form>

            </article>



         </section>

         <section class="sec_describes  row  justify-content-between">
            <div>
               <h4>CHI TIẾT SẢN PHẨM</h4>
               <div class="box_des d-flex">
                  <label class="col-2">Danh mục: </label>
                  <p><?= $data['product']['name_categogy'] ?></p>
               </div>

               <div class="box_des d-flex">
                  <label class="col-2">Danh mục:</label>
                  <p>BLOOM</p>
               </div>

               <div class="box_des d-flex">
                  <label class="col-2">Loại phân bón: </label>
                  <p>Hữu cơ</p>
               </div>

               <div class="box_des d-flex">
                  <label class="col-2">Xuất xứ: </label>
                  <p>Đà lạt</p>
               </div>

               <div class="box_des d-flex">
                  <label class="col-2">Gửi từ: </label>
                  <p>Cần Thơ</p>
               </div>
            </div>

            <div class="col-12 mt-3">
               <h4>MÔ TẢ SẢN PHẨM</h4>
               <p class="contents">
                  <?= $data['product']['description'] ?>

               <div class="content">
                  <h5> HƯỚNG DẪN XỬ LÝ KHI MỚI MUA VỀ :</h5>

                  Trước khi chuyển hàng, sen đã được ngừng tưới 3-4 ngày để
                  tránh tình trạng sốc nhiệt/ úng rễ khi gửi hàng xa. Vì thế
                  khi nhận hàng bạn cần lưu ý các bước xử lý sau: <br>

                  <b>1. </b>Đối với những vùng có khí hậu núi cao tương tự Đà
                  Lạt
                  như
                  Khu vực Tây Nguyên, Sơn La, Mộc Châu... Bạn có thể mang
                  trồng
                  và tưới nước luôn không cần xử lý gì cả. Chỉ khoảng 5-7
                  ngày
                  là cây sẽ phát rễ và lớn rất nhanh <br>

                  <b>2.</b> Đối với các vùng khí hậu nóng/ nhiệt đới: Sài
                  Gòn, các
                  tỉnh
                  Miền Tây, khu vực Nam - Trung bộ.... bạn cần làm theo các
                  bước
                  sau:
               </div>

               <div class="content">
                  <ul>
                     <li> - Bước 1: Rũ bỏ giá thể cũ (có thể lấy vòi nước
                        mạnh xịt
                        cho
                        bong giá thể). Tỉa các rễ nhỏ, cắt rễ lớn còn lại
                        khoảng
                        2cm
                        tính từ gốc</li>
                     <li>- Bước 2: Để chỗ mát tránh ánh nắng trực tiếp khoảng
                        3 ngày
                        cho vết cắt khô lại, tránh nhiễm trùng</li>
                     <li>- Bước 3: Chuẩn bị giá thể (ưu tiên các loại giá thể
                        chuyên
                        dụng), tưới lượng nước nhỏ đủ ẩm</li>
                     <li>- Bước 4: Đặt cây vào và phủ đất kín phần rễ
                        cây</li>
                     <li>- Bước 5: Đặt cây vào chỗ thoáng mát (không đặt
                        trong phòng
                        điều hòa), tránh ánh nắng trực tiếp, không được di
                        chuyển
                        chậu
                        hoặc lay gốc trong thời gian này</li>
                     <li> - Bước 6: Sau 2 tuần, khi thấy phần ngọn đã bắt đầu
                        có dấu
                        hiệu phát triển và lay nhẹ thấy phần gốc đã bám vào
                        giá
                        thể.
                        Bạn có thể từ từ cho cây ra nắng và bắt đầu tưới nước
                        bình
                        thường.</li>
                  </ul>

               </div>
               <div class="content">

                  <h5> BLOOM CAM KẾT:</h5>
                  <ul>
                     <li>- 100% Hình ảnh do đội ngũ Bloom tự sản xuất</li>
                     <li>- Sản phẩm định lượng, đúng kích thước, đúng màu
                        sắc</li>
                     <li>- Giao hàng trên Toàn Quốc</li>
                     <li>- Hàng có sẵn, giao ngay khi nhận đơn.</li>
                     <li>- Hỗ trợ đổi trả theo quy định của Shopee</li>
                  </ul>
                  <h5> VỀ BLOOM</h5>

                  Về Bloom:

                  Bloom là đại lý phân phối các sản phẩm giá thể, cây mini,
                  phân
                  thuốc liên quan đặc biệt phù hợp cho các khu vườn thành
                  phố,
                  vườn ban công... Mọi sản phẩm của Bloom đều được đảm bảo
                  đáp
                  ứng chất lượng theo chuẩn cao nhất của ngành hàng.
               </div>
               </p>
            </div>
         </section>

         <section class="sec_comment row  justify-content-between ">
            <?php
            if (isset($data) && isset($data['comments']) && $data && $data['comments']):
               foreach ($data['comments'] as $item):
            ?>
                  <div class="sec_comment_review  p-1 d-flex  ">
                     <div class="col-11">
                        <div class="user d-flex align-items-center">
                           <?php
                           if ($item['avatar']):
                           ?>
                              <img class="avatar_comment " src="<?= APP_URL ?>/public/uploads/users/<?= $item['avatar'] ?>"
                                 alt="Avatar của người dùng" width="5%">
                           <?php
                           else:
                           ?>
                              <img class="avatar_comment " src="<?= APP_URL ?>/public/uploads/users/usermacdinh.png"
                                 alt="Avatar của người dùng" width="5%">
                           <?php
                           endif;
                           ?>
                           <!-- avatar người dùng -->
                           <div class="d-flex ">
                              <h5 class="username"><?= $item['username'] ?></h5>
                              <span class="date"><?= $data['product']['date'] ?></span>
                           </div>
                        </div>

                        <p class="content mt-1"><?= $item['content'] ?></p>
                        <div class="collapse" id="<?= $item['username'] ?><?= $item['id'] ?>">
                           <div id="commentForm" class="col-12">
                              <form action="/comments/<?= $item['id'] ?>" method="post">
                                 <input type="hidden" name="method" value="PUT" id="">
                                 <input type="hidden" name="id_product" value="<?= $data['product']['id'] ?>" id="">
                                 <div class="form-group col-12 mt-2">
                                    <label for="">Bình luận</label>
                                    <textarea id="content" name="content" rows="4" placeholder="Nhập bình luận..."><?= $item['content'] ?></textarea>
                                 </div>

                                 <button class="send">
                                    <div class="svg-wrapper-1">
                                       <div class="svg-wrapper">
                                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                             <path fill="none" d="M0 0h24v24H0z"></path>
                                             <path fill="currentColor"
                                                d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z">
                                             </path>
                                          </svg>
                                       </div>
                                    </div>
                                    <span>Gửi</span>
                                 </button>
                              </form>

                           </div>
                        </div>
                     </div>
                     <div class="col-1 d-flex justify-content-end align-content-end Utilities">
                        <span class="material-symbols-outlined">
                           more_vert
                        </span>
                        <div class="formdown">

                           <?php
                           if (isset($data) && isset($is_login) && $is_login && ($_SESSION['user']['id'] == $item['id_user'])) :
                           ?>
                              <button type="button" class="btn btn-cyan btn-sm btn-warning" data-toggle="collapse" data-target="#<?= $item['username'] ?><?= $item['id'] ?>" aria-expanded="false" aria-controls="<?= $item['username'] ?><?= $item['id'] ?>">Sửa</button>
                              <form action="/comments/<?= $item['id'] ?>" method="post" onsubmit="return confirm('Xác nhận xóa?')" style="display: inline-block">
                                 <input type="hidden" name="method" value="DELETE" id="">
                                 <input type="hidden" name="id_product" value="<?= $data['product']['id'] ?>" id="">
                                 <button type="submit" class="btn btn-danger btn-sm">Xoá</button>

                              </form>
                           <?php
                           endif;
                           ?>
                        </div>
                     </div>
                  </div>
               <?php
               endforeach;
            else:
               ?>
               <h6 class="text-center text-danger">
                  Chưa có bình luận
               </h6>
            <?php
            endif;
            ?>
            <?php
            if (isset($data) && isset($is_login) && $is_login):
            ?>

               <form id="commentForm" action="/comments" method="post" class="col-12 mt-2">
                  <input name="method" value="POST" type="hidden">
                  <input type="hidden" name="id_product" value="<?= $data['product']['id'] ?>" id="" required>
                  <input type="hidden" name="id_user" value="<?= $_SESSION['user']['id'] ?>" id="" required>
                  <div class="user d-flex align-items-center">

                     <?php
                     if ($_SESSION['user']['avatar']):
                     ?>
                        <img class="avatar_comment " src="<?= APP_URL ?>/public/uploads/users/<?= $_SESSION['user']['avatar'] ?>"
                           alt="user" width="5%">
                     <?php
                     else:
                     ?>
                        <img class="avatar_comment " src="<?= APP_URL ?>/public/uploads/users/usermacdinh.png" alt="user"
                           width="5%">

                     <?php
                     endif;
                     ?>

                     <h5 class="username m-2"><?= $_SESSION['user']['username'] ?></h5>
                  </div>
                  <div>
                     <label for="comment">Bình luận của bạn:</label>
                     <textarea id="content" name="content" rows="4" required
                        placeholder="Viết bình luận của bạn ở đây..."></textarea>


                     <button class="send">
                        <div class="svg-wrapper-1">
                           <div class="svg-wrapper">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                 <path fill="none" d="M0 0h24v24H0z"></path>
                                 <path fill="currentColor"
                                    d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z">
                                 </path>
                              </svg>
                           </div>
                        </div>
                        <span>Gửi</span>
                     </button>
                  </div>

               </form>
            <?php
            else:
            ?>
               <h6 class="text-center text-danger">
                  Vui lòng đăng nhập để bình luận
               </h6>
            <?php
            endif;
            ?>

         </section>

      </main>
      <script>
         function changeImage(element) {
            const mainImage = document.getElementById("myImage");
            mainImage.src = element.src;
         }
      </script>


      <script>
         function changePrice(variantPrice, variantName) {
            const priceElement = document.getElementById('product-price');
            priceElement.setAttribute('data-price', variantPrice);
            priceElement.textContent = formatCurrency(variantPrice) + ' VND';

            const variantTitle = document.getElementById('selected-variant');
            if (variantTitle) {
               variantTitle.textContent = variantName;
            }

            updatePrice();
         }

         function updatePrice() {
            let variantPrice = parseFloat(document.getElementById('product-price').getAttribute('data-price'));
            if (isNaN(variantPrice)) {
               variantPrice = <?= $data['product']['price'] ?>;
            }

            const quantity = document.getElementById('product_quantity').value;
            const totalPrice = variantPrice * quantity;
            document.getElementById('product-price').textContent = formatCurrency(totalPrice) + " VND";
         }

         function formatCurrency(amount) {
            return amount.toLocaleString('vi-VN');
         }

         document.querySelectorAll('.selected_variant').forEach(input => {
            input.addEventListener('change', function() {
               const variantPrice = parseFloat(this.getAttribute('data-price'));
               const variantName = this.getAttribute('data-name');
               changePrice(variantPrice, variantName);
            });
         });


         function decreaseQuantity() {
            const quantityInput = document.getElementById("product_quantity");
            if (parseInt(quantityInput.value) > 1) {
               quantityInput.value = parseInt(quantityInput.value) - 1;
               updatePrice();
            }
         }

         function increaseQuantity() {
            const quantityInput = document.getElementById("product_quantity");
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updatePrice();
         }
      </script>



<?php

   }
}
?>