<?php 
include('control.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');
require('tfpdf/tfpdf.php');

$get_data = new data();
$cart_items = $get_data->select_cart();

// Bước 1: Lấy nguyên liệu
$nguyenlieu_conlai = []; 
$select_nguyenlieu = $get_data->select_nguyenlieu();
foreach($select_nguyenlieu as $nl){
    $id_nl = $nl['id'];
    $nguyenlieu_conlai[$id_nl] = [
        'donvi' => $nl['donvi'],
        'gia' => $nl['gia'],
        'soluong' => 0
    ];
}

// Bước 2: Nhập kho
$select_nhapkho = $get_data->select_nhapkho();
foreach ($select_nhapkho as $nk) {
    $id_nl = $nk['id_nguyenlieu'];
    $soluong_nhap = (float)$nk['soluong'];
    if (isset($nguyenlieu_conlai[$id_nl])) {
        $nguyenlieu_conlai[$id_nl]['soluong'] += $soluong_nhap;
    } else {
        $nguyenlieu_conlai[$id_nl] = ['soluong' => $soluong_nhap, 'donvi' => '', 'gia' => 0];
    }
}

// Bước 3: Map món
$select = $get_data->select_menu();
$map_tenmon_to_id = [];
foreach ($select as $mon) {
    $map_tenmon_to_id[$mon['ten']] = $mon['id'];
}

// Bước 4: Món đã bán
$mon_ban_raw = $get_data->select_hoadon();
$mon_ban = [];
foreach ($mon_ban_raw as $row) {
    $tensp = $row['tensp'];
    $soluong = $row['soluong'];
    if (isset($map_tenmon_to_id[$tensp])) {
        $id_monan = $map_tenmon_to_id[$tensp];
        if (!isset($mon_ban[$id_monan])) {
            $mon_ban[$id_monan] = 0;
        }
        $mon_ban[$id_monan] += $soluong;
    }
}

// Bước 5: Công thức
$congthuc_list = $get_data->select_congthuc();
$nguyenlieu_dadung = [];
foreach ($congthuc_list as $ct) {
    $id_monan = $ct['id_monan'];
    $id_nl = $ct['id_nguyenlieu'];
    $sluong_ct = (float)$ct['soluong'];
    if (isset($mon_ban[$id_monan])) {
        $somon_ban = $mon_ban[$id_monan];
        $tongdung = $somon_ban * $sluong_ct;
        if (!isset($nguyenlieu_dadung[$id_nl])) {
            $nguyenlieu_dadung[$id_nl] = 0;
        }
        $nguyenlieu_dadung[$id_nl] += $tongdung;
    }
}

// Bước 6: Kiểm tra đủ nguyên liệu
function check_if_item_has_enough_ingredients($id_monan, $quantity, $congthuc_list, $nguyenlieu_conlai, $nguyenlieu_dadung) {
    foreach ($congthuc_list as $ct) {
        if ($ct['id_monan'] == $id_monan) {
            $id_nl = $ct['id_nguyenlieu'];
            $sluong_can = (float)$ct['soluong'] * $quantity;
            $da_dung = isset($nguyenlieu_dadung[$id_nl]) ? $nguyenlieu_dadung[$id_nl] : 0;
            $con_lai = isset($nguyenlieu_conlai[$id_nl]) ? $nguyenlieu_conlai[$id_nl]['soluong'] - $da_dung : 0;
            if ($con_lai < $sluong_can) return false;
        }
    }
    return true;
}

$error_message = '';

// Bước 7: Thêm vào giỏ
if(isset($_POST['add_to_cart'])) {
    $img = $_POST['product_img'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $quantity = $_POST['product_quantity'];
    $id_monan = $_POST['product_id'];

    if (check_if_item_has_enough_ingredients($id_monan, $quantity, $congthuc_list, $nguyenlieu_conlai, $nguyenlieu_dadung)) {
        $insert = $get_data->insert_cart($img, $name, $price, $quantity);
        if ($insert) {
            header("Location: index.html.php");
            exit();
        }
    } else {
        $error_message = "Không đủ nguyên liệu cho số lượng đã chọn. Vui lòng giảm số lượng hoặc chọn món khác!";
    }
}

// Bước 8: Thanh toán
if (isset($_POST['tienmat'])) {
    $cart_items = $get_data->select_cart();

    // Tính tổng số lượng sản phẩm trong giỏ hàng
    $total_quantity = 0;
    foreach ($cart_items as $item) {
        $total_quantity += (int)$item['quantity'];
    }

    if ($total_quantity == 0) {
        $error_message = "Giỏ hàng đang trống. Vui lòng chọn ít nhất 1 món !";
    } else {
        $idkhachhang = substr(time(), -3) . rand(10, 99);
        $orderdate = date('d/m/Y H:i:s');
        $orderdate_db = date('Y-m-d H:i:s');
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        foreach ($cart_items as $item) {
            $get_data->insert_donhang(
                $idkhachhang,
                $item['img'],
                $item['name'],
                $item['quantity'],
                $orderdate_db,
                $total,
                $item['price'],
                "đang xử lý "
            );
        }

        // Tạo PDF
        $pdf = new tFPDF();
        $pdf->AddPage();
        $pdf->AddFont('DejaVu', '', 'DejaVuSans.ttf', true);
        $pdf->SetFont('DejaVu','',16);
        $pdf->Cell(0, 10, 'HÓA ĐƠN BÁN HÀNG', 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('DejaVu','',12);
        $pdf->Cell(0, 10, 'Mã khách hàng: ' . $idkhachhang, 0, 1);
        $pdf->Cell(0, 10, 'Ngày đặt: ' . $orderdate, 0, 1);
        $pdf->Ln(5);
        $pdf->Cell(80, 10, 'Tên món', 1);
        $pdf->Cell(30, 10, 'Số lượng', 1);
        $pdf->Cell(40, 10, 'Giá món', 1);
        $pdf->Cell(40, 10, 'Thành tiền', 1, 1);

        foreach ($cart_items as $item) {
            $thanhtien = $item['price'] * $item['quantity'];
            $pdf->Cell(80, 10, $item['name'], 1);
            $pdf->Cell(30, 10, $item['quantity'], 1, 0, 'C');
            $pdf->Cell(40, 10, number_format($item['price'], 0, ',', '.') . 'đ', 1, 0, 'R');
            $pdf->Cell(40, 10, number_format($thanhtien, 0, ',', '.') . 'đ', 1, 1, 'R');
        }

        $pdf->Cell(150, 10, 'Tổng cộng:', 0, 0, 'R');
        $pdf->Cell(40, 10, number_format($total, 0, ',', '.') . 'đ', 1, 1, 'R');
        $pdf->Ln(10);
        $pdf->SetFont('DejaVu','',11);
        $pdf->Cell(0, 10, 'Quý khách chú ý: Nhân viên sẽ gọi theo mã khách hàng để nhận món.', 0, 1, 'C');
        


        $pdf_filename = 'hoadon_' . $idkhachhang . '.pdf';
        $pdf->Output('F', 'upload/' . $pdf_filename);

        $get_data->delete_all_cart();

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($pdf_filename) . '"');
        readfile('upload/' . $pdf_filename);
        exit();
    }
}
?>

<!-- HTML hiển thị -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Menu & Giỏ Hàng</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>
<div class="container">
<?php if (!empty($error_message)): ?>
    <script>alert("<?php echo addslashes($error_message); ?>");</script>
<?php endif; ?>

<div class="menu-container">
<?php foreach($select as $a): ?>
    <?php
    $has_enough_ingredients = check_if_item_has_enough_ingredients($a['id'], 1, $congthuc_list, $nguyenlieu_conlai, $nguyenlieu_dadung);
    ?>
    <div class="item">
        <form method="POST">
            <img src="upload/<?php echo $a['anh']; ?>">
            <input type="hidden" name="product_img" value="<?php echo $a['anh']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $a['id']; ?>">
            <h3><?php echo $a['ten']; ?></h3>
            <p><?php echo number_format($a['gia'], 0, ',', '.'); ?>đ</p>
            <input type="hidden" name="product_name" value="<?php echo $a['ten']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $a['gia']; ?>">
            <input type="number" name="product_quantity" value="1" min="1">
            <button type="submit" name="add_to_cart" <?php echo $has_enough_ingredients ? '' : 'disabled'; ?>>
                Chọn
            </button>
            <?php if (!$has_enough_ingredients): ?>
                <p style="color:red;font-size:12px;">Hết nguyên liệu, chọn món khác!</p>
            <?php endif; ?>
        </form>
    </div>
<?php endforeach; ?>
</div>

<div class="cart">
    <h2>🛒 Giỏ hàng</h2>
    <?php 
    $total = 0;
    foreach($cart_items as $item): 
        $item_total = $item['price'] * $item['quantity'];
        $total += $item_total;
    ?>
        <div class="cart-item">
            <img src="upload/<?php echo $item['img']; ?>" class="cart-img">
            <span class="cart-name"><?php echo $item['name']; ?></span>
            <span class="cart-price"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</span>
            <span class="cart-quantity">x<?php echo $item['quantity']; ?></span>
            <a href="delete.php?del=<?php echo $item['id']; ?>" class="delete-btn">Xóa</a>
        </div>
    <?php endforeach; ?>

    <div class="cart-total">
        <h3>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?>đ</h3>
    </div>

    <form method="POST">
        <button type="submit" name="tienmat" class="checkout-btn">Mua hàng</button>
    </form>
</div>
</div>
</body>
</html>