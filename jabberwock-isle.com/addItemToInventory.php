<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenJabberwockCon();

$sql = "SELECT * FROM inventories WHERE ownerid=".$_SESSION['user']->getID()." AND itemid=".$_POST['addItemID'].";";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $updatesql = "UPDATE inventories SET quantity=".$row['quantity']."+".$_POST['addItemQuantity']." WHERE ownerid=".$_SESSION['user']->getID()." AND itemid=".$_POST['addItemID'].";";
    $updateresult = mysqli_query($conn, $updatesql);
} else {
    $insertsql = "INSERT INTO `inventories`(`ownerid`, `quantity`, `itemid`) VALUES (".$_SESSION['user']->getID().",".$_POST['addItemQuantity'].",".$_POST['addItemID'].");";
    $insertresult = mysqli_query($conn, $insertsql);
}

$unixtimestamp = time();

$maxTransLogSql = mysqli_query($conn, "SELECT MAX(transactionid) as maxid FROM transactionhistory;");
$maxTransLogRow = mysqli_fetch_assoc($maxTransLogSql);
$maxTransLogID = $maxTransLogRow['maxid'] + 1;
$transactionhistorysql = "INSERT INTO `transactionhistory`(`transactionid`, `userid`, `timestamp`, `action`, `fullaction`, `quantity`, `itemid`) VALUES (".$maxTransLogID.",".$_SESSION['user']->getID().",".$unixtimestamp.",'add','Added ".$_POST['addItemQuantity']." ".$_POST['addItemname']."',".$_POST['addItemQuantity'].",".$_POST['addItemID'].");";
$transactionhistoryresult = mysqli_query($conn, $transactionhistorysql);

CloseCon($conn);
?>
