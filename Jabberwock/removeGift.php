<?php
require('../util/User.php');
session_start();
$conn = new mysqli("localhost", "adoptape", "u7w58d3294s", "adoptape_jabberwockdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$debug = False;

$giftID = str_replace("gift","",$_POST['giftid']);

$giftSql = mysqli_query($conn, "SELECT itemid FROM giftsinventories WHERE giftid=".$giftID.";");
$giftRow = mysqli_fetch_assoc($giftSql);
$itemid = $giftRow['itemid'];
if ($debug) {
    echo "itemid - ".$itemid." ---";
}

$itemsql = mysqli_query($conn, "SELECT itemname FROM items WHERE itemid=".$itemid.";");
$itemrow = mysqli_fetch_assoc($itemsql);
$itemname = $itemrow['itemname'];
if ($debug) {
    echo "itemname - ".$itemname." ---";
}

$sql = "DELETE FROM giftsinventories WHERE userid=".$_SESSION['user']->getID()." AND giftid=".$giftID.";";
if ($debug) {
    echo $sql;
} else {
    $result = mysqli_query($conn, $sql);
}

$updatesql = "UPDATE inventories SET quantity=quantity-1 WHERE ownerid=".$_SESSION['user']->getID()." AND itemid=".$itemid.";";
if ($debug) {
    echo $updatesql;
} else {
    $updateresult = mysqli_query($conn, $updatesql);
}

$unixtimestamp = time();

$maxTransLogSql = mysqli_query($conn, "SELECT MAX(transactionid) as maxid FROM transactionhistory;");
$maxTransLogRow = mysqli_fetch_assoc($maxTransLogSql);
$maxTransLogID = $maxTransLogRow['maxid'] + 1;
$transactionhistorysql = "INSERT INTO `transactionhistory`(`transactionid`, `userid`, `timestamp`, `action`, `fullaction`, `quantity`, `itemid`) VALUES (".$maxTransLogID.",".$_SESSION['user']->getID().",".$unixtimestamp.",'remove','Removed 1 ".$itemname."',1,".$itemid.");";
if ($debug) {
    echo $transactionhistorysql;
} else {
    $transactionhistoryresult = mysqli_query($conn, $transactionhistorysql);
}

?>
