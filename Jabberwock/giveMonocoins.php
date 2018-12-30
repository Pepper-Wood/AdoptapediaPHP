<?php
require('../util/User.php');
session_start();
$conn = new mysqli("localhost", "adoptape", "u7w58d3294s", "adoptape_jabberwockdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$debug = False;

$sql = "";
if ($_POST['monocoins'] > 0) {
    $sql = "UPDATE students SET monocoins=monocoins+".$_POST['monocoins']." WHERE studentid=".$_POST['studentid'].";";
} else if ($_POST['monocoins'] < 0) {
    $sql = "UPDATE students SET monocoins=monocoins-".($_POST['monocoins']*(-1))." WHERE studentid=".$_POST['studentid'].";";
}
if ($debug) {
    echo $sql;
} else {
    $result = mysqli_query($conn, $sql);
}

$unixtimestamp = time();

$maxTransLogSql = mysqli_query($conn, "SELECT MAX(transactionid) as maxid FROM transactionhistory;");
$maxTransLogRow = mysqli_fetch_assoc($maxTransLogSql);
$maxTransLogID = $maxTransLogRow['maxid'] + 1;
$transactionhistorysql = "INSERT INTO `banktransactions`(`transactionid`, `timestamp`, `studentid`, `monocoins`, `note`) VALUES (".$maxTransLogID.",".$unixtimestamp.",".$_POST['studentid'].",".$_POST['monocoins'].",'".$_POST['note']."');";
if ($debug) {
    echo $transactionhistorysql;
} else {
    $transactionhistoryresult = mysqli_query($conn, $transactionhistorysql);
}
?>
