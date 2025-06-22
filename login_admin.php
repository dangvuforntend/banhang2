<?php
session_start();
include('control.php'); // Bao gồm class data

$error = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = new data();


    //tài khoản admin

    if ($username === 'admin' && $password === '123456') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['role'] = 'admin';
        $_SESSION['username'] = 'admin';
        $_SESSION['fullname'] = 'Chủ cửa hàng';
        header('Location: dasbord_admin.php');
        exit();
    }

    $result = $data->select_user($username, $password);
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['staff_logged_in'] = true;
        $_SESSION['role'] = 'employee';
        $_SESSION['username'] = $user['username'];
        $_SESSION['fullname'] = $user['fullname'];
        header('Location: dasbord_admin.php');
        exit();
    } else {
        $error = "❌ Sai tên đăng nhập hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng Nhập</title>
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background-color: #f0f2f5;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    form {
      background-color: #ffffff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 30px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-sizing: border-box;
      transition: border 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #007bff;
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #0056b3;
    }

    .error {
      margin-top: 15px;
      color: red;
      text-align: center;
    }

    @media (max-width: 500px) {
      form {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <form method="POST">
    <h2>Đăng Nhập</h2>

    <label for="username">Tên đăng nhập:</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Mật khẩu:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit" name="login">Đăng Nhập</button>

    <?php if ($error) : ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
  </form>

</body>
</html>
