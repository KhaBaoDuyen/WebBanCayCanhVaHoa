<?php
namespace App\Validation;

use App\Helpers\NotificationHelper;

class UserValidation
{
//     public static function create(): bool {
//         $is_valid = true;
//   $errors = [];

//         // TÊN ĐĂNG NHẬP
//          if (empty($_POST["username"])) {
//          $errors['username'] = "Tên đăng nhập không được để trống.";
//          $is_valid = false;
//       } else {
//          $username = $_POST["username"];
//          if (strlen($username) < 5) {
//             $errors['username'] = "Tên  đăng nhập phải có ít nhất 5 ký tự.";
//             $is_valid = false;
//          }
//       }

//           if (!isset($_POST['email']) || $_POST['status'] === '') {
//          $errors['status'] = 'Không được để trống trạng thái';
//          $is_valid = false;
//       }

//         // EMAIL
//         if (!isset($_POST['email']) || $_POST['email'] === '') {
//              $errors['email'] = 'Không được để trống email';
//          $is_valid = false;
//         } else {
//             $emailPattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/";
//             if (!preg_match($emailPattern, $_POST['email'])) {
//                 NotificationHelper::error('email', 'Email không hợp lệ !!!');
//                 $is_valid = false;
//             }
//         }

//         // // MẬT KHẨU
//         // if (!isset($_POST['password']) || $_POST['password'] === '') {
//         //     NotificationHelper::error('password', 'Mật khẩu không được để trống !!!');
//         //     $is_valid = false;
//         // } else {
//         //     // KIỂM TRA ĐỘ DÀI
//         //     if (strlen($_POST['password']) < 3) {
//         //         NotificationHelper::error('password', 'Mật khẩu phải có ít nhất 3 ký tự !!!');
//         //         $is_valid = false;
//         //     }
//         // }

//         // // NHẬP LẠI MẬT KHẨU
//         // if (!isset($_POST['re_password']) || $_POST['re_password'] === '') {
//         //     NotificationHelper::error('re_password', 'Không được để trống nhập lại mật khẩu');
//         //     $is_valid = false;
//         // } else {
//         //     if ($_POST['password'] != $_POST['re_password']) {
//         //         NotificationHelper::error('re_password', 'Mật khẩu và nhập lại mật khẩu phải giống nhau');
//         //         $is_valid = false;
//         //     }
//         // }

//         // Trả về kết quả kiểm tra
//         return $is_valid;
//     }
public static function avatar()
{
    if (!isset($_FILES['avatar']) || !file_exists($_FILES['avatar']['tmp_name']) || !is_uploaded_file($_FILES['avatar']['tmp_name'])) {
        return false;
    }
    $target_dir = 'public/uploads/users/';
    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
    $avatarFileType = strtolower(pathinfo(basename($_FILES['avatar']['name']), PATHINFO_EXTENSION));

    // Kiểm tra loại file
    $allowed_types = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
    if (!in_array($avatarFileType, $allowed_types)) {
        NotificationHelper::error('type_upload', 'Chỉ nhận file ảnh JPG, PNG, JPEG, GIF, WEBP');
        return false;
    }

    // Thay đổi tên ảnh
    $nameImage = date('YmdHmi') . '.' . $avatarFileType;
    $target_file = $target_dir . $nameImage;

    // Di chuyển file
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
        NotificationHelper::error('move_uploaded', 'Không thể tải file vào thư mục đã lưu trữ ');
        return false;
    }

    return $nameImage;
}

public static function update($id): bool {
    $is_valid = true;
    $errors = [];

    // TÊN ĐĂNG NHẬP
    if (empty($_POST["username"])) {
        $errors['username'] = "Tên đăng nhập không được để trống.";
        $is_valid = false;
    } else {
        $username = $_POST["username"];
        if (strlen($username) < 5) {
            $errors['username'] = "Tên đăng nhập phải có ít nhất 5 ký tự.";
            $is_valid = false;
        }
    }

    // EMAIL
    if (empty($_POST['email'])) {
        $errors['email'] = 'Không được để trống email';
        $is_valid = false;
    } else {
        $emailPattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,}$/";
        if (!preg_match($emailPattern, $_POST['email'])) {
            $errors['email'] = 'Định dạng email không hợp lệ';
            $is_valid = false;
        }
    }

    // Trả về kết quả
    if (!$is_valid) {
        $_SESSION['errors'] = $errors;
    }

    return $is_valid;
}


}

?>