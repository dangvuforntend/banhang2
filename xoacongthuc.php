<?php 
include ('control.php');
$get_data = new data();
$delete = $get_data->delete_congthuc($_GET['id_monan']);
if($delete){
    header("location:hienthicongthuc.php");
}
else{
    echo"not delete";
}
?>