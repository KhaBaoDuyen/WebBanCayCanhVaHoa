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
use App\Models\Sendmail;
use App\Views\Client\Pages\Auth\Resetpassword;

class AuthController
{
   public static function Account()
   {
      /*       Notification::render();
      NotificationHelper::unset(); */
      Account::render();
   }

   // thuc hien  ForgotPassword giao dien 
   public static function ForgotPassword()
   {
     /*  Notification::render();
      NotificationHelper::unset(); */
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
         header('location: /Account');  // Đăng nhập thất bại, chuyển hướng về trang đăng nhập
      }
      var_dump($result);
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
         exit;
      }

      $data = [
         'username' => $_POST['username'],
         'email' => $_POST['email'],
         'phone' => $_POST['phone']
      ];


      $is_upload = AuthValidation::avatar();
      if ($is_upload) {
         $data['avatar'] = $is_upload;
      }

      $result = AuthHelper::update($id, $data);


      header("location: /user/$id");
   }

   // Hiển thị form reset mật khẩu
   public static function Resetpassword()
   {
      Resetpassword::render(); // Giả sử bạn có một view cho form reset mật khẩu
   }

   public static function forgotPasswordAction()
   {
      // Kiểm tra xem email có được nhập hay không
      if (isset($_POST['email'])) {
         $email = $_POST['email'];

         // Tạo đối tượng UserModel để xử lý
         // nếu mail đc nhập thì thực hiện hàm tạo mã otp
         $result = AuthHelper::duplicate_emails(['email' => $email]);

         // nếu tạo mã thành công thì gọi hàm tạo mail
         if ($result) {
            // Lấy OTP và thời gian hết hạn từ cơ sở dữ liệu
            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);  // Lấy thông tin người dùng từ DB
            if ($user && isset($user['otp'])) {
               $otp = $user['otp'];  // Lấy OTP từ kết quả
               // Gửi email cho người dùng
               $sendmail = $userModel->sendmail([
                  'email' => $email,
                  'otp' => $otp
               ]);
               if ($sendmail) {
                  header('Location: /Resetpassword');
               } else {
                  echo 'Gửi mail thất bại';
               }
            } else {
               NotificationHelper::error('no_email', 'Email không hợp lệ!');
               header('Location: /ForgotPassword');
               /* echo 'Không thể lấy OTP từ cơ sở dữ liệu'; */
            }
         } else {
            echo 'Tạo mã thất bại Controller';
         }
      } else {
         // Không cần thông báo lỗi ở đây, nếu cần có thể ghi log
         header('Location: /forgot-password'); // Quay lại trang quên mật khẩu
         echo 'không có email';
      }
   }

   public static function resetPasswordAction()
   {
      $user = new UserModel();

      // Kiểm tra xem OTP có được gửi qua POST và mật khẩu mới có được nhập không
      if (isset($_POST['otp'], $_POST['password']) && !empty($_POST['password'])) {
         $otp = $_POST['otp'];

         // Lấy thông tin người dùng từ OTP
         $userData = $user->getOneUserByOtp($otp);

         if ($userData) {
            // Kiểm tra thời gian hết hạn OTP nếu có
            if (strtotime($userData['otp_expiry']) < time()) {
               NotificationHelper::error('reset_password', 'Mã OTP đã hết hạn');
               header("Location: /Resetpassword");
               exit;
            }

            // Mã hóa mật khẩu mới
            $hash_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Chuẩn bị dữ liệu để cập nhật mật khẩu
            $updateData = [
               'otp' => $otp,
               'password' => $hash_password
            ];

            // Cập nhật mật khẩu trong cơ sở dữ liệu
            $result = $user->updatebyOtp($updateData);

            if ($result) {
               NotificationHelper::success('reset_password', 'Cập nhật mật khẩu thành công');
               header("Location: /");
               exit;
            } else {
               NotificationHelper::error('reset_password', 'Cập nhật mật khẩu thất bại');
               header("Location: /Resetpassword");
               exit;
            }
         } else {
            NotificationHelper::error('reset_password', 'Mã OTP không hợp lệ');
            header("Location: /Resetpassword");
            exit;
         }
      } else {
         NotificationHelper::error('reset_password', 'Vui lòng nhập OTP và mật khẩu mới');
         header("Location: /Resetpassword");
         exit;
      }
   }
}
