<?php 
include('control.php');
$get_data = new data();
$select = $get_data->select_congthuc();

// Nhóm công thức theo id_monan
$grouped = [];
foreach ($select as $row) {
  $grouped[$row['id_monan']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Danh Sách Công Thức</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 40px;
      background-color: #eef2f3;
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 40px;
    }

    .mon-block {
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      padding: 25px;
      margin-bottom: 40px;
      transition: transform 0.2s ease;
    }

    .mon-block:hover {
      transform: translateY(-4px);
    }

    h3 {
      margin-bottom: 15px;
      color: #2980b9;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 12px 16px;
      border: 1px solid #dcdcdc;
      text-align: center;
    }

    th {
      background-color: #3498db;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .btn-group {
      text-align: right;
      margin-top: 15px;
    }

    .btn {
      padding: 10px 18px;
      margin: 8px 4px 0;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      color: white;
      font-size: 14px;
      text-decoration: none;
      transition: background-color 0.2s ease;
    }

    .btn-edit {
      background-color: #f39c12;
    }

    .btn-edit:hover {
      background-color: #e67e22;
    }

    .btn-delete {
      background-color: #e74c3c;
    }

    .btn-delete:hover {
      background-color: #c0392b;
    }
  </style>
</head>
<body>

<h2>📋 Danh Sách Công Thức Món</h2>

<?php foreach ($grouped as $id_monan => $nguyenlieu_list): ?>
  <div class="mon-block">
    <h3>🍹 Món: <?php echo htmlspecialchars($get_data->get_tenmon($id_monan)); ?></h3>
    <table>
      <thead>
        <tr>
          <th>Nguyên Liệu</th>
          <th>Số Lượng</th>
          <th>Đơn Vị</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($nguyenlieu_list as $item): ?>
        <tr>
          <td><?php echo htmlspecialchars($get_data->get_tennguyenlieu($item['id_nguyenlieu'])); ?></td>
          <td><?php echo $item['soluong']; ?></td>
          <td><?php echo $item['donvi']; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="btn-group">
      <a href="updatecongthuc.php?id_monan=<?php echo $id_monan; ?>" class="btn btn-edit">✏️ Sửa công thức</a>
      <a href="xoacongthuc.php?id_monan=<?php echo $id_monan; ?>" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ công thức cho món này không?');">🗑️ Xóa món</a>
    </div>
  </div>
<?php endforeach; ?>

</body>
</html>
