<?php
require('../../util/User.php');
session_start();
date_default_timezone_set("America/New_York");
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();

$useridsql = "SELECT * FROM siteusers WHERE username='".$_POST["usernames"]."';";
$useridresult = mysqli_query($conn, $useridsql);
$useridrow = $useridresult->fetch_assoc();
$userid = $useridrow['userid'];

if ($_POST["addQuantity"] <= 0) {
    header('Location: https://adoptapedia.com/oofoos/admin.php?action=inputError');
} else {
    $sql = "SELECT * FROM siteuserInventories, siteusers, items WHERE siteuserInventories.itemid=items.itemid AND items.name='".$_POST["items"]."' AND siteusers.userid=siteuserInventories.userid AND siteusers.username='".$_POST["usernames"]."';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sql2 = "UPDATE siteuserInventories SET quantity=".$row['quantity']."+".$_POST["addQuantity"]." WHERE userid='".$userid."' AND itemid='".$row['itemid']."';";
        $result2 = mysqli_query($conn, $sql2);
    } else {
        $sql2 = "SELECT itemid FROM items WHERE name='".$_POST["items"]."';";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $sql3 = "INSERT INTO `siteuserInventories`(`userid`, `itemid`, `quantity`) VALUES (".$userid.",".$row2['itemid'].",".$_POST["addQuantity"].");";
        $result3 = mysqli_query($conn, $sql3);
    }

    $sqlTransaction = "INSERT INTO `inventorytransactions`(`sendername`, `adminname`, `action`, `transactiondate`, `itemname`, `quantity`, `reason`) VALUES ('".$_POST["usernames"]."','".$_SESSION['user']->getUsername()."','add','".date("Y-m-d h:i:sa")."','".$_POST["items"]."',".$_POST["addQuantity"].",'".$_POST["transactionreason"]."');";
    $resultTransaction = mysqli_query($conn, $sqlTransaction);

    header('Location: https://adoptapedia.com/oofoos/admin.php?action=addInventory&username='.$_POST["usernames"].'&itemname='.$_POST["items"].'&quantity='.$_POST["addQuantity"]);
}

CloseCon($conn);
?>
