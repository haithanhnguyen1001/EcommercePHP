<?php
session_start();

$product_id = $_GET['id'];
if (isset($_SESSION['cart'][$product_id])) {
  unset($_SESSION['cart'][$product_id]);
}

// Quay về trang giỏ hàng
header('Location: cart.php');
exit;
