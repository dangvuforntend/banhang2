<?php
include('control.php');
$get_data = new data();

$thang = isset($_GET['thang']) ? $_GET['thang'] : date('Y-m');
$month_before = date('Y-m', strtotime($thang . '-01 -1 month'));

// 1. Lấy danh sách nguyên liệu
$nguyenlieu_list = [];
$result = $get_data->select_nguyenlieu();
while ($row = mysqli_fetch_assoc($result)) {
    $nguyenlieu_list[] = $row;
}

// Tạo map id => tên, và map tên => [đơn vị, giá]
$id_to_ten_nguyenlieu = [];
$nguyenlieu_info = [];

foreach ($nguyenlieu_list as $nl) {
    $id_to_ten_nguyenlieu[$nl['id']] = $nl['ten'];
    $nguyenlieu_info[$nl['ten']] = [
        'donvi' => $nl['donvi'],
        'gia' => (float)$nl['gia']
    ];
}

// 2. Lấy danh sách món ăn
$monan_list = [];
$result = $get_data->select_menu();
while ($row = mysqli_fetch_assoc($result)) {
    $monan_list[$row['id']] = $row['ten'];
}

// 3. Lấy lịch sử nhập kho
$lichsunhapkho_list = [];
$result = $get_data->select_nhapkho();
while ($row = mysqli_fetch_assoc($result)) {
    $lichsunhapkho_list[] = $row;
}

// 4. Tính tổng nhập kho
$tondauky = [];
$nhapthang = [];

foreach ($lichsunhapkho_list as $nhap) {
    $ngay = substr($nhap['ngay'], 0, 7);
    $id = $nhap['id_nguyenlieu'];
    $ten = $id_to_ten_nguyenlieu[$id] ?? 'UNKNOWN';
    $soluong = (float)$nhap['soluong'];

    if ($ngay <= $month_before) {
        $tondauky[$ten] = ($tondauky[$ten] ?? 0) + $soluong;
    } elseif ($ngay === $thang) {
        $nhapthang[$ten] = ($nhapthang[$ten] ?? 0) + $soluong;
    }
}

// 5. Lấy danh sách hóa đơn
$hoadon = [];
$result = $get_data->select_hoadon();
while ($row = mysqli_fetch_assoc($result)) {
    $hoadon[] = $row;
}

// 6. Đếm số món đã bán
$mon_ban_truoc = [];
$mon_ban_hientai = [];

foreach ($hoadon as $row) {
    if (isset($row['ngaydat'])) {
        $thang_hd = substr($row['ngaydat'], 0, 7);
        $tenmon = $row['tensp'];
        $soluong = (int)$row['soluong'];

        if ($thang_hd <= $month_before) {
            $mon_ban_truoc[$tenmon] = ($mon_ban_truoc[$tenmon] ?? 0) + $soluong;
        } elseif ($thang_hd === $thang) {
            $mon_ban_hientai[$tenmon] = ($mon_ban_hientai[$tenmon] ?? 0) + $soluong;
        }
    }
}

// 7. Lấy công thức
$congthuc_list = [];
$result = $get_data->select_congthuc();
while ($row = mysqli_fetch_assoc($result)) {
    $congthuc_list[] = $row;
}

// 8. Tính nguyên liệu đã dùng
$nguyenlieu_dadung_truoc = [];
$nguyenlieu_dadung_hientai = [];

foreach ($congthuc_list as $ct) {
    $idmon = $ct['id_monan'];
    $idnl = $ct['id_nguyenlieu'];
    $sluong_ct = (float)$ct['soluong'];

    $tenmon = $monan_list[$idmon] ?? 'UNKNOWN';
    $tennl = $id_to_ten_nguyenlieu[$idnl] ?? 'UNKNOWN';

    if (isset($mon_ban_truoc[$tenmon])) {
        $nguyenlieu_dadung_truoc[$tennl] = ($nguyenlieu_dadung_truoc[$tennl] ?? 0) + ($mon_ban_truoc[$tenmon] * $sluong_ct);
    }

    if (isset($mon_ban_hientai[$tenmon])) {
        $nguyenlieu_dadung_hientai[$tennl] = ($nguyenlieu_dadung_hientai[$tennl] ?? 0) + ($mon_ban_hientai[$tenmon] * $sluong_ct);
    }
}

// 9. Tính tồn kho cuối kỳ
$nguyenlieu_conlai = [];
$ten_nguyenlieu_all = array_unique(array_merge(
    array_keys($tondauky),
    array_keys($nhapthang),
    array_keys($nguyenlieu_dadung_hientai)
));

foreach ($ten_nguyenlieu_all as $ten) {
    $tondau = $tondauky[$ten] ?? 0;
    $dadung_truoc = $nguyenlieu_dadung_truoc[$ten] ?? 0;
    $dadung_hientai = $nguyenlieu_dadung_hientai[$ten] ?? 0;
    $nhap = $nhapthang[$ten] ?? 0;

    $tondau_thucte = $tondau - $dadung_truoc;
    $conlai = $tondau_thucte + $nhap - $dadung_hientai;

    $gia = $nguyenlieu_info[$ten]['gia'] ?? 0;
    $nguyenlieu_conlai[$ten] = [
        'tondauky' => max(0, $tondau_thucte),
        'nhapthang' => $nhap,
        'dadung' => $dadung_hientai,
        'conlai' => max(0, $conlai),
        'gia' => $gia,
        'tien' => max(0, $conlai) * $gia
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thống kê tồn kho theo tháng</title>
    <style>
        table {
            border-collapse: collapse;
            width: 95%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 8px 12px;
            text-align: center;
        }
        th {
            background-color: #ccc;
        }
        form {
            text-align: center;
            margin: 20px;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Tồn kho tháng <?= htmlspecialchars($thang) ?></h2>

<form method="GET">
    <label for="thang">Chọn tháng:</label>
    <input type="month" name="thang" value="<?= htmlspecialchars($thang) ?>">
    <input type="submit" value="Xem tồn kho">
</form>

<table>
    <tr>
        <th>Tên nguyên liệu</th>
        <th>Đơn vị</th>
        <th>Tồn đầu kỳ</th>
        <th>Nhập trong tháng</th>
        <th>Đã dùng</th>
        <th>Tồn cuối kỳ</th>
        <th>Giá / 1 đơn vị</th>
        <th>Tổng tiền tồn</th>
        <th>Cảnh báo</th>
    </tr>
    <?php foreach ($nguyenlieu_conlai as $ten => $data): ?>
        <tr>
            <td><?= htmlspecialchars($ten) ?></td>
            <td><?= htmlspecialchars($nguyenlieu_info[$ten]['donvi'] ?? '') ?></td>
            <td><?= $data['tondauky'] ?></td>
            <td><?= $data['nhapthang'] ?></td>
            <td><?= $data['dadung'] ?></td>
            <td><?= $data['conlai'] ?></td>
            <td><?= number_format($data['gia'], 2) ?> VND</td>
            <td><?= number_format($data['tien'], 2) ?> VND</td>
            <td>
                <?php if ($data['conlai'] <= 10): ?>
                    <span style="color: red; font-weight: bold;">Cần nhập</span>
                <?php else: ?>
                    <span style="color: green;">Đủ</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
