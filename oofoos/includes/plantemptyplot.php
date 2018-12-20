<?php
require('../../util/User.php');
date_default_timezone_set('US/Eastern');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();

$farmItemId = str_replace("farminginventory","",$_POST["farmItemId"]);
$farmPlotId = str_replace("farmingplot","",$_POST["farmPlotId"]);
$sql = "UPDATE farmPlots SET cropid=".$farmItemId.", cropGrownTime=UNIX_TIMESTAMP()+(SELECT growtime FROM farmItems WHERE itemid=".$farmItemId."), cropWiltedTime=UNIX_TIMESTAMP()+(SELECT wilttime FROM farmItems WHERE itemid=".$farmItemId.") WHERE farmPlotid=".$farmPlotId.";";
$result = mysqli_query($conn, $sql);
$removefarmitemsql = "UPDATE siteuserInventories SET quantity=quantity-1 WHERE userid=".$_SESSION['user']->getID()." AND itemid=".$farmItemId.";";
$removefarmitemresult = mysqli_query($conn, $removefarmitemsql);

$farmPlotResultSql = "SELECT * FROM farmPlots, farmItems WHERE farmPlots.farmPlotid=".$farmPlotId." AND farmPlots.cropid=farmItems.itemid;";
$farmPlotResultResult = mysqli_query($conn, $farmPlotResultSql);
$farmPlotResultRow = mysqli_fetch_assoc($farmPlotResultResult);
echo $farmPlotResultRow['cropGrownTime'].",".$farmPlotResultRow['growingimg'].",".$farmPlotResultRow['grownimg'];
CloseCon($conn);
?>
