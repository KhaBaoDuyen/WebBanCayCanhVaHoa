<?php

namespace App\Models;

use App\Helpers\NotificationHelper;

class CommentModel extends BaseModel
{
   protected $table = 'comments';
   protected $id = 'id_comments';

   public function getAllComment()
   {
      return $this->getAll();
   }

   public function getOneComment($id)
   {
      return $this->getOne($id);
   }

   public function createComment($data)
   {
      return $this->create($data);
   }

   public function updateComment($id, $data)
   {
      return $this->update($id, $data);
   }

   public function deleteComment($id)
   {
      return $this->delete($id);
   }

   public function get5CommentNewestByProductAndStatus($id)
   {
      $sql = "SELECT comments.*, user.username, user.name, user.avatar 
                FROM comments INNER JOIN user ON comments.user_id=user.user_id 
                WHERE comments.product_id=? AND comments.status=" . self::STATUS_ENABLE .
         " ORDER BY date DESC LIMIT 5";

      $conn = $this->_conn->MySQLi();
      $stmt = $conn->prepare($sql);

      $stmt->bind_param('i', $id);
      $stmt->execute();
      return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   }


   public function getAllProductJoinCategory()
   {
      $result = [];
      try {
         $sql = "SELECT products.*, categories.name AS category_name 
                FROM products INNER JOIN categories ON products.category_id = categories.id";
         $result = $this->_conn->MySQLi()->query($sql);
         return $result->fetch_all(MYSQLI_ASSOC);
      } catch (\Throwable $th) {
         error_log('Lỗi khi hiển thị tất cả dữ liệu: ' . $th->getMessage());
         NotificationHelper::error('getAllProductJoinCategory', 'Lỗi khi hiển thị tất cả dữ liệu');
         return $result;
      }
   }

   public function getAllCommentJoinProductAndUser()
   {
      $result = [];
      try {
         $sql = "SELECT comments.*, product.name AS product_name, user.username FROM comments 
        INNER JOIN product ON comments.product_id=product.product_id 
        INNER JOIN user ON comments.user_id=user.user_id";
         $result = $this->_conn->MySQLi()->query($sql);
         return $result->fetch_all(MYSQLI_ASSOC);
      } catch (\Throwable $th) {
         error_log('Lỗi khi hiển thị tất cả dữ liệu: ' . $th->getMessage());
         NotificationHelper::error('getAllCommentJoinProductAndUser', 'Lỗi khi hiển thị tất cả dữ liệu');
         return $result;
      }

   }
   public function getOneCommentJoinProductAndUser(int $id)
   {
      $result = [];
      try {
       $sql = "SELECT comments.*, product.name AS product_name, user.username FROM comments 
        INNER JOIN product ON comments.product_id=product.product_id 
        INNER JOIN user ON comments.user_id=user.user_id
         WHERE comments.id_comments=? ";
         $conn = $this->_conn->MySQLi();
         $stmt = $conn->prepare($sql);

         $stmt->bind_param('i', $id);
         $stmt->execute();
         return $stmt->get_result()->fetch_assoc();
      } catch (\Throwable $th) {
         error_log('Lỗi khi hiển thị chi tiết dữ liệu: ' . $th->getMessage());
         return $result;
      }
   }

   public function countTotalComment(){
    return $this->countTotal();
  }
}
