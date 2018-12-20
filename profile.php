<?php
include_once('header.php');
include_once('HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();
?>

<script>
// Show only groups of a given status type
function toggle(type) {
    var rows = document.getElementsByTagName('tr');
    for (var i = 0, l = rows.length; i < l; i++) {
        if (rows[i].getAttribute('id') == type || rows[i].getAttribute('id') == "all" || type == "all") {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}
</script>

<?php
if (!isset($_SESSION['user'])) {
    echo "
    <div class='container'>
    <div class='alert alert-danger'>
    <strong>Error!</strong> Please log in to use this feature!
    </div>
    </div>
    ";
} else {
    echo "<div class='container'>";
    echo "<h2>Welcome to your profile page, <a href='http://".strtolower($_SESSION['user']->getUsername()).".deviantart.com/' target='_blank'>".$_SESSION['user']->getUsername()."</a>!</h2>";
    $qry = "SELECT * FROM requestsgroups WHERE userid=".$_SESSION['user']->getID()." ORDER BY date DESC;";
    $result = $conn->query($qry);
    if (mysqli_num_rows($result) == 0) {
        echo "<h4>You have not submitted any groups! <a href='submit.php'>Submit one now!</a></h4>";
    } else {
    	echo "<h4>You have submitted a total of <strong>".mysqli_num_rows($result)."</strong> groups</h4>\n";

    	echo "<p>
    	<label class='radio-inline'><input type='radio' name='requests' value='all'      onclick='toggle(this.value)' checked>All</label>
        <label class='radio-inline'><input type='radio' name='requests' value='pending'  onclick='toggle(this.value)'>Pending</label>
        <label class='radio-inline'><input type='radio' name='requests' value='approved' onclick='toggle(this.value)'>Approved</label>
        <label class='radio-inline'><input type='radio' name='requests' value='rejected' onclick='toggle(this.value)'>Rejected</label>
        </p>
        ";

        echo "<table class='table table-hover'>
        <tr id='all'><th width=30%>Group</th><th width=30%>Date</th><th width=30%>Categories</th><th width=10%>Status</th></tr>\n";
        while ($row = mysqli_fetch_array($result)) {
            // Assemble a list of group's categories
            $qry = "SELECT c.categoryname FROM categories c, requestsgroupscategories gc WHERE gc.groupid='".$row['groupid']."' AND gc.categoryid=c.categoryid";
            $result2 = $conn->query($qry);
            $category_str = ucfirst(mysqli_fetch_array($result2)['categoryname']);
            while ($row2 = mysqli_fetch_array($result2)) {
                $category_str .= ", ".ucfirst($row2['categoryname']);
            }
            // Convert a date from 2016-11-18 to 18 Nov, 2016
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $row['date'], new DateTimeZone('UTC'))->format('j M, Y');

            if ($row['status'] == 'pending') {
                $row_class = 'active';
            } elseif ($row['status'] == 'approved') {
                $row_class = 'success';
            } elseif ($row['status'] == 'rejected') {
                $row_class = 'danger';
            }

            echo "<tr id='".$row['status']."' class='".$row_class."'>
            <td><a href='http://".strtolower($row['groupname']).".deviantart.com' target='_blank'>".$row['groupname']."</a></td>
            <td>".$date."</td><td>".$category_str."</td><td>".ucfirst($row['status'])."</td></tr>\n";
        }
        echo "</table>\n";
    }
    echo "</div>";
}
include_once('footer.php');
CloseCon($conn);
?>
