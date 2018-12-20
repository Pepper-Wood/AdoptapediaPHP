<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenJabberwockCon();

$sql = "DELETE FROM messages WHERE userid=".$_SESSION['user']->getID().";";
$result = mysqli_query($conn, $sql);

CloseCon($conn);
?>
