<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  // Thêm sản phẩm vào bảng Product
  $stmt = $conn->prepare("INSERT INTO Product (Name, Description, Price) VALUES (?, ?, ?)");
  $stmt->bind_param("ssd", $name, $description, $price);
  $stmt->execute();
  $productID = $stmt->insert_id; // ID sản phẩm vừa thêm

  // Kiểm tra và xử lý upload ảnh
  if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
      $fileName = basename($_FILES['images']['name'][$key]);
      $filePath = "uploads/" . $fileName;

      // Di chuyển file ảnh vào thư mục "uploads"
      if (move_uploaded_file($tmp_name, $filePath)) {
        // Lưu thông tin ảnh vào bảng Image
        $stmt = $conn->prepare("INSERT INTO Image (Path, ProductID) VALUES (?, ?)");
        $stmt->bind_param("si", $filePath, $productID);
        $stmt->execute();
      }
    }
  }

  echo "Thêm sản phẩm thành công! <a href='index.php'>Quay lại danh sách</a>";
}
