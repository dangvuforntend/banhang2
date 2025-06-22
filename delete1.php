<?php 
include ('control.php');
$get_data = new data();
$delete = $get_data->delete_menu($_GET['xoa']);
if($delete){
    header(("location:edit_product.php"));
}
else{
    echo"not delete";
}
?>