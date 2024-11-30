<?php

session_start(); // Bắt đầu session để quản lý giỏ hàng

$servername = "localhost"; // Hoặc địa chỉ IP
$username = "root"; // Tài khoản MySQL
$password = ""; // Mật khẩu MySQL
$database = "shop"; // Tên cơ sở dữ liệu
$port = 3307; // Port MySQL

$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}
