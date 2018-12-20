<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenJabberwockCon();

$debug = False;

$sql = "UPDATE siteusersettings SET monocoins=monocoins+(".$_POST['monocoins'].") WHERE userid=".$_POST['userid'].";";
if ($debug) {
    echo $sql;
} else {
    $result = mysqli_query($conn, $sql);
}

$studentidsql = mysqli_query($conn, "SELECT mainstudentid FROM siteusersettings WHERE userid=".$_POST['userid'].";");
$studentidrow = mysqli_fetch_assoc($studentidsql);
$studentid = $studentidrow['mainstudentid'];

$unixtimestamp = time();

$maxTransLogSql = mysqli_query($conn, "SELECT MAX(transactionid) as maxid FROM banktransactions;");
$maxTransLogRow = mysqli_fetch_assoc($maxTransLogSql);
$maxTransLogID = $maxTransLogRow['maxid'] + 1;
$transactionhistorysql = "INSERT INTO `banktransactions`(`transactionid`, `timestamp`, `userid`, `studentid`, `monocoins`, `battleForTheBank`, `note`) VALUES (".$maxTransLogID.",".$unixtimestamp.",".$_POST['userid'].",".$studentid.",".$_POST['monocoins'].",".$_POST['battleForTheBank'].",'".$_POST['note']."');";
if ($debug) {
    echo $transactionhistorysql;
} else {
    $transactionhistoryresult = mysqli_query($conn, $transactionhistorysql);
}

CloseCon($conn);
?>
