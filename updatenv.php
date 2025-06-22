<?php 
include('control.php');
$get_data = new data();

$id = $_GET['id'] ?? null;
$user = null;

if ($id) {
    $result = $get_data->select_user_id($id);
    $user = mysqli_fetch_assoc($result);
}

// Xử lý cập nhật khi nhấn nút "Cập nhật"
if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $update = $get_data->update_user($id, $username, $password, $fullname, $phone, $email);

    if ($update) {
        echo "<script>alert('Cập nhật thành công'); window.location='editnv.php?id=$id';</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa tài khoản nhân viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
            position: relative;
        }
        .container {
            max-width: 450px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input[type="text"], input[type="password"], input[type="email"], input[type="phone"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            background: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #45a049;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            color: #4CAF50;
            text-decoration: none;
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

<div class="container">
    <h2>Sửa tài khoản nhân viên</h2>

    <?php if ($user) { ?>
    <form method="post">
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" placeholder="Tên đăng nhập" required>
        <input type="text" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" placeholder="Mật khẩu" required>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" placeholder="Họ và tên" required>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" placeholder="Số điện thoại">
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Email">

        <button type="submit" name="update">Cập nhật</button>
    </form>
    <?php } else { ?>
        <p style="color: red;">Không tìm thấy tài khoản cần sửa.</p>
    <?php } ?>
</div>

</body>
</html>
