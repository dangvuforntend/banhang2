<?php 
include ('control.php');
$get_data = new data();
$delete = $get_data->delete_nguyenlieu($_GET['id']);
if($delete){
    header("location:capnhat_nguyenlieu.php");
}
else{
    echo"not delete";
}
?>