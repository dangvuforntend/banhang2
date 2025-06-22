<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm Sản Phẩm</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
      background-color: #f8f9fa;
    }

    a.back-button {
      position: fixed;
      top: 20px;
      left: 20px;
      background-color: #6c757d;
      color: white;
      padding: 10px 16px;
      border-radius: 6px;
      text-decoration: none;
      z-index: 999;
    }

    h2 {
      text-align: center;
      margin-top: 80px;
      color: #343a40;
    }

    form {
      max-width: 400px;
      margin: auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      margin-top: 20px;
      padding: 10px;
      width: 100%;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <!-- Nút trở lại -->
  <a href="dasbord_admin.php" class="back-button">← Trở lại</a>

  <h2>Thêm Sản Phẩm Mới</h2>

  <form action="" method="POST" enctype="multipart/form-data">
    <label for="image">Ảnh sản phẩm:</label>
    <input type="file" name="anh" id="image" accept="image/*" required>

    <label for="name">Tên sản phẩm:</label>
    <input type="text" name="ten" id="name" required>

    <label for="price">Giá (VNĐ):</label>
    <input type="number" name="gia" id="price" min="0" required>

    <button name="submit" type="submit">Thêm Sản Phẩm</button>

    <?php
      if (isset($_POST['submit'])) {
        include('control.php');
        $get_data = new data();

        $anh_name = $_FILES['anh']['name'];
        $anh_tmp = $_FILES['anh']['tmp_name'];
        $upload_path = 'upload/' . $anh_name;

        if (move_uploaded_file($anh_tmp, $upload_path)) {
          $insert = $get_data->insert_menu($anh_name, $_POST['ten'], $_POST['gia']);
          if ($insert) {
            echo "<script>alert('Thêm thành công');</script>";
          } else {
            echo "<script>alert('Thêm thất bại');</script>";
          }
        } else {
          echo "<script>alert('Lỗi tải ảnh lên');</script>";
        }
      }
    ?>
  </form>

</body>
</html>
