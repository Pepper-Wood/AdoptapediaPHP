<?php
date_default_timezone_set("America/New_York");
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();

if ($_POST["removeQuantity"] <= 0) {
    header('Location: https://adoptapedia.com/SushiDogs/admin.php?action=inputError');
} else {
    $sql = "SELECT * FROM userinventories, items WHERE userinventories.itemid=items.itemid AND items.itemname='".$_POST["items"]."' AND userinventories.username='".$_POST["usernames"]."';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["quantity"] >= $_POST["removeQuantity"]) {
            $sql2 = "UPDATE userinventories SET quantity=".$row['quantity']."-".$_POST["removeQuantity"]." WHERE username='".$_POST["usernames"]."' AND itemid='".$row['itemid']."';";
            $result2 = mysqli_query($conn, $sql2);
            $sqlTransaction = "INSERT INTO `inventorytransactions`(`sendername`, `adminname`, `action`, `transactiondate`, `itemid`, `quantity`, `reason`) VALUES ('".$_POST["usernames"]."','".$_SESSION['user']->getUsername()."','remove','".date("Y-m-d h:i:sa")."',".$row['itemid'].",".$_POST["removeQuantity"].",'".$_POST["transactionreason"]."');";
            $resultTransaction = mysqli_query($conn, $sqlTransaction);
            header('Location: https://adoptapedia.com/SushiDogs/admin.php?action=removeInventory&username='.$_POST["usernames"].'&itemname='.$_POST["items"].'&quantity='.$_POST["removeQuantity"]);
        } else {
            header('Location: https://adoptapedia.com/SushiDogs/admin.php?action=insufficientInventory&username='.$_POST["usernames"].'&itemname='.$_POST["items"].'&quantity='.$_POST["removeQuantity"]);
        }
    } else {
        header('Location: https://adoptapedia.com/SushiDogs/admin.php?action=insufficientInventory&username='.$_POST["usernames"].'&itemname='.$_POST["items"].'&quantity='.$_POST["removeQuantity"]);
    }
}
CloseCon($conn);
?>
