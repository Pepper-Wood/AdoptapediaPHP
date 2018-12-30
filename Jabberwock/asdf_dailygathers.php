<?php
$conn = new mysqli("localhost", "adoptape", "u7w58d3294s", "adoptape_jabberwockdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$debug = False;

$smallestIdSql = mysqli_query($conn, "SELECT MIN(gatherid) as minid FROM dailygathers;");
$smallestIdRow = mysqli_fetch_assoc($smallestIdSql);
$smallestId = $smallestIdRow['minid'];

$biggestIdSql = mysqli_query($conn, "SELECT MAX(gatherid) as maxid FROM dailygathers;");
$biggestIdRow = mysqli_fetch_assoc($biggestIdSql);
$biggestId = $biggestIdRow['maxid'];

$usersql = "SELECT * FROM siteusers WHERE type != 'user' ORDER BY username;";
$userresult = mysqli_query($conn, $usersql);
if (mysqli_num_rows($userresult) > 0) {
    while ($userrow = mysqli_fetch_assoc($userresult)) {
        $gatherResults = array();
        for ($i = 0; $i < 3; $i++) {
            $randQuantity = mt_rand(1, 3);

            $randId = mt_rand($smallestId, $biggestId);
            $itemIdSql = mysqli_query($conn, "SELECT dailygathers.gatherid, dailygathers.itemid, items.itemname FROM dailygathers LEFT JOIN items ON items.itemid=dailygathers.itemid WHERE dailygathers.gatherid=".$randId.";");
            $itemIdRow = mysqli_fetch_assoc($itemIdSql);
            $itemId = $itemIdRow['itemid'];
            $itemname = $itemIdRow['itemname'];

            if ($itemId != -1) {
                $unixtimestamp = time();

                $sql = "SELECT * FROM inventories WHERE ownerid=".$userrow['userid']." AND itemid=".$itemId.";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $updatesql = "UPDATE inventories SET quantity=".$row['quantity']."+".$randQuantity." WHERE ownerid=".$userrow['userid']." AND itemid=".$itemId.";";
                    if ($debug) {
                        echo $updatesql."<br>";
                    } else {
                        $updateresult = mysqli_query($conn, $updatesql);
                    }
                } else {
                    $insertsql = "INSERT INTO `inventories`(`ownerid`, `quantity`, `itemid`) VALUES (".$userrow['userid'].",".$randQuantity.",".$itemId.");";
                    if ($debug) {
                        echo $insertsql."<br>";
                    } else {
                        $insertresult = mysqli_query($conn, $insertsql);
                    }
                }
                if (in_array($itemname, $gatherResults)) {
                    $gatherResults[$itemname] += $randQuantity;
                } else {
                    $gatherResults[$itemname] = $randQuantity;
                }
            }
        }

        ksort($gatherResults);
        $gatherResultsStr = "";
        foreach($gatherResults as $gkey => $gval) {
            $gatherResultsStr .= $gval." ".$gkey.", ";
        }
        $gatherResultsStr = substr($gatherResultsStr, 0, -2);

        $maxMessageIdSql = mysqli_query($conn, "SELECT MAX(messageid) as maxid FROM messages;");
        $maxMessageIdRow = mysqli_fetch_assoc($maxMessageIdSql);
        $maxMessageId = $maxMessageIdRow['maxid'] + 1;
        $alertmessagesql = "INSERT INTO `messages`(`messageid`, `userid`, `type`, `messagedate`, `messagetext`) VALUES (".$maxMessageId.",".$userrow['userid'].",'success','".$unixtimestamp."','You got <b>".$gatherResultsStr."</b> from your dailies')";
        if ($debug) {
            echo $alertmessagesql."<br>";
        } else {
            $alertmessageresult = mysqli_query($conn, $alertmessagesql);
        }

        $maxTransLogSql = mysqli_query($conn, "SELECT MAX(transactionid) as maxid FROM transactionhistory;");
        $maxTransLogRow = mysqli_fetch_assoc($maxTransLogSql);
        $maxTransLogID = $maxTransLogRow['maxid'] + 1;
        $transactionhistorysql = "INSERT INTO `transactionhistory`(`transactionid`, `userid`, `date`, `timestamp`, `action`, `fullaction`) VALUES (".$maxTransLogID.",".$userrow['userid'].",'".$unixtimestamp."','".$unixtimestamp."','daily','Received ".$gatherResultsStr." from dailies');";
        if ($debug) {
            echo $transactionhistorysql."<br>";
        } else {
            $transactionhistoryresult = mysqli_query($conn, $transactionhistorysql);
        }
        if ($debug) {
            echo "<br>";
        }
    }
}

?>
