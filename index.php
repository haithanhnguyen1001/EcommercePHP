<?php
include 'db.php';

$result = $conn->query("SELECT * FROM Product");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danh sách sản phẩm</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container my-5">
    <div class="d-flex justify-content-between mb-4">
      <h1>Danh sách sản phẩm</h1>
      <a href="cart.php" class="btn btn-outline-secondary position-relative">
        <i class="bi bi-cart"></i> Giỏ hàng
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          <?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
        </span>
      </a>
    </div>
    <div class="text-end mb-4">
      <a href="create.php" class="btn btn-primary">Thêm sản phẩm mới</a>
    </div>

    <?php while ($product = $result->fetch_assoc()) { ?>
      <div class="card mb-4 shadow-sm">
        <div class="card-body">
          <h2 class="card-title"><?php echo $product['Name']; ?></h2>
          <p class="card-text"><?php echo $product['Description']; ?></p>
          <p class="card-text"><strong>Giá:</strong> <?php echo number_format($product['Price']); ?> VND</p>

          <h5>Hình ảnh:</h5>
          <div class="d-flex flex-wrap mb-3">
            <?php
            $productID = $product['ID'];
            $images = $conn->query("SELECT * FROM Image WHERE ProductID = $productID");
            while ($image = $images->fetch_assoc()) {
              echo "<img src='{$image['Path']}' class='img-thumbnail me-2' style='width: 100px;'>";
            }
            ?>
          </div>

          <form action="add_to_cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product['ID']; ?>">
            <button type="submit" class="btn btn-success btn-sm">Thêm vào giỏ</button>
          </form>
          <div class="mt-3">
            <a href="update.php?id=<?php echo $product['ID']; ?>" class="btn btn-warning btn-sm">Sửa</a>
            <a href="delete.php?id=<?php echo $product['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>