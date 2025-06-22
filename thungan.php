<?php
include 'control.php';
$get_data = new data();

// Xử lý khi bấm nút hoàn thành giao dịch
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hoanthanh'])) {
    $idkhachhang = $_POST['idkhachhang'];
    $payment_method = $_POST['payment_method']; // lấy phương thức thanh toán

    // Lấy đơn hàng theo idkhachhang
    $donhang = $get_data->select_donhang_by_id($idkhachhang);

    foreach ($donhang as $item) {
        $get_data->insert_hoadon(
            $idkhachhang,
            $item['tenmon'],
            $item['somon'],
            $item['somon'] * $item['cost'],
            $item['order_date'],
            $item['cost'],
            $payment_method
        );
    }

    // Xóa đơn hàng sau khi đã thêm vào hóa đơn
    $get_data->delete_donhang_by_idkhachhang($idkhachhang);

    // Tải lại trang
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Lấy danh sách đơn hàng hiện tại
$donhang = $get_data->select_donhang();

// Nhóm đơn hàng theo idkhachhang
$grouped_donhang = [];
foreach ($donhang as $row) {
    $id = $row['idkhachhang'];
    if (!isset($grouped_donhang[$id])) {
        $grouped_donhang[$id] = [
            'mon' => [],
            'order_date' => $row['order_date'],
            'status' => $row['status'],
            'total' => 0
        ];
    }
    $grouped_donhang[$id]['mon'][] = [
        'anhmon' => $row['anhmon'],
        'tenmon' => $row['tenmon'],
        'somon' => $row['somon'],
        'cost' => $row['cost']
    ];
    $grouped_donhang[$id]['total'] += $row['somon'] * $row['cost'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Thu Ngân</title>
    <style>
        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: center;
            vertical-align: top;
        }
        .img-box {
            max-height: 100px;
            overflow-y: auto;
        }
        .img-box img {
            width: 30px;
            height: 30px;
            object-fit: cover;
            margin: 2px;
            display: block;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        button {
            padding: 6px 12px;
            background-color: #2ecc71;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #27ae60;
        }
        select {
            padding: 4px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<h2>💰 Trang Thu Ngân - Danh sách đơn hàng</h2>

<table>
    <thead>
        <tr>
            <th>Mã KH</th>
            <th>Ảnh món</th>
            <th>Tên món</th>
            <th>Tổng số lượng</th>
            <th>Giá món (VNĐ)</th>
            <th>Thành tiền (VNĐ)</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Phương thức thanh toán</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($grouped_donhang as $idkhachhang => $info): ?>
            <tr>
                <td><?= htmlspecialchars($idkhachhang) ?></td>
                <td>
                    <div class="img-box">
                        <?php foreach ($info['mon'] as $item): ?>
                            <img src="upload/<?= htmlspecialchars($item['anhmon']) ?>" alt="">
                        <?php endforeach; ?>
                    </div>
                </td>
                <td>
                    <?php foreach ($info['mon'] as $item): ?>
                        <?= htmlspecialchars($item['tenmon']) ?> (x<?= $item['somon'] ?>)<br>
                    <?php endforeach; ?>
                </td>
                <td><?= array_sum(array_column($info['mon'], 'somon')) ?></td>
                <td>
                    <?php foreach ($info['mon'] as $item): ?>
                        <?= number_format($item['cost'], 0, ',', '.') ?><br>
                    <?php endforeach; ?>
                </td>
                <td><?= number_format($info['total'], 0, ',', '.') ?></td>
                <td><?= date('d/m/Y H:i:s', strtotime($info['order_date'])) ?></td>
                <td>
                    <?= htmlspecialchars($info['status']) ?: '<span style="color: orange;">⏳ Chờ xử lý</span>' ?>
                </td>
                <td>
                    <form method="post" onsubmit="return confirm('Xác nhận đã giao đơn hàng này?');">
                        <input type="hidden" name="idkhachhang" value="<?= htmlspecialchars($idkhachhang) ?>">
                        <select name="payment_method" required>
                            <option value="">--Chọn--</option>
                            <option value="Tiền mặt">Tiền mặt</option>
                            <option value="Chuyển khoản">Chuyển khoản</option>
                        </select>
                </td>
                <td>
                        <button type="submit" name="hoanthanh">✅ Hoàn thành giao dịch</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
