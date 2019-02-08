<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenJabberwockCon();

$debug = FALSE;

$deletesql = "DELETE FROM studentwishlist WHERE studentid=".$_POST['studentid']." AND itemid=".$_POST['itemid'].";";
if ($debug) {
    echo $deletesql;
} else {
    $result = mysqli_query($conn, $deletesql);
}

$insertsql = "INSERT INTO `studentwishlist`(`studentid`, `itemid`, `desire`) VALUES (".$_POST['studentid'].",".$_POST['itemid'].",'".$_POST['desire']."');";
if ($debug) {
    echo $insertsql;
} else {
    $result = mysqli_query($conn, $insertsql);
}

CloseCon($conn);
?>
