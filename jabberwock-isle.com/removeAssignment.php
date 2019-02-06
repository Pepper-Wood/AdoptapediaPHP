<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenJabberwockCon();

$sql = "DELETE FROM assignments WHERE ownerid=".$_SESSION['user']->getID()." AND recipeid=".$_POST['removeAssignmentID']." LIMIT 1;";
$result = mysqli_query($conn, $sql);

CloseCon($conn);
?>
