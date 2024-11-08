<?php

namespace App\Views\Admin\Pages\User;

use App\Views\BaseView;

class Index extends BaseView
{
    public static function render($data = null)
    {
?>
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Tài khoản</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                </ol>
            </div>
            <div class="row">
                <!-- DataTable with Hover -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
                        </div>
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Avatar</th>
                                        <th>Tên đăng nhập</th>
                                        <th>Số điện thoại</th>
                                        <th>Email</th>
                                        <th>Vai trò</th>
                                        <th>Khác</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (isset($data)): ?>
                                        <?php foreach ($data as $user): ?>
                                            <tr>
                                                <td><?= $user['id'] ?></td>
                                                <td>
                                                    <?php if ($user['avatar']): ?>
                                                        <img title="<?= $user['name'] ?>" style="border-radius: 50%;" class="img_all" width="50px" height="50px"
                                                            src="/public/uploads/users/<?= $user['avatar'] ?>" alt="img">
                                                    <?php else: ?>
                                                        <img title=" <?= $user['name'] ?>" style="border-radius: 50%;" class="img_all" width="50px" height="50px" src="/public/uploads/users/usermacdinh.png" alt="img">
                                                    <?php endif; ?>
                                                </td>
                                                <td><a title="<?= $user['name'] ?>" href="/admin/users/<?= $user['id'] ?>"><?= $user['username'] ?></a></td>
                                                <td><?= $user['phone'] ?></td>
                                                <td><?= $user['email'] ?></td>
                                                <td>
                                                    <span
                                                        class="badge p-2 <?= $user['role'] == 1 ? 'badge-success' : 'badge-danger' ?>">
                                                        <?= $user['role'] == 1 ? 'Người dùng' : 'Quản trị' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="/admin/users/<?= $user['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                                                    <form action="/admin/users/<?= $user['id'] ?>" method="post"
                                                        style="display: inline-block;"
                                                        onsubmit="return confirm('Bạn có chắc chắn xóa ngời dùng <?= $user['username'] ?>?')">
                                                        <input type="hidden" name="method" value="DELETE">
                                                        <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>

                                    <?php endif ?>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Logout -->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to logout?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                            <a href="login.html" class="btn btn-primary">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!---Container Fluid-->
        </div>
        <!-- Page level plugins -->

<?php
    }
}
