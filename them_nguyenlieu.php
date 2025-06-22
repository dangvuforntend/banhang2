<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm Nguyên Liệu</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      padding: 40px;
      position: relative;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    form {
      background-color: white;
      max-width: 400px;
      margin: 0 auto;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      border: none;
      color: white;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
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

  <h2>Thêm Nguyên Liệu Mới</h2>

  <form action="#" method="post">
    <label for="ten">Tên nguyên liệu:</label>
    <input type="text" id="ten" name="ten" required>

    <label for="donvi">Đơn vị:</label>
    <select id="donvi" name="donvi" required>
      <option value="gram">gram</option>
      <option value="ml">ml</option>
      <option value="cái">cái</option>
      <option value="lon">lon</option>
    </select>

    <label for="gia">Giá vốn</label>
    <input type="number" id="gia" name="gia" min="0" required>

    <button type="submit" name="submit">Thêm nguyên liệu</button>
  </form>

  <?php
    if (isset($_POST['submit'])) {
      include('control.php');
      $get_data = new data();

      $insert = $get_data->insert_nguyenlieu(
        $_POST['ten'],
        $_POST['donvi'],
        $_POST['gia']
      );

      if ($insert) {
        echo "<script>alert('Thêm nguyên liệu thành công')</script>";
      } else {
        echo "<script>alert('Không thêm được nguyên liệu vào kho')</script>";
      }
    }
  ?>
</body>
</html>
