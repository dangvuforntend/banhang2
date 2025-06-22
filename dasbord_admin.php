<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

$role = $_SESSION['role'];
$fullname = $_SESSION['fullname'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Hệ Thống Quản Lý Trà Sữa</title>
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
    }

    header {
      background-color: #007bff;
      color: white;
      padding: 20px 30px;
      font-size: 22px;
    }

    .navbar {
      display: flex;
      flex-wrap: wrap;
      background-color: #343a40;
      align-items: center;
    }

    .navbar a, .dropbtn {
      color: white;
      padding: 14px 20px;
      text-decoration: none;
      text-align: center;
      cursor: pointer;
      background: none;
      border: none;
      font-size: 16px;
    }

    .navbar a:hover, .dropbtn:hover {
      background-color: #495057;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #ffffff;
      min-width: 220px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      z-index: 1;
      border-radius: 4px;
    }

    .dropdown-content a {
      color: #343a40;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #f8f9fa;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .navbar-right {
      margin-left: auto;
      padding: 14px 20px;
      color: white;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .navbar-right .logout a {
      color: #ffc107;
      text-decoration: underline;
      font-weight: bold;
    }

    .container {
      padding: 40px;
    }

    h2 {
      color: #333;
    }
  </style>
</head>
<body>

<header>
  🍹 Xin chào, <?php echo htmlspecialchars($fullname); ?>!
</header>

<div class="navbar">

  <?php if ($role === 'admin') { ?>
    <div class="dropdown">
      <button class="dropbtn">👤 Tài khoản nhân viên</button>
      <div class="dropdown-content">
        <a href="register.php">➕ Thêm tài khoản</a>
        <a href="editnv.php">Cập nhật tài khoản</a>
      </div>
    </div>
  <?php } ?>

  <?php if ($role === 'admin' || $role === 'employee') { ?>
    <a href="donhang.php">📃 Xem đơn hàng</a>

    <div class="dropdown">
      <button class="dropbtn">📦 Kho</button>
      <div class="dropdown-content">
        <a href="them_nguyenlieu.php">➕ Thêm nguyên liệu</a>
        <a href="capnhat_nguyenlieu.php">✏️ Sửa/Xóa nguyên liệu</a>
        <a href="nhapkho.php">📥 Nhập kho</a>
        <a href="thong_ke.php">📊 Tồn kho</a>
        <a href="giaodich.php">📋 Giao dịch kho</a>
      </div>
    </div>
  <?php } ?>

  <?php if ($role === 'admin') { ?>
    <div class="dropdown">
      <button class="dropbtn">📖 Công thức</button>
      <div class="dropdown-content">
        <a href="gan_nguyenlieu.php">➕ Tạo công thức</a>
        <a href="hienthicongthuc.php">✏️ Sửa công thức</a>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropbtn">🍹 Món</button>
      <div class="dropdown-content">
        <a href="admin_cart.php">➕ Thêm món</a>
        <a href="edit_product.php">✏️ Sửa/Xóa món</a>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropbtn">📈 Báo cáo</button>
      <div class="dropdown-content">
        <a href="doanhthu.php">💰 Doanh thu</a>
        <a href="loinhuan.php">📉 Lợi nhuận</a>
      </div>
    </div>
  <?php } ?>

  <!-- Thêm menu Thu Ngân không phân quyền -->
  <a href="thungan.php">💵 Thu Ngân</a>

  <div class="navbar-right">
    <span>👋 <?php echo htmlspecialchars($fullname); ?></span>
    <div class="logout"><a href="login_admin.php">Đăng xuất</a></div>
  </div>

</div>

<div class="container">
  <h2>Chào mừng đến với hệ thống quản lý quán ăn </h2>
  <p>Hãy chọn chức năng phù hợp từ thanh menu phía trên để bắt đầu làm việc.</p>
</div>

</body>
</html>
