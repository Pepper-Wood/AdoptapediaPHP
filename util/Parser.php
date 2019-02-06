<?php

/**
* Updates the group info every 30 minutes in batches of 20 groups, run via cron job
* This script can be run manually, but is not recommended
* This method bypasses SiteGround's limit of 60 seconds per script (script runs in about 20 seconds)
*/

require "DeviantArt.php";
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();

$qry = "SELECT * FROM counter";
$result = $conn->query($qry);
$row = mysqli_fetch_array($result);
$offset = $row['offset']; // Group to start at
$count = $row['count']; // Number of groups to update, should be 20

$qry = "SELECT * FROM groups";
$result = $conn->query($qry);
$num_rows = mysqli_num_rows($result);

$qry = "SELECT groupid, groupname FROM groups LIMIT ".$count." OFFSET ".$offset.";";
$result = $conn->query($qry);

$updated_groups = 0;

// Loop through every group
while ($row = mysqli_fetch_array($result)) {
    $groupname = $row['groupname'];
    $daGroup = new DeviantArt($groupname);
    $infoArray = $daGroup->getInfoArray();
    if ($infoArray['http_code'] == 200) {
        // Update if there is successful connection to group
        $qry =
            "UPDATE groups
            SET groupnamecase='".$infoArray['username_case']."',
            description='".$infoArray['description']."',
            members=".$infoArray['members'].",
            watchers=".$infoArray['watchers'].",
            pageviews=".$infoArray['pageviews'].",
            founded='".$infoArray['founded']."',
            iconurl='".$infoArray['icon']."'
            WHERE groupname='".$infoArray['username']."';";
        $conn->query($qry);
        echo "Updated ".$groupname."\n";
        $updated_groups++;
    } elseif ($infoArray['http_code'] == 404 || $infoArray['http_code'] == 0) {
        // Delete if there is a 404 not found error
        $qry = "DELETE FROM groups WHERE groupid=".$row['groupid'].";";
        $conn->query($qry);
        $qry = "DELETE FROM groupscategories WHERE groupid=".$row['groupid'].";";
        $conn->query($qry);
        echo "Deleted ".$groupname."\n";
    }
    unset($daGroup);
}

$offset += $updated_groups;
if ($offset >= $num_rows) $offset = 0;
$qry = "UPDATE counter SET offset=".$offset.";";
$conn->query($qry);
CloseCon($conn);
