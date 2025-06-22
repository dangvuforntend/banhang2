<?php
include('control.php');
$get_data = new data();

// Lấy lịch sử nhập kho
// Lấy dữ liệu nhập kho
$nhapkho_list = $get_data->select_nhapkho();

// Lấy hóa đơn và công thức
$hoadon_list = $get_data->select_hoadon();
$congthuc_all = [];
$congthuc_rs = $get_data->select_congthuc();


// Gộp dữ liệu nhập kho
$lichsu = [];
while ($row = mysqli_fetch_assoc($nhapkho_list)) {
    $lichsu[] = [
        'ten' => $row['ten'],
        'soluong' => $row['soluong'],
        'donvi' => $row['donvi'],
        'gia' => $row['gia'],
        'ngay' => $row['ngay'],
        'loai' => 'Nhập',
        'tongtien' => $row['gia'] * $row['soluong']
    ];
}

// Xử lý xuất kho
while ($hd = mysqli_fetch_assoc($hoadon_list)) {
    $tenmon = $hd['tensp'];
    $soluongmon = $hd['soluong'];
    $ngay = $hd['ngaydat'];

    // Lấy giá từ nhapkho
    $gia_xuat = 0;
    $gia_sql = "SELECT gia FROM nhapkho n JOIN nguyenlieu nl ON n.id_nguyenlieu = nl.id WHERE nl.ten = '$tenmon' ORDER BY n.ngay DESC LIMIT 1";
    $gia_result = mysqli_query($conn, $gia_sql);
    if ($gia_row = mysqli_fetch_assoc($gia_result)) {
        $gia_xuat = $gia_row['gia'];
    }

    if (isset($congthuc_all[$tenmon])) {
        foreach ($congthuc_all[$tenmon] as $ct) {
            $tennl = $ct['tennguyenlieu'];
            $donvi = $ct['donvi'];
            $soluong = $ct['soluong'] * $soluongmon;

            $lichsu[] = [
                'ten' => $tennl,
                'soluong' => $soluong,
                'donvi' => $donvi,
                'gia' => $gia_xuat,
                'ngay' => $ngay,
                'loai' => 'Xuất',
                'tongtien' => $gia_xuat * $soluong
            ];
        }
    }
}


// Sắp xếp theo ngày giảm dần
usort($lichsu, function($a, $b) {
    return strtotime($b['ngay']) - strtotime($a['ngay']);
});
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử giao dịch kho</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; }
        h2 { text-align: center; color: #333; }
        table {
            width: 95%; margin: 20px auto; border-collapse: collapse; background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;
        }
        th, td { padding: 12px 16px; border-bottom: 1px solid #ddd; text-align: center; }
        th { background-color: #f7f7f7; color: #333; }
        tr:hover { background-color: #f1f1f1; }
        .nhap { color: green; font-weight: bold; }
        .xuat { color: red; font-weight: bold; }
    </style>
</head>
<body>

<h2>Lịch sử giao dịch kho</h2>
<table>
    <tr>
        <th>Ngày giao dịch</th>
        <th>Nguyên liệu</th>
        <th>Số lượng</th>
        <th>Đơn vị</th>
        <th>Giá (VNĐ)/1 đơn vị</th>
        <th>Tổng tiền (VNĐ)</th>
        <th>Loại</th>
    </tr>
    <?php if (!empty($lichsu)): ?>
        <?php foreach ($lichsu as $item): ?>
        <tr>
            <td><?= date('d-m-Y', strtotime($item['ngay'])) ?></td>
            <td><?= htmlspecialchars($item['ten']) ?></td>
            <td><?= number_format($item['soluong'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($item['donvi']) ?></td>
            <td><?= number_format($item['gia'], 0, ',', '.') ?>₫</td>
            <td><?= number_format($item['tongtien'], 0, ',', '.') ?>₫</td>  <!-- Hiển thị tổng tiền -->
            <td class="<?= $item['loai'] === 'Nhập' ? 'nhap' : 'xuat' ?>"><?= $item['loai'] ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="7">Không có dữ liệu giao dịch.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
