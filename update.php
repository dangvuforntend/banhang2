<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thêm Sản Phẩm</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
    }
    form {
      max-width: 400px;
      margin: auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
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
    }
    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <h2>Thêm Sản Phẩm Mới</h2>
  <?php 
    include('control.php');
    $get_data = new data();
    $select = $get_data->select_menu_id($_GET['sua']);
    foreach($select as $u){
  ?>

  <form action="" method="POST" enctype="multipart/form-data">
    <label for="image">Ảnh sản phẩm:</label>
    <input type="file" name="anh" id="image" accept="image/*">

    <label for="name">Tên sản phẩm:</label>
    <input type="text" name="ten" id="name" required value="<?php echo $u['ten'] ?>">

    <label for="price">Giá (VNĐ):</label>
    <input type="text" name="gia" id="price" min="0" required value="<?php echo $u['gia']?>">

    <button name="submit" type="submit">Sửa</button>
  </form>

  <?php } ?>

  <?php 
    if(isset($_POST['submit'])){
      $ten = $_POST['ten'];
      $gia = $_POST['gia'];
      $id = $_GET['sua'];

      // Lấy tên ảnh và lưu vào thư mục upload/
      $anh = $_FILES['anh']['name'];
      $tmp = $_FILES['anh']['tmp_name'];
      move_uploaded_file($tmp, 'upload/'.$anh);

      // Cập nhật dữ liệu
      $update = $get_data->update_menu($id, $anh, $ten, $gia);
      if($update){
        header('Location: edit_product.php');
        exit;
      } else {
        echo "Không cập nhật được.";
      }
    }
  ?>

</body>
</html>
