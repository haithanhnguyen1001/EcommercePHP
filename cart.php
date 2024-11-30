<?php
session_start();
include 'db.php'; // Kết nối database

$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giỏ hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container my-5">
    <h1 class="text-center mb-4">Giỏ hàng</h1>
    <a href="index.php" class="btn btn-secondary mb-4">Quay lại</a>

    <?php if (empty($cart)) { ?>
      <p class="text-center">Giỏ hàng trống.</p>
    <?php } else { ?>
      <table class="table">
        <thead>
          <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total_price = 0;
          foreach ($cart as $product_id => $quantity) {
            $result = $conn->query("SELECT * FROM Product WHERE ID = $product_id");
            $product = $result->fetch_assoc();
            $subtotal = $product['Price'] * $quantity;
            $total_price += $subtotal;
          ?>
            <tr>
              <td><?php echo $product['Name']; ?></td>
              <td><?php echo $quantity; ?></td>
              <td><?php echo number_format($product['Price']); ?> VND</td>
              <td><?php echo number_format($subtotal); ?> VND</td>
              <td>
                <a href="remove_from_cart.php?id=<?php echo $product_id; ?>" class="btn btn-danger btn-sm">Xóa</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-end">Tổng cộng:</th>
            <th><?php echo number_format($total_price); ?> VND</th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    <?php } ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>