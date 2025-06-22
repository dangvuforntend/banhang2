<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Trang Quản Lý</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background-color: #f0f0f0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background: white;
      padding: 40px 60px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
    }

    h1 {
      margin-bottom: 30px;
      color: #333;
    }

    a.button {
      display: inline-block;
      margin: 10px;
      padding: 12px 25px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: background-color 0.3s;
    }

    a.button:hover {
      background-color: #0056b3;
    }

    details {
      margin-top: 20px;
    }

    summary {
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      margin-bottom: 10px;
      color: #007bff;
    }

    .submenu a {
      display: block;
      margin: 8px 0;
      padding: 10px;
      background-color: #28a745;
      color: white;
      border-radius: 6px;
      text-decoration: none;
    }

    .submenu a:hover {
      background-color: #1e7e34;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Trang Quản Lý</h1>

  <!-- Nút xem đơn hàng -->
  <a href="donhang.php" class="button">Xem đơn hàng</a>

  <!-- Nút quản lý sản phẩm dùng details -->
  <details>
    <summary>Cập nhật sản phẩm</summary>
    <div class="submenu">
      <a href="admin_cart.php">➕ Thêm sản phẩm</a>
      <a href="edit_product.php">✏️ Sửa / Xóa sản phẩm</a>
    </div>
  </details>
</div>

</body>
</html>
