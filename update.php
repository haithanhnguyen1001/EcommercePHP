<?php
include 'db.php';

// Lấy ID sản phẩm
$productID = $_GET['id'];
$product = $conn->query("SELECT * FROM Product WHERE ID = $productID")->fetch_assoc();
$images = $conn->query("SELECT * FROM Image WHERE ProductID = $productID");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sửa sản phẩm</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container my-5">
    <h1 class="text-center mb-4">Sửa sản phẩm</h1>

    <form action="update_process.php" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
      <input type="hidden" name="id" value="<?php echo $product['ID']; ?>">

      <div class="mb-3">
        <label for="name" class="form-label">Tên sản phẩm:</label>
        <input type="text" name="name" id="name" class="form-control" value="<?php echo $product['Name']; ?>" required>
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Mô tả:</label>
        <textarea name="description" id="description" class="form-control" rows="4"><?php echo $product['Description']; ?></textarea>
      </div>

      <div class="mb-3">
        <label for="price" class="form-label">Giá:</label>
        <input type="number" name="price" id="price" class="form-control" value="<?php echo $product['Price']; ?>" step="0.01" required>
      </div>

      <div class="mb-4">
        <h5>Hình ảnh hiện tại:</h5>
        <div class="d-flex flex-wrap">
          <?php while ($image = $images->fetch_assoc()) { ?>
            <div class="me-3 mb-3 text-center">
              <img src="<?php echo $image['Path']; ?>" class="img-thumbnail" style="width: 100px;">
              <div class="form-check mt-2">
                <input type="checkbox" class="form-check-input" name="delete_images[]" value="<?php echo $image['ID']; ?>" id="delete_<?php echo $image['ID']; ?>">
                <label for="delete_<?php echo $image['ID']; ?>" class="form-check-label">Xóa ảnh</label>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

      <div class="mb-3">
        <h5>Thêm hình ảnh mới:</h5>
        <input type="file" name="images[]" id="images" class="form-control" multiple>
      </div>

      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-success">Cập nhật</button>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS (Optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>