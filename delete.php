<?php
include 'db.php';

if (isset($_GET['id'])) {
  $productID = $_GET['id'];

  // Xóa sản phẩm (xóa cả ảnh nhờ ràng buộc FOREIGN KEY)
  $conn->query("DELETE FROM Product WHERE ID = $productID");

  echo "Xóa sản phẩm thành công! <a href='index.php'>Quay lại danh sách</a>";
}
