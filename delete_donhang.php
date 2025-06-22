<?php
include 'control.php';
$get_data = new data();

// Kiểm tra nếu tham số 'huy' có trong URL và hợp lệ (là số)
if (isset($_GET['huy']) && is_numeric($_GET['huy'])) {
    $idkhachhang = $_GET['huy']; // Lấy giá trị 'huy' từ URL

    // Gọi hàm xóa đơn hàng
    $delete = $get_data->delete_donhang($idkhachhang);

    if ($delete) {
        // Nếu xóa thành công, chuyển hướng về trang donhang.php
        header("Location: donhang.php");
        exit(); // Đảm bảo dừng thực thi script sau khi chuyển hướng
    } else {
        echo "Không thể xóa đơn hàng. Vui lòng thử lại.";
    }
} else {
    echo "ID khách hàng không hợp lệ hoặc không có tham số 'huy'.";
}
?>
