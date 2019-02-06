<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenJabberwockCon();

$sql = "UPDATE siteusersettings SET timezone='".$_POST['newtimezone']."' WHERE userid=".$_SESSION['user']->getID().";";
$result = mysqli_query($conn, $sql);

CloseCon($conn);
?>
