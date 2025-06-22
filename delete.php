<?php 
include ('control.php');
$get_data = new data();
$delete = $get_data->delete_cart($_GET['del']);
if($delete){
    header("location:index.html.php");
}
else{
    echo"not delete";
}
?>