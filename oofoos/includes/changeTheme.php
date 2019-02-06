<?php
date_default_timezone_set('US/Eastern');
require('../../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();

$sql = "UPDATE siteusers SET styleid=".$_POST["style_id"]." WHERE userid=".$_SESSION['user']->getID().";";
echo $sql;
$result = mysqli_query($conn, $sql);

CloseCon($conn);
?>
