<?php
include_once('header.php');

function printNestedRecipe($conn, $userid, $ingredientid, $diff) {
    $recipesql = "SELECT * FROM recipes LEFT JOIN items ON items.itemid=recipes.ingredientid LEFT JOIN inventories ON inventories.itemid=recipes.ingredientid  AND inventories.ownerid=".$userid." WHERE recipes.recipeid=".$ingredientid." ORDER BY items.itemname;";
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
            echo $reciperow['itemname'];
            if ($reciperow['type'] == 'b-craft') {
                echo " <i class='far fa-star'></i></b>";
                if ($newDiff > 0) {
                    printNestedRecipe($conn, $userrow['userid'], $reciperow['ingredientid'], $diff);
                }
            }
        }
        echo "</tbody></table>";
    }
}
?>
<div class="container-fluid">
    <h1 class="text-center">Inventories</h1>
View Inventory of
<select id="inventorySelect">
<?php
$sql = "SELECT userid,username FROM siteusers WHERE type != 'user' ORDER BY username;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo "<option value='all'>--View All--</option>";
    while ($row = mysqli_fetch_assoc($result)) { ?>
        <option value="<?php echo $row['userid']; ?>"<?php if ((isset($_GET['uid'])) && ($_GET['uid'] == $row['userid'])) { echo " selected"; }?>><?php echo $row['username']; ?></option>
<?  }
}
echo "</select><br><hr>";

$usersql = "SELECT * FROM siteusers WHERE type!='user' ";
if (isset($_GET['uid'])) {
    $usersql .= "AND siteusers.userid=".$_GET['uid']." ";
}
$usersql .= "ORDER BY username;";
$userresult = mysqli_query($conn, $usersql);
if (mysqli_num_rows($userresult) > 0) {
    while ($userrow = mysqli_fetch_assoc($userresult)) { ?>
        <div class="studentHeader">
            <?php echo "<a target='_blank' href='https://www.deviantart.com/".$userrow['username']."'>".$userrow['username']; ?></a>
            <?php
                $sql = "SELECT * FROM students WHERE ownerid=".$userrow['userid'].";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<a target='_blank' href='".$row['studentapp']."'><button class='btn btn-light studentButton'><img src='".$row['studentsprite']."'> ".$row['studentname']." - ".$row['monocoins']." <img src='https://orig00.deviantart.net/910f/f/2018/105/6/6/mbc2_by_bootsii-dc8xg2k.png'></button></a>";
                    }
                }
            ?>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h4 class='inventorySectionTitle'>Inventory</h4>
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
                <h4 class='inventorySectionTitle'>Crafting</h4>
                <?php
                    $sql = "SELECT * FROM assignments LEFT JOIN items ON assignments.recipeid=items.itemid WHERE ownerid=".$userrow['userid'].";";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['itemname']; ?></h5>
                                    <table class="table table-sm">
                                        <tbody>
                                            <?php
                                                $recipesql = "SELECT * FROM recipes LEFT JOIN items ON items.itemid=recipes.ingredientid LEFT JOIN inventories ON inventories.itemid=recipes.ingredientid  AND inventories.ownerid=".$userrow['userid']." WHERE recipes.recipeid=".$row['recipeid'].";";
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
                                                        }
                                                        if ($reciperow['quantity'] == null) {
                                                            echo "'><td>0/".$reciperow['ingredientquantity']."</td><td>";
                                                        } else {
                                                            echo "'><td>".$reciperow['quantity']."/".$reciperow['ingredientquantity']."</td><td>";
                                                        }
                                                        if ($reciperow['type'] == 'b-craft') {
                                                            echo "<b>";
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
                            </div>
                <?php   }
                    }
                ?>
            </div>
            <div class="col-lg-3 col-md-3">
                <h4 class='inventorySectionTitle'>Gifts</h4>
                <?php
                    $sql = "SELECT * FROM inventories,items WHERE inventories.itemid=items.itemid AND inventories.ownerid=".$userrow['userid']." AND type='a-gift' ORDER BY itemname;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['quantity'] > 0) { ?>
                                <a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="<?php echo $row['itemname']; ?>"><img class="giftIcon" src="<?php echo $row['itemimage']; ?>"></a>
                <?php       }
                        }
                    }
                ?>
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
                        $sql = "SELECT giftsinventories.studentid as studentid,giftsinventories.note as note,giftsinventories.giftid as giftid, items.itemid as itemid, items.itemname as itemname,items.itemimage as itemimage,students.studentname as studentname, students.studentsprite as studentsprite FROM giftsinventories LEFT JOIN items ON items.itemid=giftsinventories.itemid LEFT JOIN students ON students.studentid=giftsinventories.studentid WHERE giftsinventories.userid=".$userrow['userid']." ORDER BY giftsinventories.studentid;";
                        $result = mysqli_query($conn, $sql);
                        $currStudentID = "";
                        if (mysqli_num_rows($result) > 0) {
                            echo '<div class="card" style="order:2">';
                            while ($row = mysqli_fetch_assoc($result)) {
                                if (($currStudentID != "") && ($currStudentID != $row['studentid'])) {
                                    echo '</div><div class="card" style="order:2">';
                                    echo '<div class="giftCardTitleItem"><h5 class="giftCardTitle"><img src="'.$row['studentsprite'].'"> '.$row['studentname'].'</h5></div>';
                                } else if ($currStudentID == "") {
                                    echo '<div class="giftCardTitleItem"><h5 class="giftCardTitle"><img src="'.$row['studentsprite'].'"> '.$row['studentname'].'</h5></div>';
                                }
                                $currStudentID = $row['studentid'];
                                echo '<div class="giftRow">';
                                echo '<div class="giftImg"><img id="gift'.$row['giftid'].'img" src="'.$row['itemimage'].'"></div>';
                                echo '<div class="flexFill giftInfo"><p><b id="gift'.$row['giftid'].'itemname">'.$row['itemname'].'</b></p><p id="gift'.$row['giftid'].'note" class="text-muted">'.$row['note'].'</p></div>';
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
<?  }
}
?>
</div>

<script>
$("#inventorySelect").change(function() {
    if ($(this).val() == "all") {
        window.location.href = "https://adoptapedia.com/Jabberwock/inventories.php";
    } else {
        window.location.href = "https://adoptapedia.com/Jabberwock/inventories.php?uid=" + $(this).val();
    }
});
</script>

<?php
include_once('footer.php');
?>
