<?php
include_once('includes/header.php');
?>

<div class="body">
    <div class="row">
        <?php
        include_once('includes/leftMenu.php');
        ?>
        <div class="col-sm-8">
            <div class="oofooCard">
                <h3 class="oofooCardTitle">Bank</h3>
                <?php
                    $sql ="SELECT siteusers.username as username, items.itemid as itemid, items.name as name, items.img as img, siteuserInventories.quantity as quantity FROM siteuserInventories, siteusers, items WHERE siteuserInventories.itemid=items.itemid AND siteusers.userid=siteuserInventories.userid AND siteuserInventories.quantity!=0 ORDER BY username, itemid;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        $currUser = "";
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($currUser != $row['username']) {
                                if ($currUser != "") {
                                    echo "</div>";
                                }
                                $currUser = $row['username'];
                                echo "<div class='list-group-item'>";
                                echo "<p>".$row['username']."</p>";
                            }
                            echo '<a href="javascript:void(0)" data-toggle="tooltip" title="'.$row['name'].'">';
                            echo "<div class='bankIcon'>";
                            echo "	<img class='fullWidth' src='images/items/".$row['img']."'>";
                            echo "	<span class='inventoryQuantity'>".$row['quantity']."</span>";
                            echo "</div></a>";
                        }
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.php');
?>
