<?php
date_default_timezone_set('US/Eastern');
require('../../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();

function getQuantity() {
    $quantityRoll = rand(1,20);
    if (($quantityRoll >= 1) && ($quantityRoll <= 5)) {
        return 1;
    } else if (($quantityRoll >= 6) && ($quantityRoll <= 10)) {
        return 2;
    } else if (($quantityRoll >= 11) && ($quantityRoll <= 15)) {
        return 3;
    } else if (($quantityRoll >= 16) && ($quantityRoll <= 19)) {
        return 4;
    } else {
        return 5;
    }
}

function getRankBonus() {
    global $oofooid, $conn;
    $getGatheringExpSql = mysqli_query($conn, "SELECT * FROM oofooPCs WHERE oofooid=".$oofooid.";");
    $currGatheringExp = mysqli_fetch_assoc($getGatheringExpSql)['gatheringexp'];
    $tiersql = "SELECT * FROM `dailyExpTiers` ORDER BY tierId;";
    $tierresult = mysqli_query($conn, $tiersql);
    while ($tierrow = mysqli_fetch_assoc($tierresult)) {
        if ($currGatheringExp >= $tierrow['tierExpNeeded']) {
            $currGatheringExp -= $tierrow['tierExpNeeded'];
        } else {
            return $tierrow['tierId'];
        }
    }
    $maxsql = "SELECT MAX(tierId) AS max_id FROM dailyExpTiers;";
    $maxsqlqry = mysqli_query($conn, $maxsql);
    $maxsqlrow = mysqli_fetch_assoc($maxsqlqry);
    return $maxsqlrow["max_id"];
}

function getGatheringItem($conn, $quantity, $rarity, $location) {
    global $oofooid;
    $sql = "SELECT gatherItems.itemid as itemid, items.name as itemname FROM gatherItems, rarities, items WHERE gatherItems.rarityid=rarities.rarityid AND gatherItems.itemid=items.itemid AND rarities.rarityname=\"".$rarity."\" AND gatherItems.location=\"".$location."\";";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $rowNum = rand(0,mysqli_num_rows($result)-1);
        $counter = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($counter == $rowNum) {
                echo "itemid:".$row["itemid"].", quantity:".$quantity.", itemname:".$row["itemname"].", ";
                // Check if user already exists in siteusers
                $inventoryQry = "SELECT * FROM siteuserInventories WHERE userid=".$_SESSION['user']->getID()." AND itemid=".$row["itemid"].";";
                $inventoryResult = mysqli_query($conn, $inventoryQry);
                if (mysqli_num_rows($inventoryResult) > 0) {
                    $inventoryQry2 = "UPDATE siteuserInventories SET quantity=quantity+".$quantity." WHERE userid=".$_SESSION['user']->getID()." AND itemid=".$row["itemid"].";";
                    $inventoryResult2 = mysqli_query($conn, $inventoryQry2);
                } else {
                    $inventoryQry2 = "INSERT INTO siteuserInventories(userid, itemid, quantity) VALUES(".$_SESSION['user']->getID().",".$row["itemid"].",".$quantity.");";
                    $inventoryResult2 = mysqli_query($conn, $inventoryQry2);
                }
                $addGatheringExp = 10;
                if ($rarity == "common") {
                    $addGatheringExp = 10;
                } else if ($rarity == "uncommon") {
                    $addGatheringExp = 15;
                } else if ($rarity == "rare") {
                    $addGatheringExp = 25;
                }
                echo "exp:".$addGatheringExp;
                $updateGatherExpQry = "UPDATE oofooPCs SET gatheringexp=gatheringexp+".$addGatheringExp." WHERE oofooid=".$oofooid.";";
                $updateGatherExpResult = mysqli_query($conn, $updateGatherExpQry);
                $counter++;
            } else if ($counter < $rowNum) {
                $counter++;
            }
        }
    } else {
        echo "itemid:null";
    }
}

$location = $_POST["location"];
$oofooid = $_POST["oofoo_id"];

$today = date("Y-m-d");
$updateGatherQry = "UPDATE oofooPCs SET lastGathered='".$today."' WHERE oofooid=".$oofooid.";";
$updateGatherResult = mysqli_query($conn, $updateGatherQry);

$statusRoll = rand(1,20);
$statusRoll += getRankBonus();
if ($statusRoll == 1) {
    echo "itemid:null, status:negative";
} else if (($statusRoll >= 2) && ($statusRoll <= 6)) {
    echo "itemid:null";
} else if (($statusRoll >= 7) && ($statusRoll <= 12)) {
    getGatheringItem($conn, getQuantity(), "common", $location);
} else if (($statusRoll >= 13) && ($statusRoll <= 16)) {
    getGatheringItem($conn, getQuantity(), "uncommon", $location);
} else if (($statusRoll >= 17) && ($statusRoll <= 19)) {
    getGatheringItem($conn, getQuantity(), "rare", $location);
} else {
    getGatheringItem($conn, getQuantity(), "rare", $location);
    echo ", status:positive";
}
CloseCon($conn);
?>
