<?php
include('control.php');
$get_data = new data();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $get_data->select_nguyenlieu_id($id);
    $nguyenlieu = mysqli_fetch_assoc($result);
}

if (isset($_POST['capnhat'])) {
    $ten = $_POST['ten'];
    $donvi = $_POST['donvi'];
    $gia = $_POST['gia'];

    $capnhat = $get_data->update_nguyenlieu($ten, $donvi, $gia, $id);

    if ($capnhat) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='capnhat_nguyenlieu.php';</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại. Vui lòng thử lại.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Cập nhật nguyên liệu</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 40px;
    }

    .container {
      width: 400px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }

    input[type="text"], input[type="number"] {
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
      border-radius: 4px;
      font-size: 16px;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Cập nhật nguyên liệu</h2>
  <form method="post">
    <label for="ten">Tên nguyên liệu:</label>
    <input type="text" name="ten" id="ten" required value="<?= htmlspecialchars($nguyenlieu['ten']) ?>">

    <label for="donvi">Đơn vị:</label>
    <input type="text" name="donvi" id="donvi" required value="<?= htmlspecialchars($nguyenlieu['donvi']) ?>">

    <label for="gia">Giá (VNĐ):</label>
    <input type="number" name="gia" id="gia" required min="0" step="100" value="<?= $nguyenlieu['gia'] ?>">

    <button type="submit" name="capnhat">Cập nhật</button>
  </form>
</div>

</body>
</html>
