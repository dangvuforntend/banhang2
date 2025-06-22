<?php
include('control.php');
$get_data = new data();
$lichsu_nhapkho_list = $get_data->select_nguyenlieu();  // Lấy dữ liệu từ bảng nguyenlieu
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh sách nguyên liệu</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #f4f4f4;
      position: relative;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    table {
      width: 90%;
      margin: auto;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 16px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f7f7f7;
      color: #333;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
    }

    a.button {
      padding: 6px 12px;
      text-decoration: none;
      border-radius: 4px;
      font-size: 14px;
    }

    a.edit {
      background-color: #007bff;
      color: white;
    }

    a.delete {
      background-color: #dc3545;
      color: white;
    }

    a.edit:hover {
      background-color: #0056b3;
    }

    a.delete:hover {
      background-color: #c82333;
    }

    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
      text-decoration: none;
      color: #28a745;
      font-size: 16px;
      background-color: transparent;
      border: 1px solid #28a745;
      padding: 6px 10px;
      border-radius: 4px;
    }

    .back-button:hover {
      background-color: #e8f5e9;
    }
  </style>
</head>
<body>

<a href="dasbord_admin.php" class="back-button">← Trở lại</a>

<h2>Sửa nguyên liệu</h2>

<table>
  <tr>
    <th>Tên nguyên liệu</th>
    <th>Đơn vị</th>
    <th>Giá (VNĐ)/1 đơn vị</th>
    <th>Hành động</th>
  </tr>
  <?php foreach ($lichsu_nhapkho_list as $item): ?>
  <tr>
    <td><?= htmlspecialchars($item['ten']) ?></td>
    <td><?= htmlspecialchars($item['donvi']) ?></td>
    <td><?= number_format($item['gia'], 0, ',', '.') ?>₫</td>
    <td class="action-buttons">
      <a href="update_nguyenlieu.php?id=<?= $item['id'] ?>" class="button edit">Sửa</a>
      <a href="xoanguyenlieu.php?id=<?= $item['id'] ?>" class="button delete" onclick="return confirm('Bạn có chắc muốn xóa nguyên liệu này?');">Xóa</a>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

</body>
</html>
