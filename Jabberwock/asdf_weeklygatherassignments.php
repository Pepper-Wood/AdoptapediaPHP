<?php
$conn = new mysqli("localhost", "adoptape", "u7w58d3294s", "adoptape_jabberwockdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$debug = True;

$smallestIdSql = mysqli_query($conn, "SELECT MIN(assignmentid) as minid FROM weeklyassignments;");
$smallestIdRow = mysqli_fetch_assoc($smallestIdSql);
$smallestId = $smallestIdRow['minid'];

$biggestIdSql = mysqli_query($conn, "SELECT MAX(assignmentid) as maxid FROM weeklyassignments;");
$biggestIdRow = mysqli_fetch_assoc($biggestIdSql);
$biggestId = $biggestIdRow['maxid'];

$usersql = "SELECT * FROM siteusers WHERE type != 'user' ORDER BY username;";
$userresult = mysqli_query($conn, $usersql);
if (mysqli_num_rows($userresult) > 0) {
    while ($userrow = mysqli_fetch_assoc($userresult)) {
        $randId = mt_rand($smallestId, $biggestId);
        $itemIdSql = mysqli_query($conn, "SELECT weeklyassignments.assignmentid, weeklyassignments.itemid, items.itemname FROM weeklyassignments LEFT JOIN items ON items.itemid=weeklyassignments.itemid WHERE weeklyassignments.assignmentid=".$randId.";");
        $itemIdRow = mysqli_fetch_assoc($itemIdSql);
        $itemId = $itemIdRow['itemid'];
        $itemname = $itemIdRow['itemname'];

        $updatesql = "UPDATE weeklyuserassignments SET recipeid=".$itemId.", isDone=0 WHERE ownerid=".$userrow['userid'].";";
        if ($debug) {
            echo $updatesql."<br>";
        } else {
            $updateresult = mysqli_query($conn, $updatesql);
        }
    }
}

?>
