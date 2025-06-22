<?php
include 'control.php';

date_default_timezone_set('Asia/Ho_Chi_Minh');
$get_data = new data();
$select_donhang = $get_data->select_donhang();

// Gom nhóm đơn hàng theo id khách hàng
$orders = [];
foreach ($select_donhang as $row) {
    $idkhachhang = $row['idkhachhang'];
    if (!isset($orders[$idkhachhang])) {
        $orders[$idkhachhang] = [
            'mon' => [],
            'idkhachhang' => $idkhachhang,
            'ngaydat' => $row['order_date'] ?? date('Y-m-d H:i:s'),
        ];
    }
    $orders[$idkhachhang]['mon'][] = [
        'anhmon' => $row['anhmon'],
        'tenmon' => $row['tenmon'],
        'somon' => $row['somon'],
        'cost' => $row['cost'], // giá món
    ];
}

// Xử lý khi có param complete từ ajax
if (isset($_GET['complete'])) {
    $idkhachhang = $_GET['complete'];

    if (isset($orders[$idkhachhang])) {
        $ngaydat = $orders[$idkhachhang]['ngaydat'];

        $tongtien_don = 0;
        foreach ($orders[$idkhachhang]['mon'] as $item) {
            $tongtien_don += $item['somon'] * $item['cost'];
        }

        foreach ($orders[$idkhachhang]['mon'] as $item) {
            $get_data->insert_hoadon(
                $idkhachhang,
                $item['tenmon'],
                $item['somon'],
                $tongtien_don,
                $ngaydat,
                $item['cost']
            );
        }

        $get_data->complete_donhang($idkhachhang);

        // Trả về json để JS biết hoàn thành
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng</title>
    <style>
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px 12px;
            text-align: center;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        .btn {
            padding: 6px 12px;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-complete {
            background-color: #2ecc71;
        }
        .btn-cancel {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">📦 Danh sách đơn hàng</h2>

<table id="ordersTable">
    <thead>
        <tr>
            <th>Mã KH</th>
            <th>Ảnh món</th>
            <th>Tên món</th>
            <th>Số lượng</th>
            <th>Ngày đặt</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $idkh => $order): ?>
            <tr id="order-row-<?= htmlspecialchars($idkh) ?>">
                <td><?= htmlspecialchars($idkh) ?></td>
                <td>
                    <?php foreach ($order['mon'] as $item): ?>
                        <img src="upload/<?= htmlspecialchars($item['anhmon']) ?>" alt="<?= htmlspecialchars($item['tenmon']) ?>">
                    <?php endforeach; ?>
                </td>
                <td>
                    <?php foreach ($order['mon'] as $item): ?>
                        <?= htmlspecialchars($item['tenmon']) ?><br>
                    <?php endforeach; ?>
                </td>
                <td>
                    <?php foreach ($order['mon'] as $item): ?>
                        x<?= (int)$item['somon'] ?><br>
                    <?php endforeach; ?>
                </td>
                <td><?= htmlspecialchars($order['ngaydat']) ?></td>
                <td>
                    <a href="#" 
                       class="btn btn-complete" 
                       data-id="<?= htmlspecialchars($idkh) ?>"
                       onclick="return completeOrder(event, '<?= htmlspecialchars($idkh) ?>')">Hoàn thành</a>
                    <a class="btn btn-cancel" href="delete_donhang.php?huy=<?= urlencode($idkh) ?>" onclick="return confirm('Xóa toàn bộ đơn của khách này?')">Hủy</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
function completeOrder(event, idkhachhang) {
    event.preventDefault();
    if (!confirm('Xác nhận hoàn thành đơn hàng?')) return false;

    fetch('?complete=' + encodeURIComponent(idkhachhang))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Ẩn hàng đơn hàng đã hoàn thành
                const row = document.getElementById('order-row-' + idkhachhang);
                if (row) row.style.display = 'none';
                alert('Đơn hàng đã được hoàn thành!');
            } else {
                alert('Có lỗi xảy ra khi hoàn thành đơn hàng.');
            }
        })
        .catch(() => {
            alert('Lỗi kết nối tới server.');
        });

    return false;
}
</script>

</body>
</html>
