<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update & Delete</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 40px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    img {
      width: 80px;
      height: 80px;
      border-radius: 8px;
      object-fit: cover;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
  </style>
</head>
<body>

<h1>Danh sách sản phẩm</h1>

<?php 
include('control.php');
$get_data = new data();
$select = $get_data->select_menu();
?>

<table>
  <thead>
    <tr>
      <th>Ảnh</th>
      <th>Tên</th>
      <th>Giá</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($select as $a) { ?>
      <tr>
        <td><img src="upload/<?php echo $a['anh'] ?>" alt="<?php echo $a['ten'] ?>"></td>
        <td><?php echo $a['ten'] ?></td>
        <td><?php echo number_format($a['gia'], 0, ',', '.') ?>đ</td>
        <td><a href="delete1.php?xoa=<?php echo $a['id']?>" onclick="if(confirm('bạn có chắc chắn muốn xóa')) return true; else return false">Xóa</a></td>
        <td><a href="update.php?sua=<?php echo $a['id']?>">Sửa</a></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

</body>
</html>
