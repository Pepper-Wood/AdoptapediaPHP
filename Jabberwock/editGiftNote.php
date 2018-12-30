<?php
require('../util/User.php');
session_start();
$conn = new mysqli("localhost", "adoptape", "u7w58d3294s", "adoptape_jabberwockdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$giftID = str_replace("gift","",$_POST['giftid']);
$studentid = $_POST['studentid'];
$newGiftNote = mysqli_real_escape_string($conn, $_POST['newgiftnote']);
$sql = "UPDATE giftsinventories SET note='$newGiftNote',studentid=".$studentid." WHERE userid=".$_SESSION['user']->getID()." AND giftid=".$giftID.";";
$result = mysqli_query($conn, $sql);

?>
