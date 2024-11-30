<?php
session_start();
include 'db.php'; // Kết nối database

$product_id = $_POST['product_id'];

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Tăng số lượng sản phẩm trong giỏ hàng
if (isset($_SESSION['cart'][$product_id])) {
  $_SESSION['cart'][$product_id]++;
} else {
  $_SESSION['cart'][$product_id] = 1;
}

// Quay về trang danh sách sản phẩm
header('Location: index.php');
exit;
