<?php
$conn = new mysqli("localhost", "adoptape", "u7w58d3294s", "adoptape_jabberwockdb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<style>
.header {
    background-color: #fe5375;
    color: #fff;
}
table {
    border: 1px solid #000;
}
.two {
    background-color: #d6fce5;
}
.three {
    background-color: #f4cccc;
}
</style>

<?php
$debug = True;

echo "<img style='width:60%' src='assignmentLegend.png'><br>";

$smallestIdSql = mysqli_query($conn, "SELECT MIN(assignmentid) as minid FROM weeklyassignments;");
$smallestIdRow = mysqli_fetch_assoc($smallestIdSql);
$smallestId = $smallestIdRow['minid'];

$biggestIdSql = mysqli_query($conn, "SELECT MAX(assignmentid) as maxid FROM weeklyassignments;");
$biggestIdRow = mysqli_fetch_assoc($biggestIdSql);
$biggestId = $biggestIdRow['maxid'];

echo "<table><tr><td class='header'>Username</td><td class='header'>Assignment</td><td class='header'>Recipe Name</td></tr>";

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
            //echo $updatesql."<br>";
            echo "<tr><td class='one'>".$userrow['username']."</td><td class='two'>".$randId."</td><td class='three'>".$itemname."</td></tr>";
        } else {
            $updateresult = mysqli_query($conn, $updatesql);
        }
    }
}
echo "</table>";

?>
