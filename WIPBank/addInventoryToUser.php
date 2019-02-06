<?php
require('../util/User.php');
session_start();
date_default_timezone_set("America/New_York");
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();

if ($_POST["addQuantity"] <= 0) {
    header('Location: https://adoptapedia.com/SushiDogs/admin.php?action=inputError');
} else {
    $sql = "SELECT * FROM userinventories, items WHERE userinventories.itemid=items.itemid AND items.itemname='".$_POST["items"]."' AND userinventories.username='".$_POST["usernames"]."';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sql2 = "UPDATE userinventories SET quantity=".$row['quantity']."+".$_POST["addQuantity"]." WHERE username='".$_POST["usernames"]."' AND itemid='".$row['itemid']."';";
        $result2 = mysqli_query($conn, $sql2);

        $sqlTransaction = "INSERT INTO `inventorytransactions`(`sendername`, `adminname`, `action`, `transactiondate`, `itemid`, `quantity`, `reason`) VALUES ('".$_POST["usernames"]."','".$_SESSION['user']->getUsername()."','add','".date("Y-m-d h:i:sa")."',".$row['itemid'].",".$_POST["addQuantity"].",'".$_POST["transactionreason"]."');";
        $resultTransaction = mysqli_query($conn, $sqlTransaction);
    } else {
        $sql2 = "SELECT itemid FROM items WHERE itemname='".$_POST["items"]."';";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $sql3 = "INSERT INTO `userinventories`(`username`, `itemid`, `quantity`) VALUES ('".$_POST["usernames"]."',".$row2['itemid'].",".$_POST["addQuantity"].");";
        $result3 = mysqli_query($conn, $sql3);

        $sqlTransaction = "INSERT INTO `inventorytransactions`(`sendername`, `adminname`, `action`, `transactiondate`, `itemid`, `quantity`, `reason`) VALUES ('".$_POST["usernames"]."','".$_SESSION['user']->getUsername()."','add','".date("Y-m-d h:i:sa")."',".$row2['itemid'].",".$_POST["addQuantity"].",'".$_POST["transactionreason"]."');";
        $resultTransaction = mysqli_query($conn, $sqlTransaction);
    }

    header('Location: https://adoptapedia.com/SushiDogs/admin.php?action=addInventory&username='.$_POST["usernames"].'&itemname='.$_POST["items"].'&quantity='.$_POST["addQuantity"]);
}

CloseCon($conn);
?>
