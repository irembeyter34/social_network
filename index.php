<?php
$con = mysqli_connect("localhost","root","","social");
if(mysqli_connect_errno()){
    echo "Failed :". mysqli_connect_errno();
}
$query = mysqli_query($con,"INSERT INTO test VALUES('','Irem')");


?>