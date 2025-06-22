<?php 
include('control.php');
$get_data = new data();

// Lấy ID món ăn từ URL
$id_monan = $_GET['id_monan'];

// Lấy công thức theo id_monan
$select_congthuc = $get_data->select_congthuc_idmonan($id_monan);

// Lấy danh sách nguyên liệu
$select_nguyenlieu = $get_data->select_nguyenlieu();

// Lấy tên món ăn để hiển thị
$tenmon = $get_data->get_tenmon($id_monan);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Công Thức</title>
    <style>
        /* Giữ nguyên phần CSS như cũ */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="number"],
        select {
            padding: 6px 10px;
            margin: 5px 0;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[readonly] {
            background-color: #e9ecef;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f1f1f1;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 18px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #them-hang {
            background-color: #28a745;
        }

        #them-hang:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<h2>Sửa Công Thức</h2>

<form action="" method="POST">
    <label>Món đang sửa:</label>
    <input type="text" name="tenmon" value="<?php echo $tenmon; ?>" readonly>
    <input type="hidden" name="id_monan" value="<?php echo $id_monan; ?>">

    <table id="nguyenlieu-table">
        <tr>
            <th>Nguyên liệu</th>
            <th>Số lượng</th>
            <th>Đơn vị</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($select_congthuc)) { ?>
            <tr>
                <td>
                    <select name="nguyenlieu[]">
                        <option value="">-- Chọn nguyên liệu --</option>
                        <?php foreach ($select_nguyenlieu as $nl) { ?>
                            <option value="<?php echo $nl['id']; ?>" <?php if ($row['id_nguyenlieu'] == $nl['id']) echo 'selected'; ?>>
                                <?php echo $nl['ten']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td><input type="number" step="0.01" name="soluong[]" value="<?php echo $row['soluong']; ?>"></td>
                <td><input type="text" name="donvi[]" value="<?php echo $row['donvi']; ?>"></td>
            </tr>
        <?php } ?>
    </table>

    <button type="button" id="them-hang">+ Thêm nguyên liệu</button>
    <button type="submit" name="submit_update">Cập nhật công thức</button>
</form>

<script>
    document.getElementById('them-hang').addEventListener('click', function () {
        const table = document.getElementById('nguyenlieu-table');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>
                <select name="nguyenlieu[]">
                    <option value="">-- Chọn nguyên liệu --</option>
                    <?php foreach ($select_nguyenlieu as $nl) { ?>
                        <option value="<?php echo $nl['id']; ?>"><?php echo $nl['ten']; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="number" step="0.01" name="soluong[]" value=""></td>
            <td><input type="text" name="donvi[]" value=""></td>
        `;

        table.appendChild(newRow);
    });
</script>

</body>
</html>

<?php
if (isset($_POST['submit_update'])) {
    $id_monan = $_POST['id_monan'];
    $nguyenlieu = $_POST['nguyenlieu'];
    $soluong = $_POST['soluong'];
    $donvi = $_POST['donvi'];

    // Xoá công thức cũ
    $get_data->delete_congthuc($id_monan);

    // Thêm công thức mới
    for ($i = 0; $i < count($nguyenlieu); $i++) {
        if (!empty($nguyenlieu[$i])) {
            $get_data->insert_congthuc($id_monan, $nguyenlieu[$i], $soluong[$i], $donvi[$i]);
        }
    }

    echo "<script>
        alert('Cập nhật công thức thành công!');
        window.location.href = 'hienthicongthuc.php';
    </script>";
}
?>
