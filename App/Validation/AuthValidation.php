<?php
namespace App\Validation;

use App\Helpers\NotificationHelper;

class AuthValidation
{

   public static function register(): bool
   {
      $is_valid = true;
      $errors = [];

      if (empty($_POST['username'])) {
         $errors['username'] = "Tên người dùng không được để trống.";
         $is_valid = false;
      }

      if (empty($_POST['email'])) {
         $errors['email'] = "Địa chỉ email không được để trống.";
         $is_valid = false;
      } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
         $errors['email'] = "Địa chỉ email không hợp lệ.";
         $is_valid = false;
      }
      if (empty($_POST['password'])) {
         $errors['password'] = "Mật khẩu không được để trống.";
         $is_valid = false;
      } elseif (strlen($_POST['password']) < 6) {
         $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự.";
         $is_valid = false;
      }

      if (empty($_POST['confirm_password'])) {
         $errors['confirm_password'] = "Vui lòng xác nhận mật khẩu.";
         $is_valid = false;
      } elseif ($_POST['confirm_password'] !== $_POST['password']) {
         $errors['confirm_password'] = "Mật khẩu xác nhận không khớp.";
         $is_valid = false;
      }

      if (!$is_valid) {
         $_SESSION['errors'] = $errors;
      }

      return $is_valid;
   }


public static function login(): bool
{
    $is_valid = true;
    $errors = [];

    if (empty($_POST['username'])) {
        $errors['usernamelogin'] = "Tên đăng nhập không được để trống.";
        $is_valid = false;
    }

    if (empty($_POST['password'])) {
        $errors['passwordlogin'] = "Mật khẩu không được để trống.";
        $is_valid = false;
    }
    if (!$is_valid) {
        $_SESSION['errors'] = $errors;
    }

    return $is_valid;
}

public static function ForgotPassword(): bool
{
    $is_valid = true;
    $errors = [];

    if (empty($_POST['username'])) {
        $errors['username'] = "Tên đăng nhập không được để trống.";
        $is_valid = false;
    }

    if (empty($_POST['email'])) {
        $errors['email'] = "Email không được để trống.";
        $is_valid = false;
    } else {
        $emailPattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/";
        if (!preg_match($emailPattern, $_POST['email'])) {
            $errors['email'] = "Email không hợp lệ.";
            $is_valid = false;
        }
    }

    if (!$is_valid) {
        $_SESSION['errors'] = $errors;
    }

    return $is_valid;
}


   /* public static function ResetPassword(): bool
   {
      $is_valid = true;

      // MẬT KHẨU
      if (!isset($_POST['password']) || $_POST['password'] === '') {
         NotificationHelper::error('password', 'Mật khẩu không được để trống !!!');
         $is_valid = false;
      } else {
         //KIỂM TRA ĐỘ DÀI
         if (strlen($_POST['password']) < 3) {
            NotificationHelper::error('password', 'Mật khẩu phải có ít nhất 3 ký tự !!!');
            $is_valid = false;
         }
      }
      // Kiểm tra re_password
      if (!isset($_POST['re_password']) || $_POST['re_password'] === '') {
         NotificationHelper::error('re_password', 'Nhập lại mật khẩu không được để trống !!!');
         $is_valid = false;
      } else if ($_POST['password'] !== $_POST['re_password']) {
         NotificationHelper::error('re_password', 'Mật khẩu không khớp !!!');
         $is_valid = false;
      }
      return $is_valid;
   } */

   // ------------- UPDATE ----------------
   public static function update(): bool
   {
      $is_valid = true;
      // TÊN ĐĂNG NHẬP
      if (!isset($_POST['username']) || $_POST['username'] === '') {
         NotificationHelper::error('username', 'Tên đăng nhập không được để trống !!!');
         $is_valid = false;
      }
      /* // TÊN KHÁCH HÀNG
      if (!isset($_POST['password']) || $_POST['password'] === '') {
         NotificationHelper::error('password', 'Mật khẩu không được để trống !!!');
         $is_valid = false;
      } */
      //EMAIL
      if (!isset($_POST['email']) || $_POST['email'] === '') {
         NotificationHelper::error('email', 'Email không được để trống !!!');
         $is_valid = false;
      } else {
         $emailPattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/";
         if (!preg_match($emailPattern, $_POST['email'])) {
            NotificationHelper::error('email', 'Email không hợp lệ !!!');
            $is_valid = false;
         }
      }

      /* // PHONE 
           $phonePattern = "/^(0[1-9]\d{8,9})$/";
           if (!preg_match($phonePattern, $_POST['phone'])) {
              NotificationHelper::error('phone', 'số điện thoại bắt đầu bằng 0 , theo sau là 9  chữ số. !!!');
              $is_valid = false;
           } */

      return $is_valid;
   }
   //-----------UPDATE AVATAR---------------
   public static function avatar()
   {
      if (!file_exists($_FILES['avatar']['tmp_name']) || !is_uploaded_file($_FILES['avatar']['tmp_name'])) {
         return false;
      }

      $target_dir = 'public/uploads/users/';
      $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
      $imageFileType = strtolower(pathinfo(basename($_FILES['avatar']['name']), PATHINFO_EXTENSION));

      // Kiểm tra loại file
      $allowed_types = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
      if (!in_array($imageFileType, $allowed_types)) {
         NotificationHelper::error('type_upload', 'Chỉ nhận file ảnh JPG, PNG, JPEG, GIF, WEBP');
         return false;
      }

      // Thay đổi tên ảnh
      $nameImage = date('YmdHmi') . '.' . $imageFileType;
      $target_file = $target_dir . $nameImage;

      // Di chuyển file
      if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
         NotificationHelper::error('move_uploaded', 'Không thể tải file vào thư mục đã lưu trữ ');
         return false;
      }

      return $nameImage;
   }

   public static function ressetpassword(): bool
   {
      $is_valid = true;
      // TÊN ĐĂNG NHẬP
      if (!isset($_POST['otp']) || $_POST['otp'] === '') {
         NotificationHelper::error('otp', 'Mã otp không được để trống ');
         $is_valid = false;
      }
      // MẬT KHẨU
      if (!isset($_POST['password']) || $_POST['password'] === '') {
         NotificationHelper::error('password', 'Mật khẩu không được để trống ');
         $is_valid = false;
      }
      return $is_valid;
   }
}

?>