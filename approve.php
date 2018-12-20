<?php
require('util/DeviantArt.php');
include_once('header.php');

include_once('HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();

if (!isset($_SESSION['user'])) {
    echo "
    <div class='container' style='margin-top:20px'>
    <div class='alert alert-danger'>
    <strong>Error!</strong> Please log in to use this feature!
    </div>
    </div>
    ";
} elseif ($_SESSION['user']->getType() != "admin") {
    echo "
    <div class='container' style='margin-top:20px'>
    <div class='alert alert-danger'>
    <strong>Error!</strong> You are not an admin! Shoo!
    </div>
    </div>
    ";
} else {
    echo "<div class='container'>";
    echo "<h2>Review Groups</h2>";
    // Admin has submitted the form
    if (!empty($_POST)) {
        $approved_count = 0;
        $rejected_count = 0;
        foreach($_POST as $groupid => $action) {
            if ($action == 'approve') {
                $approved_count++;
                // Given a groupid, get the groupname
                $qry = "SELECT groupname FROM requestsgroups WHERE status='pending' AND groupid=".$groupid.";";
                $group_name = strtolower(mysqli_fetch_array($conn->query($qry))['groupname']);
                $group = new DeviantArt($group_name);
                $group_array = $group->getInfoArray();
                // Set group to approved in requestsgroups
                $qry = "UPDATE requestsgroups SET status='approved' WHERE status='pending' AND groupid=".$groupid.";";
                $conn->query($qry);
                // Get the max group ID of requestsgroups, to make a new unique group ID
                $qry = "SELECT (max(groupid) + 1) AS maxid FROM groups;";
                $new_groupid = mysqli_fetch_array($conn->query($qry))['maxid'];
                // Insert group into groups table
                $qry = "INSERT INTO groups VALUES
                (".$new_groupid.",'".$group_array['username']."','".$group_array['username_case']."','".$group_array['description']."',
                ".$group_array['members'].",".$group_array['pageviews'].",".$group_array['watchers'].",
                '".$group_array['icon']."','".$group_array['founded']."');";
                $conn->query($qry);
                // Insert categories into groupscategories table
                $qry = "SELECT * FROM requestsgroupscategories WHERE groupid=".$groupid.";";
                $result = $conn->query($qry);
                while ($row = mysqli_fetch_array($result)) {
                    $qry = "INSERT INTO groupscategories VALUES (".$new_groupid.",".$row['categoryid'].");";
                    $conn->query($qry);
                }
            }
            if ($action == 'reject') {
                $rejected_count++;
                $qry = "UPDATE requestsgroups SET status='rejected' WHERE status='pending' AND groupid=".$groupid.";";
                $conn->query($qry);
            }
        }
        echo "<h4>You approved <strong>".$approved_count."</strong> groups and rejected <strong>".$rejected_count."</strong> groups.</h4>";
    }

    $qry = "SELECT * FROM requestsgroups rg, siteusers su WHERE rg.status='pending' AND rg.userid=su.userid;";
    $result = $conn->query($qry);
    if (mysqli_num_rows($result) == 0) {
        echo "<h4>There are no pending groups at this time.</h4>";
    } else {
        // Main form
        echo "<form method='post' action='approve.php' class='form-group'>";
        echo "<table class='table'><tr><th>Group</th><th>User</th><th>Date</th><th>Categories</th><th>Action</th></tr>";
        while ($row = mysqli_fetch_array($result)) {
            // Assemble a list of group's categories
            $qry = "SELECT c.categoryname FROM categories c, requestsgroupscategories gc WHERE gc.groupid='".$row['groupid']."' AND gc.categoryid=c.categoryid";
            $result2 = $conn->query($qry);
            $category_str = ucfirst(mysqli_fetch_array($result2)['categoryname']);
            while ($row2 = mysqli_fetch_array($result2)) {
                $category_str .= ", ".ucfirst($row2['categoryname']);
            }

            echo "<tr><td><a href='http://".strtolower($row['groupname']).".deviantart.com' target='_blank'>".$row['groupname']."</a></td>
            <td>".$row['username']."</td><td>".$row['date']."</td><td>".$category_str."</td><td>
            <select name='".$row['groupid']."' class='form-control'>
            <option value='none'></option>
            <option value='approve'>Approve</option>
            <option value='reject'>Reject</option>
            </select></td></tr>";
        }
        echo "</table>";
        echo "<input type='submit' value='Submit' class='btn btn-info'></form>";
    }
    echo "</div>";
}

CloseCon($conn);
include_once('footer.php');
