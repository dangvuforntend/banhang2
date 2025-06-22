<?php
include('control.php');
$get_data = new data();

// Lấy danh sách nguyên liệu
$nguyenlieu_list = [];
$nguyenlieu_info = [];
$result = $get_data->select_nguyenlieu();
while ($row = mysqli_fetch_assoc($result)) {
    $nguyenlieu_list[$row['id']] = $row['ten'];
    $nguyenlieu_info[$row['id']] = [
        'ten' => $row['ten'],
        'gia' => isset($row['gia']) ? $row['gia'] : 0
    ];
}

// Lấy danh sách món ăn
$monan_list = [];
$result = $get_data->select_menu();
while ($row = mysqli_fetch_assoc($result)) {
    $monan_list[$row['id']] = $row['ten'];
}

// Lấy công thức
$congthuc_list = [];
$result = $get_data->select_congthuc();
while ($row = mysqli_fetch_assoc($result)) {
    $congthuc_list[] = $row;
}

// Giao dịch nhập kho
$lichsu_giaodich = [];
$result = $get_data->select_nhapkho();
while ($row = mysqli_fetch_assoc($result)) {
    $idnl = $row['id_nguyenlieu'];
    $gia = isset($row['gia']) ? $row['gia'] : ($nguyenlieu_info[$idnl]['gia'] ?? 0);

    $lichsu_giaodich[] = [
        'ngay' => $row['ngay'],
        'ten_nguyenlieu' => $nguyenlieu_list[$idnl] ?? 'UNKNOWN',
        'loai' => 'Nhập',
        'gia_donvi' => $gia,
        'soluong' => $row['soluong']
    ];
}

// Giao dịch xuất kho từ hóa đơn
$hoadon = [];
$result = $get_data->select_hoadon();
while ($row = mysqli_fetch_assoc($result)) {
    $hoadon[] = $row;
}

foreach ($hoadon as $hd) {
    $tenmon = $hd['tensp'];
    $ngay = $hd['ngaydat'] ?? '';
    $soluong_mua = (int)$hd['soluong'];

    $idmon = array_search($tenmon, $monan_list);
    if (!$idmon) continue;

    foreach ($congthuc_list as $ct) {
        if ($ct['id_monan'] == $idmon) {
            $idnl = $ct['id_nguyenlieu'];
            $tennl = $nguyenlieu_list[$idnl] ?? 'UNKNOWN';
            $gia = $nguyenlieu_info[$idnl]['gia'] ?? 0;
            $soluong_nguyenlieu = $ct['soluong'] * $soluong_mua;

            $lichsu_giaodich[] = [
                'ngay' => $ngay,
                'ten_nguyenlieu' => $tennl,
                'loai' => 'Xuất',
                'gia_donvi' => $gia,
                'soluong' => $soluong_nguyenlieu
            ];
        }
    }
}

// Sắp xếp theo ngày giảm dần
usort($lichsu_giaodich, function ($a, $b) {
    return strtotime($b['ngay']) - strtotime($a['ngay']);
});
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lịch sử giao dịch nguyên liệu</title>
    <style>
        body {
            font-family: Arial;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 30px auto;
        }
        th, td {
            border: 1px solid #888;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #ddd;
        }
        h2 {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<h2>Lịch sử giao dịch nguyên liệu</h2>

<table>
    <tr>
        <th>Ngày giao dịch</th>
        <th>Tên nguyên liệu</th>
        <th>Loại giao dịch</th>
        <th>Số lượng</th>
        <th>Tổng tiền (VND)</th>
    </tr>
    <?php foreach ($lichsu_giaodich as $gd): ?>
        <tr>
            <td><?= htmlspecialchars($gd['ngay']) ?></td>
            <td><?= htmlspecialchars($gd['ten_nguyenlieu']) ?></td>
            <td>
                <?= $gd['loai'] == 'Nhập'
                    ? '<span style="color:green;">Nhập</span>'
                    : '<span style="color:red;">Xuất</span>' ?>
            </td>
            <td><?= $gd['soluong'] ?></td>
            <td><?= number_format($gd['soluong'] * $gd['gia_donvi'], 0) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
