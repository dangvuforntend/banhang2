<?php 
include('connect.php');
class data{
    function insert_menu($anh,$ten,$gia){
        global $conn;
        $sql ="insert into menu(anh,ten,gia) values('$anh','$ten','$gia')";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function select_menu(){
        global $conn;
        $sql="select * from menu ";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function delete_menu($id){
        global $conn;
        $sql ="delete from menu where id ='$id'";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function select_menu_id($id){
        global $conn;
        $sql="select * from menu where id ='$id' ";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function update_menu($id,$anh,$ten,$gia){
        global $conn;
        $sql ="update menu set anh='$anh',
                                ten='$ten',
                                gia='$gia'
                                where id='$id'";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
   function insert_cart($img,$name,$price,$quantity){
    global $conn;
    $sql ="insert into cart(img,name,price,quantity) values('$img','$name','$price',$quantity)";
    $run = mysqli_query($conn,$sql);
    return $run;

   }
   function select_cart(){
    global $conn;
    $sql="select * from cart";
    $run = mysqli_query($conn,$sql);
    return $run;
}
function delete_cart($id){
global $conn;
$sql ="delete from cart where id ='$id'";
$run = mysqli_query($conn,$sql);
return $run;
}
function insert_donhang($idkhachhang,$anhmon,$tenmon,$somon,$order_date,$total,$cost,$status){
    global $conn;
    $sql ="insert into donhang(idkhachhang,anhmon,tenmon,somon,order_date,total,cost,status) values('$idkhachhang','$anhmon','$tenmon','$somon','$order_date','$total','$cost','$status')";
    $run = mysqli_query($conn,$sql);
    return $run;
}
function complete_donhang($idkhachhang) {
   global $conn;
    $sql = "UPDATE donhang SET status = 'Đang chờ thanh toán' where idkhachhang='$idkhachhang'";
    $run = mysqli_query($conn,$sql);
    return $run;
}

function select_donhang(){
    global $conn;
    $sql="select * from donhang ";
    $run = mysqli_query($conn,$sql);
    return $run;
}
// Lấy toàn bộ đơn hàng theo idkhachhang
public function select_donhang_by_id($idkhachhang) {
    global$conn;
    $sql = "SELECT * FROM donhang WHERE idkhachhang = '$idkhachhang'";
    $run = mysqli_query($conn,$sql);
    return $run;
}

// Xóa đơn hàng theo idkhachhang

public function delete_donhang_by_idkhachhang($idkhachhang) {
    global$conn;
    $sql = "DELETE FROM donhang WHERE idkhachhang = '$idkhachhang'";
    $run = mysqli_query($conn,$sql);
    return $run;
}
function delete_all_cart(){
    global $conn;
    $sql = "delete from cart";
    $run = mysqli_query($conn, $sql);
    return $run;
}
function delete_donhang($idkhachhang){
    global $conn;
    $sql ="delete from donhang where idkhachhang ='$idkhachhang'";
    $run = mysqli_query($conn,$sql);
    return $run;
    }
function select_donhang_by_idkhachhang($idkhachhang){
    global $conn;
    $sql="select * from donhang where idkhachhang='$idkhachhang' ";
    $run = mysqli_query($conn,$sql);
    return $run;
}
function insert_hoadon($id_khachhang, $tensp, $soluong, $tongtien, $ngaydat, $giasp, $payment_method = null) {
    global $conn;

    if ($payment_method === null || $payment_method === '') {
        // Nếu không có payment_method thì không chèn cột này
        $sql = "INSERT INTO hoadon (id_khachhang, tensp, soluong, tongtien, ngaydat, giasp)
                VALUES ('$id_khachhang', '$tensp', '$soluong', '$tongtien', '$ngaydat', '$giasp')";
    } else {
        // Nếu có thì chèn đầy đủ
        $sql = "INSERT INTO hoadon (id_khachhang, tensp, soluong, tongtien, ngaydat, giasp, payment_method)
                VALUES ('$id_khachhang', '$tensp', '$soluong', '$tongtien', '$ngaydat', '$giasp', '$payment_method')";
    }

    $run = mysqli_query($conn, $sql);
    return $run;
}

    function insert_user($username,$password,$fullname,$phone,$email){
        global $conn;
        $sql ="insert into user(username,password,fullname,phone,email) values('$username','$password','$fullname','$phone','$email')";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function select_user($username,$password) {
        global $conn;
        $sql = "select * from user where username='$username' and password='$password'";
        $run = mysqli_query($conn, $sql);
        return $run;
    }
    function select_all_user(){
        global $conn;
        $sql = "select * from user" ;
        $run = mysqli_query($conn, $sql);
        return $run;
    }
    function delete_user($id){
        global $conn;
        $sql ="delete from user where id ='$id'";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function select_user_id($id){
        global $conn;
        $sql = "select * from user where id ='$id'" ;
        $run = mysqli_query($conn, $sql);
        return $run;
    }
    function update_user($id,$username,$password,$fullname,$phone,$email){
        global $conn;
        $sql = "update user set username='$username',password='$password',fullname='$fullname',phone='$phone',email='$email' where id='$id'" ;
        $run = mysqli_query($conn, $sql);
        return $run;
    }
    function select_hoadon(){
        global $conn;
        $sql = "select * from hoadon" ;
        $run = mysqli_query($conn, $sql);
        return $run;
    }
    function insert_nguyenlieu($ten, $donvi, $gia) {
        global $conn;
        $sql = "INSERT INTO nguyenlieu (ten, donvi, gia) 
                VALUES ('$ten', '$donvi', '$gia')";
        
        $run = mysqli_query($conn, $sql);
        return $run;
    }
    
    function select_nguyenlieu(){
        global $conn;
        $sql="select * from nguyenlieu ";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function insert_congthuc($id_monan,$id_nguyenlieu,$soluong,$donvi){
        global $conn;
        $sql ="insert into congthuc(id_monan,id_nguyenlieu,soluong,donvi) values('$id_monan','$id_nguyenlieu','$soluong','$donvi')";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function select_congthuc(){
        global $conn;
        $sql="select * from congthuc";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function select_congthuc_idmonan($id_monan){
        global $conn;
        $sql="SELECT * FROM congthuc WHERE id_monan='$id_monan'";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    function delete_congthuc($id_monan){
        global $conn;
        $sql="DELETE FROM congthuc WHERE id_monan='$id_monan'";
        $run = mysqli_query($conn,$sql);
        return $run;
    }
    
    
        function delete_nguyenlieu($id){
            global $conn;
            $sql ="delete from nguyenlieu where id ='$id'";
            $run = mysqli_query($conn,$sql);
            return $run;
            }
            function update_nguyenlieu($ten,$donvi,$gia,$id){
                global $conn;
                $sql ="update nguyenlieu set ten='$ten',
                                  
                                       donvi='$donvi',
                                       gia='$gia' where id= '$id'";
                $run = mysqli_query($conn,$sql);
                return $run;
            }
            function select_nguyenlieu_id($id){
                global $conn;
                $sql="select * from nguyenlieu where id='$id' ";
                $run = mysqli_query($conn,$sql);
                return $run;
            }
            function insert_nhapkho($id_nguyenlieu, $soluong, $ngay = null){
                global $conn;
                $sql = "insert into nhapkho (id_nguyenlieu, soluong, ngay) 
                        values ('$id_nguyenlieu', '$soluong', '$ngay')";
                
                $run = mysqli_query($conn, $sql);
                return $run;
            }
        function select_nhapkho(){
                global $conn;
                $sql = "SELECT n.*, nl.ten, nl.donvi, nl.gia 
                        FROM nhapkho n 
                        JOIN nguyenlieu nl ON n.id_nguyenlieu = nl.id";
                $run = mysqli_query($conn, $sql);
                return $run;
            }


        function get_tenmon($id_monan) {
            global $conn;
            $sql = "SELECT ten FROM menu WHERE id = '$id_monan'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            return $row ? $row['ten'] : null;
        }
        
        function get_tennguyenlieu($id_nguyenlieu) {
            global $conn;
            $sql = "SELECT ten FROM nguyenlieu WHERE id = '$id_nguyenlieu'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            return $row ? $row['ten'] : null;
        }
            
}