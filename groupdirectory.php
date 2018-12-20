<?php

// Ensures input date is ISO 8601 compliant.
// Date input fields should ensure this, but this is an additional safeguard.
function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date, new DateTimeZone('UTC'));
    return $d && $d->format('Y-m-d') === $date;
}

// Outputs SQL row as a button with a modal attached.
function printButton($row, $category_str) {
    $un = $row['groupname'];
    // Convert a date from 2016-11-18 to 18 Nov, 2016
    $new_date = DateTime::createFromFormat('Y-m-d', $row['founded'], new DateTimeZone('UTC'))->format('j M, Y');;
    if ($row['iconurl'] == 'nul') {
        // If a group has no icon, use Adoptapedia's icon
        $icon = 'assets/images/noicon.png';
    } else {
        // Assemble icon URL given group name and file extension
        // URLs for all groups consist of base URL + first character of group name + /
        // + second character of group name (- is converted to _) + / + groupname + icon extension
        $icon = "http://a.deviantart.net/avatars/".$un[0]."/".str_replace('-','_',$un[1])."/".$un.".".$row['iconurl'];
    }

    echo "
    <button type='button' class='daButton' data-toggle='modal' data-target='#".$row['groupnamecase']."Modal'>
    <img src='".$icon."'><br>".$row['groupnamecase']."</button>

    <div class='modal fade' id='".$row['groupnamecase']."Modal' role='dialog'>
    <div class='modal-dialog'>
    <div class='modal-content'>
    <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    <center><h4 class='modal-title'><img src='".$icon."'><br>".$row['groupnamecase']."</h4></center>
    </div>
    <div class='modal-body'>
        <center><a target='_blank' href='http://".$row['groupname'].".deviantart.com'>Click here to be taken to the group</a></center><br>
        <table class='table table-striped'>"
            .(empty($row['description']) ? "" : "<tr><td><b>Description</b></td><td>".$row['description']."</td></tr>")."
            <tr><td><b>Categories</b></td><td>".$category_str."</td></tr>
            <tr><td><b>Members</b></td><td>".number_format($row['members'])."</td></tr>
            <tr><td><b>Pageviews</b></td><td>".number_format($row['pageviews'])."</td></tr>
            <tr><td><b>Watchers</b></td><td>".number_format($row['watchers'])."</td></tr>
            <tr><td><b>Founded</b></td><td>".$new_date."</td></tr>
        </table>
    </div></div></div></div>
    ";
}

include_once('header.php');
include_once('HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();

// Check form inputs. If not filled in, keep the default values.
$ml = 0;
if (ctype_digit($_POST['ml'])) $ml = $_POST['ml'];
$mh = PHP_INT_MAX;
if (ctype_digit($_POST['mh'])) $mh = $_POST['mh'];
$pl = 0;
if (ctype_digit($_POST['pl'])) $pl = $_POST['pl'];
$ph = PHP_INT_MAX;
if (ctype_digit($_POST['ph'])) $ph = $_POST['ph'];
$wl = 0;
if (ctype_digit($_POST['wl'])) $wl = $_POST['wl'];
$wh = PHP_INT_MAX;
if (ctype_digit($_POST['wh'])) $wh = $_POST['wh'];
$dl = '0000-01-01';
if (validateDate($_POST['dl'])) $dl = $_POST['dl'];
$dh = '2099-12-31';
if (validateDate($_POST['dh'])) $dh = $_POST['dh'];
if (!empty($_POST)) {
    $category_filters = "0";
    if (!empty($_POST['c'])) {
        foreach ($_POST['c'] as $num) {
            $category_filters .= " OR categoryid=".$num;
        }
    }
} else {
    $category_filters = "1";
}

// Choose type of SQL sort to append to SQL query based on user input
$sort_str = ' ORDER BY ';
switch ($_POST['sort']) {
    case 'na':
        $sort_str .= ' groupname ASC';
        break;
    case 'nd':
        $sort_str .= ' groupname DESC';
        break;
    case 'ma':
        $sort_str .= ' members ASC, groupname ASC';
        break;
    case 'md':
        $sort_str .= ' members DESC, groupname ASC';
        break;
    case 'pa':
        $sort_str .= ' pageviews ASC, groupname ASC';
        break;
    case 'pd':
        $sort_str .= ' pageviews DESC, groupname ASC';
        break;
    case 'wa':
        $sort_str .= ' watchers ASC, groupname ASC';
        break;
    case 'wd':
        $sort_str .= ' watchers DESC, groupname ASC';
        break;
    case 'fa':
        $sort_str .= ' founded ASC, groupname ASC';
        break;
    case 'fd':
        $sort_str .= ' founded DESC, groupname ASC';
        break;
    default:
        $sort_str .= ' groupname ASC';
}

// Main form
// Conditional operators save user input from previous submission

echo
"<div class='container-fluid' style='background-color:#eaefe8; min-height:1000px;'>
<div class='col-md-4 col-xs-4' style='position:relative;'>
    <br>
    <div class='col-md-4 col-xs-4' style='position:fixed; background-color:#d4dfd0;'>
        <h3 class='text-center'>Search for a group</h3>
        <form method='post' action='groupdirectory.php'>
            <div class='input-group form-group'>
                <span class='input-group-addon'><span class='glyphicon glyphicon-search'></span> Search</span>
                <input class='form-control' type='text' name='ml' size=7 maxlength=7 placeholder='this does not do anything'>
            </div>
            <div class='input-group form-group'>
                <span class='input-group-addon'>Between</span>
                <input class='form-control' type='text' name='ml' size=7 maxlength=7 placeholder=' '".($_POST['ml'] != '' ? ' value='.$ml : '').">
                <span class='input-group-addon' style='border-left: 0; border-right: 0;'>and</span>
                <input class='form-control' type='text' name='mh' size=7 maxlength=7 placeholder=' '".($_POST['mh'] != '' ? ' value='.$mh : '').">
                <span class='input-group-addon'>Members</span>
            </div>
            <div class='input-group form-group'>
                <span class='input-group-addon'>Between</span>
                <input class='form-control' type='text' name='pl' size=7 maxlength=7 placeholder=' '".($_POST['pl'] != '' ? ' value='.$pl : '').">
                <span class='input-group-addon' style='border-left: 0; border-right: 0;'>and</span>
                <input class='form-control' type='text' name='ph' size=7 maxlength=7 placeholder=' '".($_POST['ph'] != '' ? ' value='.$ph : '').">
                <span class='input-group-addon'>Pageviews</span>
            </div>
            <div class='input-group form-group'>
                <span class='input-group-addon'>Between</span>
                <input class='form-control' type='text' name='wl' size=7 maxlength=7 placeholder=' '".($_POST['wl'] != '' ? ' value='.$wl : '').">
                <span class='input-group-addon' style='border-left: 0; border-right: 0;'>and</span>
                <input class='form-control' type='text' name='wh' size=7 maxlength=7 placeholder=' '".($_POST['wh'] != '' ? ' value='.$wh : '').">
                <span class='input-group-addon'>Watchers</span>
            </div>
            <div class='input-group form-group'>
                <span class='input-group-addon'>Founded Between</span>
                <input class='form-control' type='text' name='dl' size=7 maxlength=7 placeholder=' '".($_POST['dl'] != '' ? ' value='.$dl : '').">
                <span class='input-group-addon' style='border-left: 0; border-right: 0;'>and</span>
                <input class='form-control' type='text' name='dh' size=7 maxlength=7 placeholder=' '".($_POST['dh'] != '' ? ' value='.$dh : '').">
            </div>
            <div class='input-group form-group'>
                <span class='input-group-addon'>Sort By</span>
                <select name='sort' class='form-control' id='sel1'>
                    <option value = 'na'".($_POST['sort'] == 'na' ? ' selected': '').">Name - A-Z</option>
                    <option value = 'nd'".($_POST['sort'] == 'nd' ? ' selected': '').">Name - Z-A</option>
                    <option value = 'md'".($_POST['sort'] == 'md' ? ' selected': '').">Members - high to low</option>
                    <option value = 'ma'".($_POST['sort'] == 'ma' ? ' selected': '').">Members - low to high</option>
                    <option value = 'pd'".($_POST['sort'] == 'pd' ? ' selected': '').">Pageviews - high to low</option>
                    <option value = 'pa'".($_POST['sort'] == 'pa' ? ' selected': '').">Pageviews - low to high</option>
                    <option value = 'wd'".($_POST['sort'] == 'wd' ? ' selected': '').">Watchers - high to low</option>
                    <option value = 'wa'".($_POST['sort'] == 'wa' ? ' selected': '').">Watchers - low to high</option>
                    <option value = 'fd'".($_POST['sort'] == 'fd' ? ' selected': '').">Founded - latest first</option>
                    <option value = 'fa'".($_POST['sort'] == 'fa' ? ' selected': '').">Founded - oldest first</option>
                </select>
            </div>
            <label for='categorygroup'>Filter by Category: <a data-toggle='modal' data-target='#CategoriesModal'>[?]</a></label>
            <div class='form-group text-center' id='categorygroup'>";

            // Get category names from DB table, and print them out as checkboxes.
            $qry = "SELECT * FROM categories";
            $result = $conn->query($qry);
            while ($row = mysqli_fetch_array($result)) {
                $id = (string) $row['categoryid'];
                echo "<label class='checkbox-inline'><input type='checkbox' name='c[]' value='".$id."'".(empty($_POST) || ($_POST['c'] != null && in_array($id,$_POST['c'])) ? ' checked' : '').">".ucfirst($row['categoryname'])."</label>";
            }
            ?>

            </div>
            <p><input type='submit' name='submit' class='btn btn-success btn-block' value='Search'></p>
        </form>
    </div>
</div>

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

<div class="col-md-8 col-xs-8"><div class="container-fluid">
<br>
<?php
// If user hasn't pressed search yet, display nothing
if (!empty($_POST)) {
    $qry =
    "SELECT * FROM groups g WHERE g.members >= ".$ml." AND g.members <= ".$mh."
    AND g.pageviews >= ".$pl." AND g.pageviews <= ".$ph."
    AND g.watchers >= ".$wl." AND g.watchers <= ".$wh."
    AND founded >= '".$dl."' AND founded <= '".$dh."'
    AND g.groupid IN (SELECT gc.groupid FROM groupscategories gc WHERE ".$category_filters.") ".$sort_str.";";

    $result = $conn->query($qry);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        echo "<div class='alert alert-success'>
        Found <strong>".$num_rows."</strong> results.
        </div>";
        while ($row = mysqli_fetch_array($result)) {
            // Assemble a list of group's categories
            $qry = "SELECT c.categoryname FROM categories c, groupscategories gc WHERE gc.groupid='".$row['groupid']."' AND gc.categoryid=c.categoryid";
            $result2 = $conn->query($qry);
            $category_str = ucfirst(mysqli_fetch_array($result2)['categoryname']);
            while ($row2 = mysqli_fetch_array($result2)) {
                $category_str .= "<br>".ucfirst($row2['categoryname']);
            }
            printButton($row, $category_str);
        }
    } else {
        echo "<div class='alert alert-danger'>
        <strong>No results found!</strong> Please try a different search.
        </div>";
    }
}
echo "</div></div></div>";

CloseCon($conn);
include_once('footer.php');
