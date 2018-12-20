<?php
require('../../util/User.php');
date_default_timezone_set('US/Eastern');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();

$farmPlotId = str_replace("farmingplot","",$_POST["farmPlotId"]);
$plotsql = "SELECT * FROM farmPlots WHERE farmPlotId=".$farmPlotId;
$plotresult = mysqli_query($conn, $plotsql);
if (mysqli_num_rows($plotresult) > 0) {
    $plotrow = mysqli_fetch_assoc($plotresult);

    $resetplotsql = "UPDATE farmPlots SET cropid=0, cropGrownTime=0, cropWiltedTime=0 WHERE farmPlotId=".$farmPlotId;
    if (time() <= $plotrow['cropWiltedTime']) {
        // code from addInventoryToUser.php
        $useridsql = "SELECT * FROM siteusers WHERE username='".$_POST["usernames"]."';";
        $useridresult = mysqli_query($conn, $useridsql);
        $useridrow = $useridresult->fetch_assoc();
        $userid = $useridrow['userid'];

        $additemsql = "SELECT * FROM siteuserInventories, farmItems WHERE farmItems.resultid=siteuserInventories.itemid AND farmItems.itemid=".$plotrow['cropid']." AND siteuserInventories.userid=".$_SESSION['user']->getID().";";
        $additemresult = mysqli_query($conn, $additemsql);
        $resultid = 0;
        $resultquantity = 0;
        if (mysqli_num_rows($additemresult) > 0) {
            $additemrow = mysqli_fetch_assoc($additemresult);
            $updateadditemsql = "UPDATE siteuserInventories SET quantity=".$additemrow['quantity']."+".$additemrow['resultquantity']." WHERE userid=".$_SESSION['user']->getID()." AND itemid=".$additemrow['resultid'].";";
            $updateadditemresult = mysqli_query($conn, $updateadditemsql);
            $resultid = $additemrow['resultid'];
            $resultquantity = $additemrow['resultquantity'];
        } else {
            $insertresultsql = "SELECT resultid FROM farmItems, farmPlots WHERE farmItems.itemid=farmPlots.cropid AND farmPlots.farmPlotid=".$farmPlotId."";
            $insertresultresult = mysqli_query($conn, $insertresultsql);
            $insertresultrow = mysqli_fetch_assoc($insertresultresult);

            $insertadditemsql = "INSERT INTO `siteuserInventories`(`userid`, `itemid`, `quantity`) VALUES (".$_SESSION['user']->getID().",".$insertresultrow['resultid'].",".$insertresultrow['resultquantity'].");";
            $insertadditemresult = mysqli_query($conn, $insertadditemsql);

            $resultid = $insertresultrow['resultid'];
            $resultquantity = $insertresultrow['resultquantity'];
        }

        $resultnamesql = "SELECT * FROM items WHERE itemid=".$resultid.";";
        $resultnameresult = mysqli_query($conn, $resultnamesql);
        $resultnamerow = mysqli_fetch_assoc($resultnameresult);
        $resultname = $resultnamerow['name'];

        $sqlTransaction = "INSERT INTO `inventorytransactions`(`sendername`, `adminname`, `action`, `transactiondate`, `itemname`, `quantity`, `reason`) VALUES ('".$_SESSION['user']->getUsername()."','".$_SESSION['user']->getUsername()."','farm','".date("Y-m-d h:i:sa")."','itemid=".$resultname."',".$resultquantity.",'Obtained from farming');";
        $resultTransaction = mysqli_query($conn, $sqlTransaction);
        $resetplotresult = mysqli_query($conn, $resetplotsql);

        echo "REAPED,".$resultquantity.",".$resultname;
    } elseif (time() > $plotrow['cropWiltedTime']) {
        $resetplotresult = mysqli_query($conn, $resetplotsql);
        echo "WILTED";
    }
}
CloseCon($conn);
?>
