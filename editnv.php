<?php 
include('control.php');
$get_data = new data();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý tài khoản nhân viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
            position: relative;
        }

        h2 {
            margin-bottom: 10px;
            text-align: center;
            color: #333;
        }

        table {
            width: 90%;
            margin: 50px auto 0;
            border-collapse: collapse;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            background-color: #fff;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #f5f5f5;
        }

        .btn-delete {
            padding: 6px 12px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: #4CAF50;
            font-size: 16px;
            background-color: transparent;
            border: 1px solid #4CAF50;
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

<h2>Quản lý tài khoản nhân viên</h2>

<table>
    <tr>
        <th>Tài khoản</th>
        <th>Mật khẩu</th>
        <th>Họ và tên</th>
        <th>Số điện thoại</th>
        <th>Email</th>
        <th>Hành động</th>
    </tr>

    <?php 
    $select = $get_data->select_all_user();
    while($t = mysqli_fetch_assoc($select)) {
    ?>
    <tr>
        <td><?php echo htmlspecialchars($t['username']); ?></td>
        <td><?php echo htmlspecialchars($t['password']); ?></td>
        <td><?php echo htmlspecialchars($t['fullname']); ?></td>
        <td><?php echo htmlspecialchars($t['phone']); ?></td>
        <td><?php echo htmlspecialchars($t['email']); ?></td>
        <td>
            <a href="delete_user.php?id=<?php echo $t['id']; ?>" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">Xóa</a>
            <a href="updatenv.php?id=<?php echo $t['id']; ?>" class="btn-delete" >Sửa</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
