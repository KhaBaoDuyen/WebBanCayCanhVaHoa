<?php

namespace App\Controllers\Client;

use App\Helpers\AuthHelper;
use App\Helpers\NotificationHelper;
use App\Views\Client\Components\Notification;
use App\Validation\AuthValidation;
use App\Views\Client\Pages\Auth\ForgotPassword;
use App\Views\Client\Pages\Auth\Account;
use App\Views\Client\Pages\Auth\Profile;
use App\Views\Client\Layouts\Header;
use App\Views\Client\Layouts\Footer;
use App\Models\UserModel;
use App\Views\Client\Pages\Auth\Resetpassword;

class AuthController
{
   public static function Account()
   {
      Account::render();
      
   }

   // thuc hien  ForgotPassword giao dien 
   public static function ForgotPassword()
   {
      ForgotPassword::render();
   }

   // ------------- LOGOUT ----------------
   public static function logout()
   {
      AuthHelper::logout();
      NotificationHelper::success('logout', 'Đăng xuất thành công');
      header('Location:/');
   }
   // ------------- PROFILE ----------------
   public static function profile()
   {
      Header::render();
      Profile::render();
   }

   public static function Resetpassword()
   {
      Resetpassword::render();
   }



   public static function registerAction()
   {
      // Xác thực dữ liệu đầu vào cho quá trình đăng ký
      $is_valid = AuthValidation::register();
      if (!$is_valid) {
         NotificationHelper::error('register_valid', 'Đăng ký thất bại');
         header('location: /Account');
         exit();
      }

      // Lấy dữ liệu từ form
      $username = $_POST['username'];
      $password = $_POST['password'];
      $hash_password = password_hash($password, PASSWORD_DEFAULT); // Băm mật khẩu
      $email = $_POST['email'];

      // Tạo một mảng dữ liệu chứa thông tin người dùng
      $data = [
         'username' => $username,
         'password' => $hash_password,
         'email' => $email
      ];

      // Gọi AuthHelper để đăng ký người dùng với dữ liệu đã chuẩn bị
      $result = AuthHelper::register($data);

      // Kiểm tra kết quả đăng ký
      if ($result) {
         header('Location: /Account'); // Đăng ký thành công, chuyển hướng về trang tài khoản
      } else {
         header('Location: /Account'); // Đăng ký thất bại, cũng chuyển hướng về trang tài khoản
      }
   }


   public static function loginAction()
   {
      // Xác thực dữ liệu đầu vào cho quá trình đăng nhập
      $is_valid = AuthValidation::login();
      if (!$is_valid) {
         NotificationHelper::error('register_valid', 'Đăng nhập thất bại');
         header('location: /Account');
         exit();
      }

      // Tạo mảng dữ liệu chứa thông tin đăng nhập
      $data = [
         'username' => $_POST['username'],
         'password' => $_POST['password'],
         'remember' => isset($_POST['remember']) // Kiểm tra xem người dùng có chọn 'Ghi nhớ đăng nhập' không
      ];

      // Gọi AuthHelper để thực hiện đăng nhập
      $result = AuthHelper::login($data);

      // Kiểm tra kết quả đăng nhập
      if ($result) {
         NotificationHelper::success('login', 'Đăng nhập thành công');
         header('location: /'); // Đăng nhập thành công, chuyển hướng về trang chủ
      } else {
         NotificationHelper::error('error_login', 'Đăng nhập thất bại');
         header('location: /Account'); // Đăng nhập thất bại, chuyển hướng về trang đăng nhập
      }
   }

   public static function edit($id)
    {
        $result = AuthHelper::edit($id);
        if (!$result) {
            if (isset($_SESSION['error']['login'])) {
                header('location: /Account');
                exit;
            }

            if (isset($_SESSION['error']['user_id'])) {
                $data = $_SESSION['user'];
                $user_id = $data['id'];
                header("location: /user/$user_id");
                exit;
            }
        }
        $data = $_SESSION['user'];
        /* var_dump($data); */
        Header::render();
        Profile::render($data);
        Footer::render();

    }

    public static function update($id)
    {
        $is_valid = AuthValidation::update();
        if (!$is_valid) {
            NotificationHelper::error('update_user', 'Cập nhật thông tin tài khoản thất bại');
            header("location: /user/$id");
            /* var_dump($is_valid); */
            exit;
        }

        $data = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'password' => $_POST['password']
        ];

        var_dump($data);

        $is_upload = AuthValidation::avatar();
        if ($is_upload) {
            $data['avatar'] = $is_upload;
        }

        $result = AuthHelper::update($id,$data);
        header("location: /user/$id");
    }

}
