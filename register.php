<?php 
include('control.php');
$get_data = new data();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản nhân viên</title>
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
    <h2>Đăng ký tài khoản nhân viên</h2>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <input type="text" name="fullname" placeholder="Họ và tên" required>
        <input type="text" name="phone" placeholder="Số điện thoại">
        <input type="email" name="email" placeholder="Email">

        <button type="submit" name="register">Đăng ký</button>
    </form>
</div>

<?php 
if (isset($_POST['register'])) {
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['fullname']) || empty($_POST['phone']) || empty($_POST['email'])) {
        echo "Tên đăng nhập và mật khẩu không được để trống!";
    } else {
        $insert = $get_data->insert_user($_POST['username'], $_POST['password'], $_POST['fullname'], $_POST['phone'], $_POST['email']);
        
        if ($insert) {
            echo "<script>alert('Đăng ký thành công!'); window.location='register.php';</script>";
        } else {
            echo "<script>alert('Đăng ký không thành công. Vui lòng thử lại.');</script>";
        }
    }
}
?>

</body>
</html>
