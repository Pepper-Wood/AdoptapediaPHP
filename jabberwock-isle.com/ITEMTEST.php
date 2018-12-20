<?php
require('../util/User.php');
session_start();
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenJabberwockCon();
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
img {
    width: 40px;
    height: 40px;
}
</style>

<div class="card">
    <div class="card-body inventoryCard">
        <?php
            $sql = "SELECT * FROM items ORDER BY itemname;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['itemimage'] == null) {
                        echo "<img class='fullWidth' src='https://orig00.deviantart.net/a334/f/2018/305/9/2/useless_poo_by_yapipo-dcqw1w9.png'> ";
                    } else {
                        echo "<img class='fullWidth' src='".$row['itemimage']."'> ";
                    }
                    echo $row['itemid']." - ".$row['itemname']."<br>";
                }
            }
        ?>
    </div>
</div>

<?php
CloseCon($conn);
?>
