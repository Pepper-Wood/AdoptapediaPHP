<?php
function printNestedRecipe($conn, $userid, $ingredientid, $diff) {
    $recipesql = "SELECT quantity,ingredientquantity,itemname,items.itemid as itemid,type,ingredientid FROM recipes LEFT JOIN items ON items.itemid=recipes.ingredientid LEFT JOIN inventories ON inventories.itemid=recipes.ingredientid  AND inventories.ownerid=".$userid." WHERE recipes.recipeid=".$ingredientid." ORDER BY items.itemname;";
    $reciperesult = mysqli_query($conn, $recipesql);
    if (mysqli_num_rows($reciperesult) > 0) {
        echo "<table class='table table-sm'><tbody>";
        while ($reciperow = mysqli_fetch_assoc($reciperesult)) {
            echo "<tr class='";
            $newDiff = 0;
            if ($reciperow['quantity'] >= ($reciperow['ingredientquantity'] * $diff)) {
                echo "table-success";
            } else {
                echo "bg-danger";
                $newDiff = ($reciperow['ingredientquantity'] * $diff) - $reciperow['quantity'];
            }
            if ($reciperow['quantity'] == null) {
                echo "'><td>0/".($reciperow['ingredientquantity'] * $diff)."</td><td>";
            } else {
                echo "'><td>".$reciperow['quantity']."/".($reciperow['ingredientquantity'] * $diff)."</td><td>";
            }
            if ($reciperow['type'] == 'b-craft') {
                echo "<b>";
            }
            if ($reciperow['quantity'] < ($reciperow['ingredientquantity'] * $diff)) {
                echo "<a class='scavengerLink' target='_blank' href='https://jabberwock-isle.com/itemsearch.php?iid=".$reciperow['itemid']."'>";
            }
            echo $reciperow['itemname'];
            if ($reciperow['quantity'] < ($reciperow['ingredientquantity'] * $diff)) {
                echo "</a>";
            }
            if ($reciperow['type'] == 'b-craft') {
                echo " <i class='far fa-star'></i></b>";
                if ($reciperow['quantity'] < ($reciperow['ingredientquantity'] * $diff)) {
                    printNestedRecipe($conn, $userid, $reciperow['ingredientid'], $newDiff);
                }
            }
        }
        echo "</tbody></table>";
    }
}
?>

<h1 class="text-center">Hello, <?php echo $_SESSION['user']->getUsername()?>!</h1>
<?php
$primaryStudentSql = mysqli_query($conn, "SELECT studentname FROM siteusersettings LEFT JOIN students ON students.studentid=siteusersettings.mainstudentid WHERE userid=".$_SESSION['user']->getID().";");
$primaryStudentRow = mysqli_fetch_assoc($primaryStudentSql);
?>
<p class="text-center">Your primary student is <u><?php echo $primaryStudentRow['studentname']; ?></u> <a href="javascript:void(0)" data-toggle="modal" data-target="#primaryStudentModal">[?]</a></p>

<?php
    $currmonocoinssql = mysqli_query($conn, "SELECT monocoins FROM siteusersettings WHERE userid=".$_SESSION['user']->getID().";");
    $currmonocoinsrow = mysqli_fetch_assoc($currmonocoinssql);
    $currmonocoins = $currmonocoinsrow['monocoins'];
?>
<div class="card alert-warning" style="display: inline-block;padding: 10px;width: 100%;text-align: center;">
    You have <?php echo $currmonocoins; ?> <img src="https://orig00.deviantart.net/910f/f/2018/105/6/6/mbc2_by_bootsii-dc8xg2k.png">
</div>

<?php
$timezonesql = mysqli_query($conn, "SELECT timezone FROM siteusersettings WHERE userid=".$_SESSION['user']->getID().";");
$timezonerow = mysqli_fetch_assoc($timezonesql);
$usertimezone = $timezonerow['timezone'];
date_default_timezone_set($usertimezone);

$sql = mysqli_query($conn, "SELECT itemname,isDone FROM weeklyuserassignments LEFT JOIN items ON items.itemid=weeklyuserassignments.recipeid WHERE ownerid=".$_SESSION['user']->getID().";");
$row = mysqli_fetch_assoc($sql);
if ($row['isDone'] == 0) {
    $sunday = strtotime('next Sunday');
?>

<div class="alert alert-warning" role="alert">
    <div class="horizontalFlex">
        <div>Your weekly crafting assignment is <b><?php echo $row['itemname']; ?></b>!</div>
        <div id="assignmentCountdown">Loading...</div>
    </div>
</div>

<script>
var seconds = <?php echo ($sunday-time()); ?>;
function timer() {
    var days        = Math.floor(seconds/24/60/60);
    var hoursLeft   = Math.floor((seconds) - (days*86400));
    var hours       = Math.floor(hoursLeft/3600);
    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
    var minutes     = Math.floor(minutesLeft/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds;
    }
    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (days == 1) {
        $("#assignmentCountdown").html(days + " day " + hours + "h " + minutes + "m " + remainingSeconds + "s");
    } else {
        $("#assignmentCountdown").html(days + " days " + hours + "h " + minutes + "m " + remainingSeconds + "s");
    }

    if (seconds == 0) {
        clearInterval(countdownTimer);
        location.reload();
    } else {
        seconds--;
    }
}
var countdownTimer = setInterval('timer()', 1000);
</script>
<?php
} else {
?>
    <div class="alert alert-success" role="alert">
        <div class="horizontalFlex">
            <div>You completed your weekly crafting assignment: <b><?php echo $row['itemname']; ?></b></div>
        </div>
    </div>
<?php
}
?>

<?php
$usersql = "SELECT * FROM siteusers WHERE type!='user' AND siteusers.userid=".$_SESSION['user']->getID().";";
$userresult = mysqli_query($conn, $usersql);
if (mysqli_num_rows($userresult) > 0) {
    while ($userrow = mysqli_fetch_assoc($userresult)) { ?>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="horizontalFlex inventorySectionTitle">
                    <h4 style="margin:0">Inventory</h4>
                    <div>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#removeitemModal"><btn class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button></a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#additemModal"><btn class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Raw</h5>
                                <?php
                                    $sql = "SELECT * FROM inventories,items WHERE inventories.itemid=items.itemid AND inventories.ownerid=".$userrow['userid']." AND type='c-raw' ORDER BY itemname;";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<table class='table table-sm'><tbody>";
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['quantity'] > 0) {
                                                echo "<tr><td>".$row['quantity']."</td><td>".$row['itemname']."</td></tr>";
                                            }
                                        }
                                        echo "</tbody></table>";
                                    } else {
                                        echo "<p class='extraPadding'>You have no raw materials.</p>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Crafted <i class="far fa-star"></i></h5>
                                <?php
                                    $sql = "SELECT * FROM inventories,items WHERE inventories.itemid=items.itemid AND inventories.ownerid=".$userrow['userid']." AND type='b-craft' ORDER BY itemname;";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        echo "<table class='table table-sm'><tbody>";
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['quantity'] > 0) {
                                                echo "<tr><td>".$row['quantity']."</td><td>".$row['itemname']."</td></tr>";
                                            }
                                        }
                                        echo "</tbody></table>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="horizontalFlex inventorySectionTitle">
                    <h4 style="margin:0">Crafting</h4>
                    <div>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#changeAssignmentsModal"><btn class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button></a>
                    </div>
                </div>
                <?php
                    $sql = "SELECT * FROM assignments LEFT JOIN items ON assignments.recipeid=items.itemid WHERE ownerid=".$userrow['userid'].";";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div id='removeAssignment<?php echo $row['itemid']; ?>Card' class="card">
                                <div class="card-body">
                                    <?php $isCraftable = true; ?>
                                    <div id='removeAssignment<?php echo $row['itemid']; ?>' class='closebtn removeAssignment'><i class='fas fa-times-circle'></i></div>
                                    <h5 id="craftAssignmentName<?php echo $row['itemid']; ?>" class="card-title"><?php echo $row['itemname']; ?></h5>
                                    <table class="table table-sm">
                                        <tbody>
                                            <?php
                                                $recipesql = "SELECT quantity,ingredientquantity,itemname,items.itemid as itemid,type,ingredientid FROM recipes LEFT JOIN items ON items.itemid=recipes.ingredientid LEFT JOIN inventories ON inventories.itemid=recipes.ingredientid  AND inventories.ownerid=".$userrow['userid']." WHERE recipes.recipeid=".$row['recipeid']." ORDER BY items.itemname;";
                                                $reciperesult = mysqli_query($conn, $recipesql);
                                                if (mysqli_num_rows($reciperesult) > 0) {
                                                    while ($reciperow = mysqli_fetch_assoc($reciperesult)) {
                                                        echo "<tr class='";
                                                        $diff = 0;
                                                        if ($reciperow['quantity'] >= $reciperow['ingredientquantity']) {
                                                            echo "table-success";
                                                        } else {
                                                            echo "bg-danger";
                                                            $diff = $reciperow['ingredientquantity'] - $reciperow['quantity'];
                                                            $isCraftable = false;
                                                        }
                                                        if ($reciperow['quantity'] == null) {
                                                            echo "'><td>0/".$reciperow['ingredientquantity']."</td><td>";
                                                        } else {
                                                            echo "'><td>".$reciperow['quantity']."/".$reciperow['ingredientquantity']."</td><td>";
                                                        }
                                                        if ($reciperow['type'] == 'b-craft') {
                                                            echo "<b>";
                                                        }
                                                        if ($reciperow['quantity'] < $reciperow['ingredientquantity']) {
                                                            echo "<a class='scavengerLink' target='_blank' href='https://jabberwock-isle.com/itemsearch.php?iid=".$reciperow['itemid']."'>";
                                                        }
                                                        echo $reciperow['itemname'];
                                                        if ($reciperow['quantity'] < $reciperow['ingredientquantity']) {
                                                            echo "</a>";
                                                        }
                                                        if ($reciperow['type'] == 'b-craft') {
                                                            echo " <i class='far fa-star'></i></b>";
                                                            if ($diff > 0) {
                                                                printNestedRecipe($conn, $userrow['userid'], $reciperow['ingredientid'], $diff);
                                                            }
                                                        }
                                                        echo "</td></tr>";
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if ($isCraftable) { ?>
                                    <div class="list-group-item">
                                        <a id="craftAssignment<?php echo $row['itemid']; ?>" href="javascript:void(0)" data-toggle="modal" data-target="#confirmCraftingModal" class="btn btn-sm btn-block card-link craftAssignment">Craft Item</a>
                                    </div>
                                <?php } ?>
                            </div>
                <?php   }
                    } else {
                        echo "You are not crafting anything";
                    }
                ?>
            </div>
            <div class="col-lg-3 col-md-3">
                <h4 class='inventorySectionTitle'>Gifts</h4>
                <div style="display: flex; flex-direction: column">
                    <?php
                        $sql = "SELECT * FROM inventories,items WHERE inventories.itemid=items.itemid AND inventories.ownerid=".$userrow['userid']." AND type='a-gift' ORDER BY itemname;";
                        $result = mysqli_query($conn, $sql);
                        $inventoryMap = array();
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $inventoryMap[$row['itemid']] = array("quantity"=>$row['quantity'], "itemid"=>$row['itemid'], "itemname"=>$row['itemname'], "itemimage"=>$row['itemimage']);
                            }
                        }
                        $sql = "SELECT giftsinventories.studentid as studentid,giftsinventories.note as note,giftsinventories.giftid as giftid, items.itemid as itemid, items.itemname as itemname,items.itemimage as itemimage,students.studentname as studentname, students.studentsprite as studentsprite FROM giftsinventories LEFT JOIN items ON items.itemid=giftsinventories.itemid LEFT JOIN students ON students.studentid=giftsinventories.studentid WHERE giftsinventories.userid=".$userrow['userid']." ORDER BY giftsinventories.studentid,giftsinventories.giftid;";
                        $result = mysqli_query($conn, $sql);
                        $currStudentID = "";
                        if (mysqli_num_rows($result) > 0) {
                            echo '<div class="card" style="order:2">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                if (($currStudentID != "") && ($currStudentID != $row['studentid'])) {
                                    echo '</div><div class="card" style="order:2">';
                                    echo '<div class="giftCardTitleItem"><h5 class="giftCardTitle"><img src="studentsprites/originalsprites/'.$row['studentsprite'].'"> '.$row['studentname'].'</h5></div>';
                                } else if ($currStudentID == "") {
                                    echo '<div class="giftCardTitleItem"><h5 class="giftCardTitle"><img src="studentsprites/originalsprites/'.$row['studentsprite'].'"> '.$row['studentname'].'</h5></div>';
                                }
                                $currStudentID = $row['studentid'];
                                echo '<div class="giftRow">';
                                echo '<div class="giftImg"><img id="gift'.$row['giftid'].'img" src="'.$row['itemimage'].'"></div>';
                                echo '<div class="flexFill giftInfo"><p><b id="gift'.$row['giftid'].'itemname">'.$row['itemname'].'</b></p><p id="gift'.$row['giftid'].'note" class="text-muted">'.$row['note'].'</p></div>';
                                echo '<span id="gift'.$row['giftid'].'studentid" style="display: none">'.$currStudentID.'</span>';
                                echo '<div class="giftEdit">';
                                echo '<a id="gift'.$row['giftid'].'" class="giftEditModalTrigger" href="javascript:void(0)" data-toggle="modal" data-target="#editGiftModal"><i class="fas fa-pen"></i></a>';
                                echo '<a id="giftRemove'.$row['giftid'].'" class="giftRemoveModalTrigger" href="javascript:void(0)" data-toggle="modal" data-target="#removeGiftModal"><i class="fas fa-trash-alt"></i></a>';
                                echo '</div>';
                                echo '</div>';
                                $inventoryMap[$row['itemid']]['quantity'] -= 1;
                            }
                            echo '</div>';
                        }
                        $printedTitleCard = False;
                        foreach ($inventoryMap as $inventoryRow) {
                            if ($inventoryRow['quantity'] > 0) {
                                if (!$printedTitleCard) {
                                    echo '<div class="card" style="background-color: #f6d6e9; order: 1">';
                                    echo '<div class="giftCardTitleItem" style="background-color: #FE2181 !important"><h5 class="giftCardTitle">Unassigned</h5></div>';
                                    $printedTitleCard = True;
                                }
                                for ($j = 0; $j < $inventoryRow['quantity']; $j++) {
                                    echo '<div class="giftRow">';
                                    echo '<div class="giftImg"><img id="unassignedgift'.$inventoryRow['itemid'].'img" src="'.$inventoryRow['itemimage'].'"></div>';
                                    echo '<div class="flexFill giftInfo"><p><b id="unassignedgift'.$inventoryRow['itemid'].'itemname">'.$inventoryRow['itemname'].'</b></p></div>';
                                    echo '<div class="giftEdit">';
                                    echo '<a id="unassignedgift'.$inventoryRow['itemid'].'" class="giftAssignModalTrigger" href="javascript:void(0)" data-toggle="modal" data-target="#assignGiftModal"><i class="fas fa-plus"></i></a>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }
                        if ($printedTitleCard) {
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
<?
    }
}
?>

<div class="modal fade" id="additemModal" tabindex="-1" role="dialog" aria-labelledby="additemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="additemModalLabel">Add Item to Inventory</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <button id="decrementAdd" class="btn btn-primary"><i class="fas fa-minus"></i></button>
                <button id="addQuantity" class="btn btn-outline-primary" disabled>1</button>
                <button id="incrementAdd" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                <select id="addItemID" class="form-control" style="display: inline-block; width: auto">
                    <?php
                        $sql = "SELECT DISTINCT itemid,itemname FROM items ORDER BY itemname;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $currentrecipeid = "START";
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['itemid']."'>".$row['itemname']."</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="addItem" class="btn btn-primary">Add Item</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="removeitemModal" tabindex="-1" role="dialog" aria-labelledby="removeitemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeitemModalLabel">Remove Item from Inventory</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <button id="decrementRemove" class="btn btn-danger"><i class="fas fa-minus"></i></button>
                <button id="removeQuantity" class="btn btn-outline-danger" disabled>1</button>
                <button id="incrementRemove" class="btn btn-danger"><i class="fas fa-plus"></i></button>
                <select id="removeItemID" class="form-control" style="display: inline-block; width: auto">
                    <?php
                        $sql = "SELECT DISTINCT itemid,itemname FROM items WHERE type!='a-gift' ORDER BY itemname;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $currentrecipeid = "START";
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['itemid']."'>".$row['itemname']."</option>";
                            }
                        }
                    ?>
                </select>
                <p>NOTE: You can't remove gifts through here anymore. You can only remove gifts through the trash can icon in the Gifts section.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="removeItem" class="btn btn-danger">Remove Item</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeAssignmentsModal" tabindex="-1" role="dialog" aria-labelledby="changeAssignmentsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeAssignmentsModalLabel">Track New Crafting Recipe</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <select id="newAssignment" class="form-control">
                    <?php
                        $sql = "SELECT DISTINCT itemid,itemname FROM recipes,items WHERE recipes.recipeid=items.itemid ORDER BY itemname;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $currentrecipeid = "START";
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['itemid']."'>".$row['itemname']."</option>";
                            }
                        }
                    ?>
                </select>
                <p>You are able to craft any of the items below:</p>
                <?php
                    $sql = "SELECT recipeid, itemname as recipename, ingredientquantity as requiredquantity, quantity as studentquantity, type FROM recipes LEFT JOIN items ON recipes.recipeid=items.itemid LEFT JOIN inventories ON recipes.ingredientid=inventories.itemid AND inventories.ownerid=".$_SESSION['user']->getID()." ORDER BY recipeid;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $recipeid = NULL;
                        $recipename = "";
                        $recipetype = "";
                        $isCraftable = True;
                        while ($row = mysqli_fetch_assoc($result)) {
                            if (($recipeid != NULL) && ($recipeid != $row['recipeid'])) {
                                if ($isCraftable) {
                                    echo "<button id='craftableAssignment".$recipeid."' class='craftableAssignment btn btn-sm ";
                                    if ($recipetype == "a-gift") {
                                        echo "btn-success";
                                    } else {
                                        echo "btn-outline-success";
                                    }
                                    echo "'>".$recipename."</button>";
                                }
                                $isCraftable = True;
                            }
                            $recipeid = $row['recipeid'];
                            $recipename = $row['recipename'];
                            $recipetype = $row['type'];
                            if ($row['studentquantity'] < $row['requiredquantity']) {
                                $isCraftable = False;
                            }
                        }
                    }
                ?>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="addNewAssignment" class="btn btn-success">Add Recipe</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmCraftingModal" tabindex="-1" role="dialog" aria-labelledby="confirmCraftingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmCraftingModalLabel">Confirm Crafting Item</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="craftAssignmentConfirm-recipeID" style="display:none"></span>
                You will craft <b>1 <span id="craftAssignmentConfirm-recipeName"></span></b>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="craftAssignmentConfirm" class="btn btn-primary">Craft Item</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="primaryStudentModal" tabindex="-1" role="dialog" aria-labelledby="primaryStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="primaryStudentModalLabel">Primary Student</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Your primary student is the character you designate to be the person crafting items on your behalf. For example, if <b>Texas Tom</b> is your primary student, then the points from crafting items would go towards the <b>Junior Class</b> and <b>Team Vampire</b>.</p>
                <p>You can change your primary student in your <b>Settings</b>.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editGiftModal" tabindex="-1" role="dialog" aria-labelledby="editGiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGiftModalLabel">Edit Gift</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="giftRow">
                        <div id="editGiftModal_giftImg" class="giftModalImg"></div>
                        <div class="flexFill giftInfo">
                            <span id="editGiftModal_giftid" style="display: none"></span>
                            <p><b id="editGiftModal_itemname"></b></p>
                            <p id="editGiftModal_note" class="text-muted"></p>
                        </div>
                    </div>
                </div>
                <label>Change Student</label>
                <?php
                echo '<select id="changeGiftStudent" class="form-control">';
                $studentsql = "SELECT studentid,studentname FROM students WHERE ownerid=".$_SESSION['user']->getID().";";
                $studentresult = mysqli_query($conn, $studentsql);
                if (mysqli_num_rows($studentresult) > 0) {
                    while ($studentsqlrow = mysqli_fetch_assoc($studentresult)) {
                        echo "<option value='".$studentsqlrow['studentid']."'";
                        if ($studentsqlrow['studentid'] == $row['mainstudentid']) {
                            echo " selected";
                        }
                        echo ">".$studentsqlrow['studentname']."</option>";
                    }
                }
                echo '</select>';
                ?>
                <label>Change Note</label>
                <textarea id="newGiftNote" class="form-control" rows="2"></textarea>
                <p id="newGiftNoteSize" class="text-muted">0/140</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="editGiftConfirm" class="btn btn-primary">Edit Note</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="removeGiftModal" tabindex="-1" role="dialog" aria-labelledby="removeGiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeGiftModalLabel">Remove Gift</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="giftRow">
                        <div id="removeGiftModal_giftImg" class="giftModalImg"></div>
                        <div class="flexFill giftInfo">
                            <span id="removeGiftModal_giftid" style="display: none"></span>
                            <p><b id="removeGiftModal_itemname"></b></p>
                            <p id="removeGiftModal_note" class="text-muted"></p>
                        </div>
                    </div>
                </div>
                <p>Are you sure you want to remove this gift?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="removeGiftConfirm" class="btn btn-danger">Remove Gift</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignGiftModal" tabindex="-1" role="dialog" aria-labelledby="assignGiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignGiftModalLabel">Assign Gift</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="giftRow">
                        <div id="assignGiftModal_giftImg" class="giftModalImg"></div>
                        <div class="flexFill giftInfo">
                            <span id="assignGiftModal_giftid" style="display: none"></span>
                            <p><b id="assignGiftModal_itemname"></b></p>
                            <p id="assignGiftModal_note" class="text-muted"></p>
                        </div>
                    </div>
                </div>
                <label>Select Student</label>
                <?php
                echo '<select id="assignGiftStudent" class="form-control">';
                $studentsql = "SELECT studentid,studentname FROM students WHERE ownerid=".$_SESSION['user']->getID().";";
                $studentresult = mysqli_query($conn, $studentsql);
                if (mysqli_num_rows($studentresult) > 0) {
                    while ($studentsqlrow = mysqli_fetch_assoc($studentresult)) {
                        echo "<option value='".$studentsqlrow['studentid']."'";
                        if ($studentsqlrow['studentid'] == $row['mainstudentid']) {
                            echo " selected";
                        }
                        echo ">".$studentsqlrow['studentname']."</option>";
                    }
                }
                echo '</select>';
                ?>
                <label>Add Note</label>
                <textarea id="assignGiftNote" class="form-control" rows="2"></textarea>
                <p id="assignGiftNoteSize" class="text-muted">0/140</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="assignGiftConfirm" class="btn btn-primary">Assign Gift</button>
            </div>
        </div>
    </div>
</div>

<script>
$("#decrementRemove").click(function() {
    var removeQuantity = parseInt($("#removeQuantity").text());
    if (removeQuantity > 1) {
        $("#removeQuantity").text(removeQuantity-1);
    }
});
$("#incrementRemove").click(function() {
    var removeQuantity = parseInt($("#removeQuantity").text());
    $("#removeQuantity").text(removeQuantity+1);
});
$("#decrementAdd").click(function() {
    var addQuantity = parseInt($("#addQuantity").text());
    if (addQuantity > 1) {
        $("#addQuantity").text(addQuantity-1);
    }
});
$("#incrementAdd").click(function() {
    var addQuantity = parseInt($("#addQuantity").text());
    $("#addQuantity").text(addQuantity+1);
});
$("#addItem").click(function() {
    $.post("addItemToInventory.php", {
        addItemID: $("#addItemID").val(),
        addItemname: $("#addItemID option:selected").text(),
        addItemQuantity: $("#addQuantity").text()
        }, function(result) {
            location.reload();
    });
});
$("#removeItem").click(function() {
    $.post("removeItemFromInventory.php", {
        removeItemID: $("#removeItemID").val(),
        removeItemname: $("#removeItemID option:selected").text(),
        removeItemQuantity: $("#removeQuantity").text()
        }, function(result) {
            if (result == "SUCCESS") {
                location.reload();
            } else {
                alert(result);
            }
    });
});
$("#addNewAssignment").click(function() {
    $.post("addNewAssignment.php", {newAssignmentID: $("#newAssignment").val()}, function(result) {
        location.reload();
    });
});
$(".craftableAssignment").click(function() {
    $("#newAssignment").val($(this).attr("id").replace("craftableAssignment",""));
});
$(".removeAssignment").click(function() {
    $("#" + $(this).attr("id") + "Card").slideUp();
    $.post("removeAssignment.php", {removeAssignmentID: $(this).attr("id").replace("removeAssignment","")}, function(result) {
        //location.reload();
    });
});
$(".craftAssignment").click(function() {
    var recipeid = $(this).attr("id").replace("craftAssignment","");
    $("#craftAssignmentConfirm-recipeID").text(recipeid);
    $("#craftAssignmentConfirm-recipeName").text($("#craftAssignmentName" + recipeid).text());
});
$("#craftAssignmentConfirm").click(function() {
    $.post("craftAssignment.php", {recipeID: $("#craftAssignmentConfirm-recipeID").text(), recipeName: $("#craftAssignmentConfirm-recipeName").text()}, function(result) {
        location.reload();
    });
});
newGiftNote
$("#newGiftNote").bind('input propertychange', function() {
    $("#newGiftNoteSize").text($("#newGiftNote").val().length + "/140");
    if ($("#newGiftNote").val().length > 140) {
        $("#newGiftNoteSize").addClass("text-danger");
        $("#newGiftNoteSize").removeClass("text-muted");
    } else {
        $("#newGiftNoteSize").removeClass("text-danger");
        $("#newGiftNoteSize").addClass("text-muted");
    }
});
$("#assignGiftNote").bind('input propertychange', function() {
    $("#assignGiftNoteSize").text($("#assignGiftNote").val().length + "/140");
    if ($("#assignGiftNote").val().length > 140) {
        $("#assignGiftNoteSize").addClass("text-danger");
        $("#assignGiftNoteSize").removeClass("text-muted");
    } else {
        $("#assignGiftNoteSize").removeClass("text-danger");
        $("#assignGiftNoteSize").addClass("text-muted");
    }
});
$(".giftEditModalTrigger, .giftRemoveModalTrigger, .giftAssignModalTrigger").click(function() {
    var currClass = $(this).attr("class");
    var currType = "";
    var currGift = $(this).attr("id");
    if (currClass == "giftEditModalTrigger") {
        currType = "edit";
        $("#changeGiftStudent").val($("#"+currGift+"studentid").text());
        $("#newGiftNote").val($("#"+currGift+"note").text());
        $("#newGiftNoteSize").text($("#newGiftNote").val().length + "/140");
    } else if (currClass == "giftRemoveModalTrigger") {
        currType = "remove";
        currGift = currGift.replace("giftRemove","gift");
    } else if (currClass == "giftAssignModalTrigger") {
        currType = "assign";
        $("#assignGiftNote").val("");
        $("#assignGiftNoteSize").text($("#assignGiftNote").val().length + "/140");
    }
    $("#"+currType+"GiftModal_giftid").text(currGift);
    $("#"+currType+"GiftModal_itemname").text($("#"+currGift+"itemname").text());
    $("#"+currType+"GiftModal_note").text($("#"+currGift+"note").text());
    $("#"+currType+"GiftNote").val("");
    $("#"+currType+"GiftModal_giftImg").css("background-image","url("+$("#"+currGift+"img").prop("src")+")");
});
$("#editGiftConfirm").click(function() {
    if ($("#newGiftNote").val().length <= 140) {
        $.post("editGiftNote.php", {
            giftid: $("#editGiftModal_giftid").text(),
            studentid: $("#changeGiftStudent").val(),
            newgiftnote: $("#newGiftNote").val()
        }, function(result) {
            location.reload();
        });
    }
});
$("#removeGiftConfirm").click(function() {
    $.post("removeGift.php", {giftid: $("#removeGiftModal_giftid").text()}, function(result) {
        location.reload();
    });
});
$("#assignGiftConfirm").click(function() {
    if ($("#assignGiftNote").val().length <= 140) {
        // assignGiftModal_giftid is actually the itemid from `items` and not the giftid from `giftsinventories`
        $.post("assignGift.php", {
            studentid: $("#assignGiftStudent").val(),
            itemid: $("#assignGiftModal_giftid").text(),
            giftnote: $("#assignGiftNote").val()
        }, function(result) {
            location.reload();
        });
    }
});
</script>
