<?php
include('control.php');
$get_data = new data();
$nguyenlieu_list = $get_data->select_nguyenlieu();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_nguyenlieu = $_POST['id_nguyenlieu'];
    $soluong = $_POST['soluong'];
    $ngaynhap = $_POST['ngaynhap'];

    if ($get_data->insert_nhapkho($id_nguyenlieu, $soluong, $ngaynhap)) {
        echo "<script>alert('Nhập kho thành công!'); window.location.href='nhapkho.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi nhập kho.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhập Kho Nguyên Liệu</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f1f3f5;
            margin: 40px auto;
            width: 90%;
            max-width: 600px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        select, input[type="number"], input[type="date"] {
            padding: 12px 16px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 100%;
            font-size: 16px;
            box-sizing: border-box;
            background-color: #fff;
            transition: border-color 0.3s ease;
        }

        select:focus, input:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            background-color: #3498db;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 24px;
            }

            button {
                font-size: 15px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

    <h2>Nhập Kho Nguyên Liệu</h2>

    <form method="POST" action="">
        <label for="id_nguyenlieu">Nguyên liệu:</label>
        <select name="id_nguyenlieu" required>
            <option value="">-- Chọn nguyên liệu --</option>
            <?php foreach ($nguyenlieu_list as $nl): ?>
                <option value="<?= $nl['id'] ?>"><?= $nl['ten'] ?> (<?= $nl['donvi'] ?>)</option>
            <?php endforeach; ?>
        </select>

        <label for="soluong">Số lượng:</label>
        <input type="number" step="0.01" name="soluong" required>

        <label for="ngaynhap">Ngày nhập:</label>
        <input type="date" name="ngaynhap" value="<?= date('Y-m-d') ?>" required>

        <button type="submit">Nhập kho</button>
    </form>

</body>
</html>
