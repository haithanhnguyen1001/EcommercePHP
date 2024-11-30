<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id']; // ID của sản phẩm cần chỉnh sửa
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  // Cập nhật thông tin sản phẩm
  $stmt = $conn->prepare("UPDATE Product SET Name = ?, Description = ?, Price = ? WHERE ID = ?");
  $stmt->bind_param("ssdi", $name, $description, $price, $id);
  $stmt->execute();

  // Xóa ảnh đã chọn nếu có
  if (!empty($_POST['delete_images'])) {
    foreach ($_POST['delete_images'] as $imageID) {
      // Lấy đường dẫn file ảnh
      $image = $conn->query("SELECT Path FROM Image WHERE ID = $imageID")->fetch_assoc();
      if (file_exists($image['Path'])) {
        unlink($image['Path']); // Xóa file khỏi thư mục
      }
      // Xóa ảnh khỏi cơ sở dữ liệu
      $conn->query("DELETE FROM Image WHERE ID = $imageID");
    }
  }

  // Xử lý thêm ảnh mới nếu người dùng upload
  if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
      $fileName = basename($_FILES['images']['name'][$key]);
      $filePath = "uploads/" . $fileName;

      // Di chuyển file ảnh vào thư mục "uploads"
      if (move_uploaded_file($tmp_name, $filePath)) {
        // Thêm thông tin ảnh mới vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO Image (path, ProductID) VALUES (?, ?)");
        $stmt->bind_param("si", $filePath, $id);
        $stmt->execute();
      }
    }
  }

  echo "Cập nhật sản phẩm thành công! <a href='index.php'>Quay lại danh sách</a>";
}
