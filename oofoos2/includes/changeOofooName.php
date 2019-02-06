<?php
date_default_timezone_set('US/Eastern');
require('../../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();

$sql = "UPDATE oofooPCs SET name='".$_POST["newOofooName"]."' WHERE userid=".$_SESSION['user']->getID()." AND oofooid=".$_POST["oofooID"].";";
$result = mysqli_query($conn, $sql);
header('Location: https://adoptapedia.com/oofoos/oofooProfile.php?id='.$_POST["oofooID"].'&action=nameChange');
CloseCon($conn);
?>
