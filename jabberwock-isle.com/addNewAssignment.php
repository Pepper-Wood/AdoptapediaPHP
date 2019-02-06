<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenJabberwockCon();

$sql = "INSERT INTO `assignments`(`ownerid`, `recipeid`) VALUES (".$_SESSION['user']->getID().",".$_POST['newAssignmentID'].");";
$result = mysqli_query($conn, $sql);

CloseCon($conn);
?>
