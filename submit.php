<?php
require('util/DeviantArt.php');
include_once('header.php');
include_once('HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();
?>

<script>
// JavaScript fun: verifies two things and disables the submit button if at least one test fails
// NOTE: disabling the submit button is not a foolproof way to stop submission errors, thus
// errors are checked again in the PHP.
function verify() {
    var catsFailed = false;
    var e = document.getElementsByClassName("cats");
    var maxCats = 2;
    var checkedNum = 0;
    for (i = 0; i < e.length; i++) {
        if (e[i].checked) {
            checkedNum++;
        }
    }
    // Disable checkboxes once a user has selected two categories
    for (i = 0; i < e.length; i++) {
        if (checkedNum >= maxCats) {
           if (!e[i].checked) {
               e[i].setAttribute('disabled','disabled');
           }
        } else {
            e[i].removeAttribute('disabled');
        }
    }
    // If a user has entered no category or somehow exceeded two categories, verification fails
    if (checkedNum == 0 || checkedNum > maxCats) {
        catsFailed = true;
    } else {
        catsFailed = false;
    }

    str = document.getElementsByName("groupname")[0].value;

    // Use AJAX to verify correctness of group name
    // Only checks against malformed group names or group names already in the database
    // (i.e. checks that take a fraction of a second)
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "SUCCESS") {
                document.getElementById("grouptext").innerHTML = "Looks good!";
                document.getElementById("group").className = "form-group has-success";
                if (!catsFailed) {
                    document.getElementById('submit').removeAttribute('disabled');
                } else {
                    document.getElementById('submit').setAttribute('disabled','disabled');
                }
            } else {
                document.getElementById("grouptext").innerHTML = this.responseText;
                document.getElementById("group").className = "form-group has-error";
                document.getElementById('submit').setAttribute('disabled','disabled');
            }
        }
    };
    xmlhttp.open("GET", "util/verifyname.php?q=" + str, true);
    xmlhttp.send();
}
</script>

<?php
$conn->set_charset('utf8mb4');

if (!isset($_SESSION['user'])) {
    echo "
    <div class='container' style='margin-top:20px'>
    <div class='alert alert-danger'>
    <strong>Error!</strong> Please log in to use this feature!
    </div>
    </div>
    ";
} elseif (!empty($_POST['groupname'])) {
    $group_error = "";
    $category_error = "";

    // JavaScript verification should not allow this to happen, but check anyway
    if (count($_POST['c']) == 0) {
        $category_error = "<li>Please select at least one category!</li>";
    } else if (count($_POST['c']) > 2) {
        $category_error = "<li>You have somehow selected more than two categories!</li>";
    }

    // DeviantArt acceptable group name format:
    // 3 to 20 characters, alphanumeric or hyphens, hyphens cannot start or end the group name
    if (!preg_match('/^[A-Za-z0-9][A-Za-z0-9-]{1,18}[A-Za-z0-9]$/', $_POST['groupname'])) {
        $group_error = "<li>Please enter a valid name!</li>";
    } else {
        $qry = "SELECT * FROM groups WHERE groupname='".$_POST['groupname']."';";
        if (mysqli_num_rows($conn->query($qry)) != 0) {
            $group_error = "<li>Group is already in database!</li>";
        } else {
            $qry = "SELECT * FROM requestsgroups WHERE groupname='".$_POST['groupname']."' AND status='pending';";
            if (mysqli_num_rows($conn->query($qry)) != 0) {
                $group_error = "<li>Group is already pending!</li>";
            } else {
                $group = new DeviantArt($_POST['groupname']);
                $infoArray = $group->getInfoArray();
                // Fail on 404 not found errors or similar HTTP errors
                if ($infoArray['http_code'] != 200) {
                    $group_error = "<li>Could not connect to group <em>".$_POST['groupname']."</em>! Check that you typed your group name correctly.</li>";
                } else {
                    $admins = $group->parseGroupAdmins();
                    if (!in_array($_SESSION['user']->getUsername(), array_values($admins))) {
                        $group_error = "<li>You are not an admin of this group!</li>";
                    } else {
                        // Success condition
                        $qry = "SELECT * FROM requestsgroups";
                        $num_rows = mysqli_num_rows($conn->query($qry));
                        // The unique groupid in requestsgroups is the number of rows + 1
                        $qry = "INSERT INTO requestsgroups (groupid, userid, groupname, status)
                        VALUES (".($num_rows+1).",".$_SESSION['user']->getID().",'".$_POST['groupname']."','pending');";
                        $conn->query($qry);
                        foreach($_POST['c'] as $cat => $status) {
                            if ($status == "on") {
                                $qry = "INSERT INTO requestsgroupscategories VALUES(".($num_rows+1).",".$cat.");";
                                $conn->query($qry);
                            }
                        }
                    }
                }
            }
        }
    }
    if ($group_error == "" && $category_error == "") {
        echo "<div class='container' style='margin-top:20px'><div class='alert alert-success'>";
        echo "<strong>Congrats!</strong> Your submission for ".$_POST['groupname']." was successful and will soon be approved by an administrator.<br>";
        echo "</div></div>";
    } else {
        echo "<div class='container' style='margin-top:20px'><div class='alert alert-danger'>";
        echo "<strong>Sorry!</strong> your submission has the following errors:
        <ul>".$group_error.$category_error."</ul>";
        echo "</div>";
        echo "<a href='submit.php' class='btn btn-info'>Back to form</a>";
        echo "</div>";
    }
} else {
    echo "<div class='container'>";
    echo "<h2>Submit a DeviantArt Adoptable Group</h2>";
    echo "<p>Fill this form out if you want to submit your Adoptable group to our database. You must be a founder, co-founder, or contributor of the group to submit it.</p><hr>";
    // Main form
    echo "
    <form method='post' action='submit.php' class='form-horizontal'>
	<fieldset>

	<!-- Text input -->
    <div class='form-group' id='group'>
		<label class='col-md-4 control-label' for='groupname'>Enter your group name:</label>
		<div class='col-md-4'>
			<input type='text' name='groupname' id='groupname' aria-describedby='grouptext' class='form-control' maxlength=20 onchange='verify()'>
			<small id='grouptext' class='form-text text-muted'>Please enter a group name</small>
		</div>
    </div>

	<!-- Multiple Checkboxes (inline) -->
    <div class='form-group'>
		<label class='col-md-4 control-label' for='cats_controls'>Choose 1 or 2 categories: <a data-toggle='modal' data-target='#CategoriesModal'>[?]</a></label>
		<div id='cats_controls' class='col-md-4'>
    ";

    // Get list of categories from DB
    $qry = "SELECT * FROM categories c";
    $result = $conn->query($qry);
    while ($row = mysqli_fetch_array($result)) {
        $cn = $row['categoryname'];
        echo "<label class='checkbox-inline'><input type='checkbox' class='cats' name='c[".$row['categoryid']."]' onchange='verify()'>".ucwords($cn)."</label>\n";
    }

    echo "
    </div>
    </div>

	<!-- Submit button -->
	<div class='form-group'>
		<label class='col-md-4 control-label'> </label>
		<div class='col-md-4'>
		<input type='submit' id='submit' class='btn btn-block btn-info' value='Submit' disabled>
		</div>
	</div>
    </fieldset></form>";
    echo "</div>";
}
?>
<div class='modal fade' id='CategoriesModal' role='dialog'>
<div class='modal-dialog'>
<div class='modal-content'>
<div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    <h2 class="modal-title text-center">Categories</h2>
</div>
<div class='modal-body'>
    <p class="text-center">Each adoptable group falls under various categories to help you be able to filter them according to your tastes. Below are the definitions for the abbreviations shown:</p>
    <table class='table table-striped'>
        <tr><td><b>All</b></td><td>Adoptable groups without restrictions on submissions.</td></tr>
        <tr><td><b>Agency</b></td><td>Adoptable Agencies. These are typically groups where purchasing adopts is done via an in-world currency and also focus more on roleplay than exchanging money.</td></tr>
        <tr><td><b>Closed</b></td><td>User-made species restricted groups. Named closed due to the vast majority of user-made species being closed species. However, this category also contains groups for open species.</td></tr>
        <tr><td><b>Fandom</b></td><td>Fandom-based groups, i.e. groups that accept adopts that fall within a popular show or game's universe like Homestuck or My Little Pony.</td></tr>
        <tr><td><b>Misc</b></td><td>Groups that don't fall under the other categories, i.e. adoptable base groups and hatchable groups.</td></tr>
        <tr><td><b>Payment</b></td><td>Payment-restricted groups, i.e. groups that only accept points or paypal for payment.</td></tr>
        <tr><td><b>Quality</b></td><td>Quality-restricted groups. These may require artists to submit an application before being accepted and allowed to submit.</td></tr>
        <tr><td><b>Species</b></td><td>Groups that filter based on generalized species. For example, canine-only, feline-only, kemonomimi-only, etc. This does not include user-made species.</td></tr>
    </table>
</div></div></div></div>
<?php
include_once('footer.php');
CloseCon($conn);
?>
