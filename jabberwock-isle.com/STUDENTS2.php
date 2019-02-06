<?php
include_once('header.php');
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
<?php
$activeStudentID = 1;
if (isset($_GET['sid'])) {
    $activeStudentID = $_GET['sid'];
} else {
    $firststudentsql = mysqli_query($conn, "SELECT studentid FROM students ORDER BY studentname LIMIT 1;");
    $firststudentrow = mysqli_fetch_assoc($firststudentsql);
    $activeStudentID = $firststudentrow['studentid'];
}
?>

<div class="container-fluid">
    <h1 class="text-center">Students</h1>
    <ul class="nav nav-tabs tabNav" id="myTab" role="tablist">
        <?php
        $sql = "SELECT * FROM students ORDER BY studentname;";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<li class="nav-item tabItem">';
                echo '<a class="nav-link';
                if ($row['studentid'] == $activeStudentID) {
                    echo ' active';
                }
                echo ' tabLink';
                if ($row['isAlive'] == 0) {
                    echo ' deadStudentTab';
                }
                echo '" id="student'.$row['studentid'].'Tab" data-toggle="tab" href="#student'.$row['studentid'].'" role="tab" aria-controls="student'.$row['studentid'].'" aria-selected="false"><img class="studentTabIcon studentTabIconBuffer" src="studentsprites/originalsprites/'.$row['studentsprite'].'"> '.$row['studentname'];
                echo '</a>';
                echo '</li>';
            }
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php
            $sql = "SELECT * FROM students ORDER BY studentname;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="tab-pane';
                    if ($row['studentid'] == $activeStudentID) {
                        echo ' show active';
                    }
                    echo '" id="student'.$row['studentid'].'" role="tabpanel" aria-labelledby="student'.$row['studentid'].'Tab">';
                    if ($row['isAlive'] == 0) {
                        echo '<p class="deadStudentTextRow">This student is dead.</p>';
                    }
                    echo '<div class="tab-pane-content">';
                    echo "<a target='_blank' href='".$row['studentapp']."'><button class='btn btn-light studentButton'><img src='studentsprites/originalsprites/".$row['studentsprite']."'> ".$row['studentname']." - ".$row['monocoins']." <img src='https://orig00.deviantart.net/910f/f/2018/105/6/6/mbc2_by_bootsii-dc8xg2k.png'></button></a>";
                    echo "<h4 class='inventorySectionTitle'>Gifts</h4>";
                    $giftsql = "SELECT * FROM giftsinventories LEFT JOIN items ON items.itemid=giftsinventories.itemid WHERE studentid=".$row['studentid']." ORDER BY itemname;";
                    $giftresult = mysqli_query($conn, $giftsql);
                    if (mysqli_num_rows($giftresult) > 0) {
                        echo '<div class="giftsWrapper">';
                        while ($giftrow = mysqli_fetch_assoc($giftresult)) {
                            echo '<div class="giftRow grayGiftRow">';
                            echo '  <div class="horizontalFlex">';
                            echo '    <a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="'.$giftrow['itemname'].'"><div class="giftImg"><img id="gift'.$giftrow['giftid'].'img" src="'.$giftrow['itemimage'].'"></div></a>';
                            echo '  </div>';
                            echo '  <div class="giftInfo"><p id="gift'.$giftrow['giftid'].'note" class="text-muted">'.$giftrow['note'].'</p></div>';
                            echo '  <span id="gift'.$giftrow['giftid'].'studentid" style="display: none">'.$currStudentID.'</span>';
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
<?php
include_once('footer.php');
?>
