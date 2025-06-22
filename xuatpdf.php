<?php
require('tfpdf/tfpdf.php');
include('control.php');
$get_data = new data();

$thang = isset($_GET['thang']) ? $_GET['thang'] : date('Y-m');

$pdf = new tFPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Thêm và dùng font DejaVuSansCondensed
$pdf->AddFont('DejaVu','','DejaVuSans.ttf',true);
$pdf->SetFont('DejaVu', '', 14);
$pdf->Cell(0, 10, "BÁO CÁO DOANH THU - Tháng $thang", 0, 1, 'C');
$pdf->Ln(5);

// Header bảng
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(40, 10, 'Ngày', 1);
$pdf->Cell(40, 10, 'Số đơn hàng', 1);
$pdf->Cell(50, 10, 'Số món đã bán', 1);
$pdf->Cell(60, 10, 'Doanh thu (VND)', 1);
$pdf->Ln();

$result = $get_data->select_hoadon();

$doanhthu_theongay = [];

$tong_don = 0;
$tong_monan = 0;
$tong_doanhthu = 0;
$tong_tien_chuyenkhoan = 0;
$tong_tien_tienmat = 0;

while ($row = mysqli_fetch_assoc($result)) {
    if (substr($row['ngaydat'], 0, 7) === $thang) {
        $ngay = $row['ngaydat'];
        $soluong = (int)$row['soluong'];
        $gia = (float)$row['giasp'];
        $payment = $row['payment_method']; // Giả sử có cột này

        if (!isset($doanhthu_theongay[$ngay])) {
            $doanhthu_theongay[$ngay] = ['don' => 0, 'mon' => 0, 'tien' => 0];
        }

        $doanhthu_theongay[$ngay]['don'] += 1;
        $doanhthu_theongay[$ngay]['mon'] += $soluong;
        $doanhthu_theongay[$ngay]['tien'] += $soluong * $gia;

        $tong_don++;
        $tong_monan += $soluong;
        $tong_doanhthu += $soluong * $gia;

        if ($payment === 'Chuyển khoản') {
            $tong_tien_chuyenkhoan += $soluong * $gia;
        } elseif ($payment === 'Tiền mặt') {
            $tong_tien_tienmat += $soluong * $gia;
        }
    }
}

// In dữ liệu
$pdf->SetFont('DejaVu', '', 12);
foreach ($doanhthu_theongay as $ngay => $val) {
    $pdf->Cell(40, 10, $ngay, 1);
    $pdf->Cell(40, 10, $val['don'], 1);
    $pdf->Cell(50, 10, $val['mon'], 1);
    $pdf->Cell(60, 10, number_format($val['tien'], 0), 1);
    $pdf->Ln();
}

$pdf->Ln(5);
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(0, 10, "Tổng đơn: $tong_don - Tổng món: $tong_monan - Tổng doanh thu: " . number_format($tong_doanhthu, 0) . " VND", 0, 1);
$pdf->Cell(0, 10, "Tổng tiền mặt: " . number_format($tong_tien_tienmat, 0) . " VND", 0, 1);
$pdf->Cell(0, 10, "Tổng chuyển khoản: " . number_format($tong_tien_chuyenkhoan, 0) . " VND", 0, 1);

$pdf->Output('I', 'baocao_doanhthu.pdf');
?>
