<?php 
include('control.php');
$get_data = new data();
$select_menu = $get_data->select_menu();
$select_nguyenlieu = $get_data->select_nguyenlieu();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_monan = $_POST['tenmon'];
    $nguyenlieu = $_POST['nguyenlieu'];
    $soluong = $_POST['soluong'];
    $donvi = $_POST['donvi'];

    foreach ($nguyenlieu as $index => $id_nguyenlieu) {
        if (!empty($id_nguyenlieu)) {
            $get_data->insert_congthuc($id_monan, $id_nguyenlieu, $soluong[$index], $donvi[$index]);
        }
    }
    echo '<script>
        alert("Gán công thức thành công!");
        window.location.href = window.location.href;
    </script>';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Gán Công Thức</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f1f3f5;
            margin: 40px auto;
            width: 85%;
            max-width: 900px;
            color: #333;
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
            color: #2c3e50;
            margin-top: 80px;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }
        select, input[type="number"], input[type="text"] {
            padding: 12px 16px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 100%;
            font-size: 16px;
            box-sizing: border-box;
            background-color: #fff;
            transition: border-color 0.3s ease;
        }
        select:focus, input[type="number"]:focus, input[type="text"]:focus {
            border-color: #3498db;
            outline: none;
        }
        table {
            width: 100%;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px 16px;
            text-align: left;
            font-size: 16px;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 15px;
            margin-right: 10px;
        }
        button:hover {
            background-color: #2980b9;
        }
        #them-hang {
            background-color: #27ae60;
        }
        #them-hang:hover {
            background-color: #219150;
        }

        @media (max-width: 768px) {
            body { width: 95%; }
            h2 { font-size: 24px; }
            select, input[type="number"], input[type="text"] { font-size: 14px; }
            button { font-size: 14px; padding: 10px 15px; }
            table { font-size: 14px; }
            th, td { padding: 10px 12px; }
        }
    </style>
</head>
<body>

<!-- Nút trở lại ở góc trái -->
<a href="dasbord_admin.php" class="back-button">← Trở lại</a>

<h2>Gán Công Thức</h2>

<form action="" method="POST">
    <label for="tenmon">Chọn món:</label>
    <select name="tenmon" id="tenmon" required>
        <option value="">-- Chọn món --</option>
        <?php foreach($select_menu as $i) { ?>
            <option value="<?= htmlspecialchars($i['id']) ?>"><?= htmlspecialchars($i['ten']) ?></option>
        <?php } ?>
    </select>

    <table id="nguyenlieu-table">
        <tr>
            <th>Nguyên liệu</th>
            <th>Số lượng</th>
            <th>Đơn vị</th>
        </tr>
        <tr>
            <td>
                <select name="nguyenlieu[]" required>
                    <option value="">-- Chọn nguyên liệu --</option>
                    <?php foreach($select_nguyenlieu as $t){ ?>
                        <option value="<?= htmlspecialchars($t['id']) ?>"><?= htmlspecialchars($t['ten']) ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="number" step="0.01" name="soluong[]" required></td>
            <td><input type="text" name="donvi[]" required></td>
        </tr>
    </table>

    <button type="button" id="them-hang" onclick="themHang()">+ Thêm nguyên liệu</button>
    <button type="submit">Gán công thức</button>
</form>

<script>
function themHang() {
    const table = document.getElementById("nguyenlieu-table");
    const row = table.insertRow(table.rows.length);
    row.innerHTML = `
        <td>
            <select name="nguyenlieu[]" required>
                <option value="">-- Chọn nguyên liệu --</option>
                <?php foreach($select_nguyenlieu as $t){ ?>
                    <option value="<?= htmlspecialchars($t['id']) ?>"><?= htmlspecialchars($t['ten']) ?></option>
                <?php } ?>
            </select>
        </td>
        <td><input type="number" step="0.01" name="soluong[]" required></td>
        <td><input type="text" name="donvi[]" required></td>
    `;
}
</script>

</body>
</html>
