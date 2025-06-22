<?php
include('control.php');
$get_data = new data();

$thang = isset($_GET['thang']) ? $_GET['thang'] : date('Y-m');
$tong_doanhthu = 0;
$tong_chiphi = 0;
$tong_loinhuan = 0;
$doanhthu_theongay = [];

$hoadon_result = $get_data->select_hoadon();

while ($row = mysqli_fetch_assoc($hoadon_result)) {
    if (substr($row['ngaydat'], 0, 7) === $thang) {
        $tenmon = $row['tensp'];
        $soluong_ban = (int)$row['soluong'];
        $giasp = (float)$row['giasp'];
        $ngay = $row['ngaydat'];

        // Tìm ID món ăn
        $id_monan = null;
        $menu_result = $get_data->select_menu();
        while ($menu_row = mysqli_fetch_assoc($menu_result)) {
            if ($menu_row['ten'] == $tenmon) {
                $id_monan = $menu_row['id'];
                break;
            }
        }

        // Tính chi phí nguyên liệu
        $chiphi_mot_mon = 0;
        if ($id_monan !== null) {
            $congthuc_result = $get_data->select_congthuc_idmonan($id_monan);
            while ($ct = mysqli_fetch_assoc($congthuc_result)) {
                $id_nl = $ct['id_nguyenlieu'];
                $soluong_nglieu = (float)$ct['soluong'];

                $nl_row_result = $get_data->select_nguyenlieu_id($id_nl);
                if ($nl_row = mysqli_fetch_assoc($nl_row_result)) {
                    $gia_nl = (float)$nl_row['gia'];
                    $chiphi_mot_mon += $soluong_nglieu * $gia_nl;
                }
            }
        }

        $doanhthu = $soluong_ban * $giasp;
        $chiphi = $soluong_ban * $chiphi_mot_mon;
        $loinhuan = $doanhthu - $chiphi;

        $tong_doanhthu += $doanhthu;
        $tong_chiphi += $chiphi;
        $tong_loinhuan += $loinhuan;

        if (!isset($doanhthu_theongay[$ngay])) {
            $doanhthu_theongay[$ngay] = ['doanhthu' => 0, 'chiphi' => 0, 'loinhuan' => 0];
        }

        $doanhthu_theongay[$ngay]['doanhthu'] += $doanhthu;
        $doanhthu_theongay[$ngay]['chiphi'] += $chiphi;
        $doanhthu_theongay[$ngay]['loinhuan'] += $loinhuan;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Báo cáo Lợi nhuận Gộp</title>
    <style>
        body { font-family: Arial; }
        table { width: 90%; border-collapse: collapse; margin: 30px auto; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: center; }
        th { background-color: #f0f0f0; }
        h2, form { text-align: center; }
        .summary { margin: 30px auto; width: 90%; font-size: 18px; }
    </style>
</head>
<body>
    <h2>BÁO CÁO LỢI NHUẬN GỘP THÁNG <?= $thang ?></h2>

    <form method="get">
        <label for="thang">Chọn tháng: </label>
        <input type="month" id="thang" name="thang" value="<?= $thang ?>">
        <button type="submit">Xem báo cáo</button>
    </form>

    <table>
        <tr>
            <th>Ngày</th>
            <th>Doanh thu</th>
            <th>Chi phí</th>
            <th>Lợi nhuận gộp</th>
        </tr>
        <?php foreach ($doanhthu_theongay as $ngay => $data): ?>
            <tr>
                <td><?= $ngay ?></td>
                <td><?= number_format($data['doanhthu'], 0, ',', '.') ?></td>
                <td><?= number_format($data['chiphi'], 0, ',', '.') ?></td>
                <td><?= number_format($data['loinhuan'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
