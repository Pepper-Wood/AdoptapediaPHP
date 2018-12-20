<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenJabberwockCon();

$giftID = str_replace("gift","",$_POST['giftid']);
$studentid = $_POST['studentid'];
$newGiftNote = mysqli_real_escape_string($conn, $_POST['newgiftnote']);
$sql = "UPDATE giftsinventories SET note='$newGiftNote',studentid=".$studentid." WHERE userid=".$_SESSION['user']->getID()." AND giftid=".$giftID.";";
$result = mysqli_query($conn, $sql);

CloseCon($conn);
?>
