<?php

namespace App\Views\Admin\Pages\User;

use App\Views\BaseView;

class Edit extends BaseView
{
  public static function render($data = null)
  {
?>

    <div class="row">
      <div class="col-lg-10 m-auto">
        <div class="card mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Sửa thông tin người dùng</h6>
          </div>
          <div class="card-body">
            <?php
            // Lấy lỗi từ session
            $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
            ?>
            <form class="form-horizontal d-flex justify-content-between" action="/admin/users/<?= $data['id'] ?>"
              method="POST" enctype="multipart/form-data">
              <input type="hidden" name="method" id="" value="PUT">

              <div class="col-7 row">
                <div class="form-group col-12">
                  <label for="username">Tên đăng nhập</label>
                  <input type="text" class="form-control" id="username" name="username" aria-describedby=""
                    placeholder="Nhập tên đăng nhập" value="<?= isset($_POST['username']) ? $_POST['username'] : $data['username'] ?>">
                  <?php if (isset($errors['username'])): ?>
                    <span style="color:red;"><?= $errors['username'] ?></span>
                  <?php endif; ?>
                </div>


                <div class="form-group col-12">
                  <label for="name">Họ và tên</label>
                  <input type="text" class="form-control" id="name" placeholder="Nhập Họ và tên ..." name="name"
                    value="<?= $data['name'] ?>">
                </div>

                <div class="form-group col-12">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" id="email" name="email" aria-describedby=""
                    placeholder="Nhập địa chỉ email..." value="<?= isset($_POST['email']) ? $_POST['email'] : $data['email'] ?>">
                  <?php if (isset($errors['email'])): ?>
                    <span style="color:red;"><?= $errors['email'] ?></span>
                  <?php endif; ?>
                </div>


                <div class="form-group col-12">
                  <label for="name">Phone</label>
                  <input type="text" class="form-control" id="phone" aria-describedby="" name=phone
                    placeholder="Nhập số điện thoại ..." value="<?= $data['phone'] ?>">
                </div>

                <div class="form-group col-6">
                  <label for="name">Vai trò</label>
                  <select class="select2 form-control shadow-none" style="width: 100%; height:36px;" id="role" name="role">
                    <option value="1" <?= ($data['role'] == 1 ? 'selected' : '') ?>>Người dùng</option>
                    <option value="0" <?= ($data['role'] == 0 ? 'selected' : '') ?>>Người quản trị</option>
                  </select>
                </div>

                <div class="form-group col-6">
                  <label for="name">Trạng thái</label>
                  <select class="select2 form-control shadow-none" style="width: 100%; height:36px;" id="status" name="status">
                    <option value="1" <?= ($data['status'] == 1 ? 'selected' : '') ?>>Đang hoạt động</option>
                    <option value="0" <?= ($data['status'] == 0 ? 'selected' : '') ?>>Đã khóa</option>
                  </select>
                </div>


                <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
              </div>


              <div class="form-group col-4">
                <?php if ($data['avatar']): ?>
                  <img style="border-radius: 5%;" class="img_all m-auto" width="200px" height="200px"
                    src="/public/uploads/users/<?= $data['avatar'] ?>" alt="img">
                <?php else: ?>
                  <img style="border-radius: 5%;" class="img_all m-auto" width="200px" height="200px"
                    src="/public/uploads/users/usermacdinh.png" alt="img">
                <?php endif; ?>
                <div class="custom-file col-8 mt-3">
                  <input type="file" class="custom-file-input" id="customFile" name="avatar">
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>

            </form>

            <?php
            unset($_SESSION['errors']);
            ?>

          </div>
        </div>
      </div>


    </div>

<?php
  }
}
?>