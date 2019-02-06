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

<?php
$timezonesql = mysqli_query($conn, "SELECT timezone FROM siteusersettings WHERE userid=".$_SESSION['user']->getID().";");
$timezonerow = mysqli_fetch_assoc($timezonesql);
$usertimezone = $timezonerow['timezone'];
date_default_timezone_set($usertimezone);
?>

<style>
.tabNav {
    overflow: auto;
    white-space: nowrap;
    display: block;
    padding-left: 5px;
    overflow-y: hidden;
    font-family: GoodbyeDespair;
    border-bottom: 0;
}
.nav-tabs .tabItem.show .tabLink, .nav-tabs .tabLink.active {
    color: #000;
}
.nav-tabs .tabLink.active {
    box-shadow: 0 1px 1px 0 rgba(60,64,67,.08), 0 1px 3px 1px rgba(60,64,67,.16);
    transition: box-shadow 135ms cubic-bezier(.4,0,.2,1);
    border: 0;
}
.nav-tabs .tabItem {
    display: inline-block;
    margin-right: 2px;
}
.nav-tabs .tabLink {
    border-color: #e9ecef #e9ecef #dee2e6;
}
.studentTabIcon {
    height: 33px;
    display: inline-block;
    object-fit: contain;
}
.studentTabIconBuffer {
    margin-right: 5px;
}
.tabLink {
    height: 100%;
    display: flex;
    align-items: center;
}
.primaryStudentTab {
    background-color: rgba(255, 193, 7, 0.25);
}
.primaryStudentTab.active {
    background-color: rgba(255, 193, 7, 1) !important;
}
.primaryStudentTextRow {
    padding: 5px;
    background-color: rgba(255, 193, 7, 1);
}
.deadStudentTab {
    background-color: rgba(249, 215, 231, 0.25);
    color: #ff2d7d;
    text-decoration: line-through;
}
.deadStudentTab:hover {
    color: #c72d68;
    text-decoration: line-through;
}
.deadStudentTab.active {
    background-color: rgba(249, 215, 231, 1) !important;
    color: #ff2d7d !important;
    text-decoration: line-through;
}
.deadStudentTextRow {
    padding: 5px;
    background-color: rgba(249, 215, 231, 1);
    color: #ff2d7d;
}
.tab-pane {
    background-color: #FFF;
    box-shadow: 0 1px 1px 0 rgba(60,64,67,.08), 0 1px 3px 1px rgba(60,64,67,.16);
    transition: box-shadow 135ms cubic-bezier(.4,0,.2,1);
    margin-left: 5px;
}
.tab-pane-content {
    padding: 5px;
}
.inventoryCard {
    background-color: #909294;
}
.inventoryCell {
    display: inline-block;
    position: relative;
}
.inventoryQuantity {
    position: absolute;
    top: 0;
    left: 0;
    color: #FFEB3B;
    text-shadow: 1px 1px #1f2429;
    font-family: GoodbyeDespair;
    font-weight: bold;
    width: 15px;
    height: 15px;
    text-align: center;
    line-height: 15px;
    border-radius: 50%;
    font-size: 12px;
}
.giftsWrapper {
    column-count: 3;
    column-gap: 5px;
}
.weeklyAssignmentSubtitle {
    margin: 0;
    font-size: 12px;
    font-weight: bold;
}
.weeklyAssignmentCraftConfirm {
    color: #856404 !important;
    background-color: #fff3cd !important;
}
.grayGiftRow {
    background-color: #eee;
}
.recipeCardsWrapper {
    column-count: 2;
}
@media only screen and (max-width: 768px) {
    .recipeCardsWrapper {
        column-count: 1;
    }
}
.recipeCardsWrapper>.recipeCard {
    display: inline-block;
    width: 100%;
}
.recipeCard .card-body {
    padding: 0.5rem;
}
.weeklyAssignmentDoubleSubtitle {
    font-size: 12px;
    font-style: italic;
}
.birthdayCard {
    flex-direction: row;
}
</style>

<div class="row">
    <div class="col-md-3">
        <img class="fullWidth card" src="https://img00.deviantart.net/dcad/i/2018/305/5/d/tempstudentofthemonth_by_pepper_wood-dcqxwcq.png">
        <?php
        $birthdaysql = "SELECT studentname,studentsprite,birthday FROM students WHERE MONTH(birthday)=".date('m')." ORDER BY birthday;";
        $birthdayresult = mysqli_query($conn, $birthdaysql);
        if (mysqli_num_rows($birthdayresult) > 0) {
            while ($birthdayrow = mysqli_fetch_assoc($birthdayresult)) {
                echo "<div class='card birthdayCard horizontalFlex'>";
                echo "<img src='studentsprites/originalsprites/".$birthdayrow['studentsprite']."'>";
                echo "<div class='birthdayInfo'>";
                echo "<div>".$birthdayrow['studentname']."</div>";
                echo "<div>".date("jS", strtotime($birthdayrow['birthday']))."</div>";
                echo "</div></div>";
            }
        }
        ?>
        <p>Group Events</p>
    </div>
    <div class="col-md-9">
        <ul class="nav nav-tabs tabNav" id="myTab" role="tablist">
            <li class="nav-item tabItem">
                <a class="nav-link active tabLink" id="inventoryTab" data-toggle="tab" href="#inventory" role="tab" aria-controls="inventory" aria-selected="true"><div class="studentTabIcon"></div><?php echo $_SESSION['user']->getUsername()?></a>
            </li>
            <?php
            $primaryStudentSql = mysqli_query($conn, "SELECT studentid,studentname FROM siteusersettings LEFT JOIN students ON students.studentid=siteusersettings.mainstudentid WHERE userid=".$_SESSION['user']->getID().";");
            $primaryStudentRow = mysqli_fetch_assoc($primaryStudentSql);
            $sql = "SELECT * FROM students WHERE ownerid=".$_SESSION['user']->getID().";";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li class="nav-item tabItem">';
                    echo '<a class="nav-link tabLink';
                    if ($row['isAlive'] == 0) {
                        echo ' deadStudentTab';
                    }
                    if ($primaryStudentRow['studentid'] == $row['studentid']) {
                        echo ' primaryStudentTab';
                    }
                    echo '" id="student'.$row['studentid'].'Tab" data-toggle="tab" href="#student'.$row['studentid'].'" role="tab" aria-controls="student'.$row['studentid'].'" aria-selected="false"><img class="studentTabIcon studentTabIconBuffer" src="studentsprites/originalsprites/'.$row['studentsprite'].'"> '.$row['studentname'];
                    echo '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane show active" id="inventory" role="tabpanel" aria-labelledby="home-tab">
                <div class="tab-pane-content">
                    <?php
                    $usersql = "SELECT * FROM siteusers WHERE type!='user' AND siteusers.userid=".$_SESSION['user']->getID().";";
                    $userresult = mysqli_query($conn, $usersql);
                    if (mysqli_num_rows($userresult) > 0) {
                        while ($userrow = mysqli_fetch_assoc($userresult)) { ?>
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="horizontalFlex inventorySectionTitle">
                                        <h4 style="margin:0">Items</h4>
                                        <div>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#removeitemModal"><btn class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button></a>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#additemModal"><btn class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button></a>
                                        </div>
                                    </div>
                                    <?php
                                        $currmonocoinssql = mysqli_query($conn, "SELECT monocoins FROM siteusersettings WHERE userid=".$_SESSION['user']->getID().";");
                                        $currmonocoinsrow = mysqli_fetch_assoc($currmonocoinssql);
                                        $currmonocoins = $currmonocoinsrow['monocoins'];
                                    ?>
                                    <div class="card alert-warning" style="display: inline-block;padding: 10px;width: 100%;text-align: center;">
                                        You have <?php echo $currmonocoins; ?> <img src="https://orig00.deviantart.net/910f/f/2018/105/6/6/mbc2_by_bootsii-dc8xg2k.png">
                                    </div>
                                    <div style="display: flex; flex-direction: column">
                                        <?php
                                            $unassignedgiftssql = "SELECT items.itemid, items.itemname, items.itemimage, inventories.quantity, inventories.quantity-(SELECT COUNT(*) FROM giftsinventories WHERE giftsinventories.userid=".$userrow['userid']." AND giftsinventories.itemid=items.itemid) AS frequency FROM inventories LEFT JOIN items ON inventories.itemid=items.itemid WHERE items.type='a-gift' AND inventories.ownerid=".$userrow['userid']." ORDER BY leftoverquantity DESC, inventories.itemid;";
                                            $unassignedgiftsresult = mysqli_query($conn, $unassignedgiftssql);
                                            $printedTitleCard = False;
                                            if (mysqli_num_rows($unassignedgiftsresult) > 0) {
                                                while ($unassignedgiftsrow = mysqli_fetch_assoc($unassignedgiftsresult)) {
                                                    if ($unassignedgiftsrow['frequency'] > 0) {
                                                        if (!$printedTitleCard) {
                                                            echo '<div class="card" style="background-color: #f6d6e9; order: 1">';
                                                            echo '<div class="giftCardTitleItem" style="background-color: #FE2181 !important"><h5 class="giftCardTitle">Unassigned</h5></div>';
                                                            $printedTitleCard = True;
                                                        }
                                                        for ($j = 0; $j < $unassignedgiftsrow['frequency']; $j++) {
                                                            echo '<div class="giftRow">';
                                                            echo '  <div class="horizontalFlex">';
                                                            echo '    <a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="'.$unassignedgiftsrow['itemname'].'"><div class="giftImg"><img id="gift'.$unassignedgiftsrow['giftid'].'img" src="'.$unassignedgiftsrow['itemimage'].'"></div></a>';
                                                            echo '    <div style="margin-right: 20px">';
                                                            echo '      <a id="unassignedgift'.$unassignedgiftsrow['itemid'].'" class="giftAssignModalTrigger" href="javascript:void(0)" data-toggle="modal" data-target="#assignGiftModal"><i class="fas fa-plus"></i></a>';
                                                            echo '    </div>';
                                                            echo '  </div>';
                                                            echo '</div>';
                                                        }
                                                    }
                                                }
                                            }
                                            if ($printedTitleCard) {
                                                echo '</div>';
                                            }
                                        ?>
                                    </div>
                                    <div class="card">
                                        <div class="card-body inventoryCard">
                                            <?php
                                                $sql = "SELECT * FROM inventories,items WHERE inventories.itemid=items.itemid AND inventories.ownerid=".$userrow['userid']." AND type='b-craft' ORDER BY itemname;";
                                                $result = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        if ($row['quantity'] > 0) {
                                                            echo '<a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="'.$row['itemname'].'"><div class="inventoryCell">';
                                                            if ($row['itemimage'] == null) {
                                                                echo "<img class='fullWidth' src='https://orig00.deviantart.net/a334/f/2018/305/9/2/useless_poo_by_yapipo-dcqw1w9.png'> ";
                                                            } else {
                                                                echo "<img class='fullWidth' src='".$row['itemimage']."'> ";
                                                            }
                                                            echo '<span class="inventoryQuantity">'.$row['quantity'].'</span></div></a>';
                                                        }
                                                    }
                                                }
                                                echo "<hr>";
                                                $sql = "SELECT * FROM inventories,items WHERE inventories.itemid=items.itemid AND inventories.ownerid=".$userrow['userid']." AND type='c-raw' ORDER BY itemname;";
                                                $result = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        if ($row['quantity'] > 0) {
                                                            echo '<a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="'.$row['itemname'].'"><div class="inventoryCell">';
                                                            if ($row['itemimage'] == null) {
                                                                echo "<img class='fullWidth' src='https://orig00.deviantart.net/a334/f/2018/305/9/2/useless_poo_by_yapipo-dcqw1w9.png'> ";
                                                            } else {
                                                                echo "<img class='fullWidth' src='".$row['itemimage']."'> ";
                                                            }
                                                            echo '<span class="inventoryQuantity">'.$row['quantity'].'</span></div></a>';
                                                        }
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <div class="horizontalFlex inventorySectionTitle">
                                        <h4 style="margin:0">Crafting</h4>
                                        <div>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#changeAssignmentsModal"><btn class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button></a>
                                        </div>
                                    </div>
                                    <div class="recipeCardsWrapper">
                                        <?php
                                        $weeklyassignmentsql = mysqli_query($conn, "SELECT itemid,itemname,isDone FROM weeklyuserassignments LEFT JOIN items ON items.itemid=weeklyuserassignments.recipeid WHERE ownerid=".$_SESSION['user']->getID().";");
                                        $weeklyassignmentrow = mysqli_fetch_assoc($weeklyassignmentsql);
                                        if ($weeklyassignmentrow['isDone'] == 0) {
                                            $sunday = strtotime('next Sunday');
                                        ?>
                                        <div class="recipeCard"><div class="card alert-warning">
                                            <div class="card-body">
                                                <?php $isCraftable = true; ?>
                                                <p class="weeklyAssignmentSubtitle">Weekly Assignment</p>
                                                <div id="assignmentCountdown" class="weeklyAssignmentDoubleSubtitle">Loading...</div>
                                                <h5 id="craftAssignmentName<?php echo $weeklyassignmentrow['itemid']; ?>" class="card-title"><?php echo $weeklyassignmentrow['itemname']; ?></h5>
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <?php
                                                            $recipesql = "SELECT quantity,ingredientquantity,itemname,items.itemid as itemid,type,ingredientid FROM recipes LEFT JOIN items ON items.itemid=recipes.ingredientid LEFT JOIN inventories ON inventories.itemid=recipes.ingredientid  AND inventories.ownerid=".$userrow['userid']." WHERE recipes.recipeid=".$weeklyassignmentrow['itemid']." ORDER BY items.itemname;";
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
                                                <div class="list-group-item  weeklyAssignmentCraftConfirm">
                                                    <a id="craftAssignment<?php echo $weeklyassignmentrow['itemid']; ?>" href="javascript:void(0)" data-toggle="modal" data-target="#confirmCraftingModal" class="btn btn-sm btn-block card-link craftAssignment">Craft Item</a>
                                                </div>
                                            <?php } ?>
                                        </div></div>

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
                                            <div class="recipeCard"><div class="card alert-success">
                                                <div class="card-body">
                                                    <?php $isCraftable = true; ?>
                                                    <p class="weeklyAssignmentSubtitle">Weekly Assignment</p>
                                                    <div id="assignmentCountdown" class="weeklyAssignmentDoubleSubtitle">Completed</div>
                                                    <h5 class="card-title"><?php echo $weeklyassignmentrow['itemname']; ?></h5>
                                                </div>
                                            </div></div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                            $sql = "SELECT * FROM assignments LEFT JOIN items ON assignments.recipeid=items.itemid WHERE ownerid=".$userrow['userid'].";";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) { ?>
                                                    <div class="recipeCard"><div id='removeAssignment<?php echo $row['itemid']; ?>Card' class="card">
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
                                                    </div></div>
                                        <?php   }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                    <?
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
                $sql = "SELECT * FROM students WHERE ownerid=".$_SESSION['user']->getID().";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="tab-pane" id="student'.$row['studentid'].'" role="tabpanel" aria-labelledby="student'.$row['studentid'].'Tab">';
                        if ($row['isAlive'] == 0) {
                            echo '<p class="deadStudentTextRow">This student is dead.</p>';
                        }
                        if ($row['studentid'] == $primaryStudentRow['studentid']) {
                            echo '<p class="primaryStudentTextRow">This is your primary student <a href="javascript:void(0)" data-toggle="modal" data-target="#primaryStudentModal">[?]</a></p>';
                        }
                        echo '<div class="tab-pane-content">';
                        echo "<h4 class='inventorySectionTitle'>Gifts</h4>";
                        $giftsql = "SELECT * FROM giftsinventories LEFT JOIN items ON items.itemid=giftsinventories.itemid WHERE studentid=".$row['studentid']." ORDER BY itemname;";
                        $giftresult = mysqli_query($conn, $giftsql);
                        if (mysqli_num_rows($giftresult) > 0) {
                            echo '<div class="giftsWrapper">';
                            while ($giftrow = mysqli_fetch_assoc($giftresult)) {
                                echo '<div class="giftRow grayGiftRow">';
                                echo '  <div class="horizontalFlex">';
                                echo '    <a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="'.$giftrow['itemname'].'"><div class="giftImg"><img id="gift'.$giftrow['giftid'].'img" src="'.$giftrow['itemimage'].'"></div></a>';
                                echo '    <div class="giftEdit">';
                                echo '      <a id="gift'.$giftrow['giftid'].'" class="giftEditModalTrigger" href="javascript:void(0)" data-toggle="modal" data-target="#editGiftModal"><i class="fas fa-pen"></i></a>';
                                echo '      <a id="giftRemove'.$giftrow['giftid'].'" class="giftRemoveModalTrigger" href="javascript:void(0)" data-toggle="modal" data-target="#removeGiftModal"><i class="fas fa-trash-alt"></i></a>';
                                echo '    </div>';
                                echo '  </div>';
                                echo '  <div class="giftInfo"><p id="gift'.$giftrow['giftid'].'note" class="text-muted">'.$giftrow['note'].'</p></div>';
                                echo '  <span id="gift'.$giftrow['giftid'].'studentid" style="display: none">'.$giftrow['studentid'].'</span>';
                                echo '</div>';
                            }
                            echo "</div>";
                        }
                        echo '</div></div>';
                    }
                }
            ?>
        </div>
    </div>
</div>

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
    $("#" + $(this).attr("id") + "Card").parent().slideUp();
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
            $("#"+$("#editGiftModal_giftid").text()+"note").text($("#newGiftNote").val());
            //location.reload();
            $('#editGiftModal').modal('toggle');
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
