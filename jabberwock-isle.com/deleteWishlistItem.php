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

CloseCon($conn);
?>
