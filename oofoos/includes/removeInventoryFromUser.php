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

if ($_POST["removeQuantity"] <= 0) {
    header('Location: https://adoptapedia.com/oofoos/admin.php?action=inputError');
} else {
    $sql = "SELECT * FROM siteuserInventories, items WHERE siteuserInventories.itemid=items.itemid AND items.name='".$_POST["items"]."' AND siteuserInventories.userid=".$userid.";";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["quantity"] >= $_POST["removeQuantity"]) {
            $sql2 = "UPDATE siteuserInventories SET quantity=".$row['quantity']."-".$_POST["removeQuantity"]." WHERE userid='".$userid."' AND itemid='".$row['itemid']."';";
            $result2 = mysqli_query($conn, $sql2);
            $sqlTransaction = "INSERT INTO `inventorytransactions`(`sendername`, `adminname`, `action`, `transactiondate`, `itemname`, `quantity`, `reason`) VALUES ('".$_POST["usernames"]."','".$_SESSION['user']->getUsername()."','remove','".date("Y-m-d h:i:sa")."','".$_POST["items"]."',".$_POST["removeQuantity"].",'".$_POST["transactionreason"]."');";
            $resultTransaction = mysqli_query($conn, $sqlTransaction);
            header('Location: https://adoptapedia.com/oofoos/admin.php?action=removeInventory&username='.$_POST["usernames"].'&itemname='.$_POST["items"].'&quantity='.$_POST["removeQuantity"]);
        } else {
            header('Location: https://adoptapedia.com/oofoos/admin.php?action=insufficientInventory&username='.$_POST["usernames"].'&itemname='.$_POST["items"].'&quantity='.$_POST["removeQuantity"]);
        }
    } else {
        header('Location: https://adoptapedia.com/oofoos/admin.php?action=insufficientInventory&username='.$_POST["usernames"].'&itemname='.$_POST["items"].'&quantity='.$_POST["removeQuantity"]);
    }
}
CloseCon($conn);
?>
