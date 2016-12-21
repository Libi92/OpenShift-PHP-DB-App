<?php
require_once('conn.php');
$idp= $_REQUEST['id'];
$un= $_POST['username'];
$pd= $_POST['psd'];
mysqli_query($conn, "UPDATE tbllogin SET username='$un',psd='$pd' where id=$idp");
header("location:home.php?action");
?>