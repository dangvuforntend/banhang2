<?php
include('control.php');
$get_data = new data();

$thang = isset($_GET['thang']) ? $_GET['thang'] : date('Y-m');
$doanhthu_theongay = [];
$mon_banchay = [];

$tong_don = 0;
$tong_monan = 0;
$tong_doanhthu = 0;

// Thêm biến tổng theo phương thức thanh toán
$tong_tienmat = 0;
$tong_ck = 0;

$ngay_max = '';
$doanhthu_max = 0;

$result = $get_data->select_hoadon();
while ($row = mysqli_fetch_assoc($result)) {
    if (substr($row['ngaydat'], 0, 7) === $thang) {
        $ngay = $row['ngaydat'];
        $so_luong = (int)$row['soluong'];
        $gia = (float)$row['giasp'];
        $tenmon = $row['tensp'];
        $phuongthuc = $row['payment_method'] ?? 'Không rõ';

        // Tính theo ngày
        if (!isset($doanhthu_theongay[$ngay])) {
            $doanhthu_theongay[$ngay] = ['don' => 0, 'mon' => 0, 'tien' => 0];
        }
        $doanhthu_theongay[$ngay]['don'] += 1;
        $doanhthu_theongay[$ngay]['mon'] += $so_luong;
        $doanhthu_theongay[$ngay]['tien'] += $so_luong * $gia;

        // Tổng
        $tong_don++;
        $tong_monan += $so_luong;
        $tong_doanhthu += $so_luong * $gia;

        // Tính tổng theo phương thức thanh toán
        if (strtolower($phuongthuc) === 'tiền mặt' || strtolower($phuongthuc) === 'tien mat') {
            $tong_tienmat += $so_luong * $gia;
        } elseif (strtolower($phuongthuc) === 'chuyển khoản' || strtolower($phuongthuc) === 'chuyen khoan') {
            $tong_ck += $so_luong * $gia;
        }

        // Top món bán chạy
        $mon_banchay[$tenmon] = ($mon_banchay[$tenmon] ?? 0) + $so_luong;
    }
}

// Ngày có doanh thu cao nhất
foreach ($doanhthu_theongay as $ngay => $val) {
    if ($val['tien'] > $doanhthu_max) {
        $doanhthu_max = $val['tien'];
        $ngay_max = $ngay;
    }
}

// Sắp xếp top món
arsort($mon_banchay);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Báo cáo doanh thu</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 90%; margin: 20px auto; }
        th, td { border: 1px solid #aaa; padding: 8px 12px; text-align: center; }
        th { background-color: #ddd; }
        h2, h3 { text-align: center; }
        form { text-align: center; margin: 20px; }
        .btns { text-align: center; margin: 20px; }
        .card-container { display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; }
        .card {
            border: 1px solid #aaa; border-radius: 8px;
            padding: 20px; width: 220px;
            background-color: #f8f8f8; text-align: center;
        }
    </style>
</head>
<body>

<h2>BÁO CÁO DOANH THU - Tháng <?= htmlspecialchars($thang) ?></h2>

<form method="GET">
    <label>Chọn tháng: </label>
    <input type="month" name="thang" value="<?= htmlspecialchars($thang) ?>">
    <input type="submit" value="Xem báo cáo">
</form>

<div class="card-container">
    <div class="card">
        <strong>Tổng đơn hàng</strong><br><?= $tong_don ?>
    </div>
    <div class="card">
        <strong>Tổng món đã bán</strong><br><?= $tong_monan ?>
    </div>
    <div class="card">
        <strong>Tổng doanh thu</strong><br><?= number_format($tong_doanhthu, 0) ?> VND
    </div>
    <div class="card">
        <strong>Ngày bán chạy nhất</strong><br><?= $ngay_max ?> (<?= number_format($doanhthu_max, 0) ?> VND)
    </div>
    <div class="card">
        <strong>Tiền mặt</strong><br><?= number_format($tong_tienmat, 0) ?> VND
    </div>
    <div class="card">
        <strong>Chuyển khoản</strong><br><?= number_format($tong_ck, 0) ?> VND
    </div>
</div>

<h3>🔢 Doanh thu theo ngày</h3>
<table>
    <tr>
        <th>Ngày</th>
        <th>Số đơn hàng</th>
        <th>Số món đã bán</th>
        <th>Doanh thu</th>
    </tr>
    <?php foreach ($doanhthu_theongay as $ngay => $data): ?>
        <tr>
            <td><?= $ngay ?></td>
            <td><?= $data['don'] ?></td>
            <td><?= $data['mon'] ?></td>
            <td><?= number_format($data['tien'], 0) ?> VND</td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>🏆 Top món bán chạy</h3>
<table>
    <tr>
        <th>STT</th>
        <th>Tên món</th>
        <th>Số lượng bán</th>
    </tr>
    <?php $i = 1; foreach ($mon_banchay as $ten => $sl): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($ten) ?></td>
            <td><?= $sl ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="btns">
<a href="xuatpdf.php?thang=<?= htmlspecialchars($thang) ?>" target="_blank">
    <button>📄 Xuất PDF</button>
</a>
</div>

</body>
</html>
