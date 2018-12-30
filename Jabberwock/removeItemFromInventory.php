<?php
require('../util/User.php');
session_start();
$conn = new mysqli("localhost", "adoptape", "u7w58d3294s", "adoptape_jabberwockdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM inventories WHERE ownerid=".$_SESSION['user']->getID()." AND itemid=".$_POST['removeItemID'].";";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) <= 0) {
    echo "You do not have ".$_POST['removeItemQuantity']." ".$_POST['removeItemname']." to remove";
} else {
    $row = mysqli_fetch_assoc($result);
    if ($row['quantity'] < $_POST['removeItemQuantity']) {
        echo "You do not have ".$_POST['removeItemQuantity']." ".$_POST['removeItemname']." to remove";
    } else {
        $updatesql = "UPDATE inventories SET quantity=".$row['quantity']."-".$_POST['removeItemQuantity']." WHERE ownerid=".$_SESSION['user']->getID()." AND itemid=".$_POST['removeItemID'].";";
        $updateresult = mysqli_query($conn, $updatesql);

        $unixtimestamp = time();

        $maxTransLogSql = mysqli_query($conn, "SELECT MAX(transactionid) as maxid FROM transactionhistory;");
        $maxTransLogRow = mysqli_fetch_assoc($maxTransLogSql);
        $maxTransLogID = $maxTransLogRow['maxid'] + 1;
        $transactionhistorysql = "INSERT INTO `transactionhistory`(`transactionid`, `userid`, `timestamp`, `action`, `fullaction`, `quantity`, `itemid`) VALUES (".$maxTransLogID.",".$_SESSION['user']->getID().",".$unixtimestamp.",'remove','Removed ".$_POST['removeItemQuantity']." ".$_POST['removeItemname']."',".$_POST['removeItemQuantity'].",".$_POST['removeItemID'].");";
        $transactionhistoryresult = mysqli_query($conn, $transactionhistorysql);
        echo "SUCCESS";
    }
}
?>
