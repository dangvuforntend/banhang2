<?php 
include ('control.php');
$get_data = new data();
$delete = $get_data->delete_user($_GET['id']);
if($delete){
    header("location:editnv.php");
}
else{
    echo"not delete";
}
?>