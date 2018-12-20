<?php
include_once('header.php');
?>
<style>
.raritybullet {
    display: inline-block;
    margin-right: 3px;
    width: 10px;
    height: 10px;
    border-radius: 100%;
}
.raritybulletcommon { background-color: #0093ff; }
.raritybulletuncommon { background-color: #25a21b; }
.raritybulletrare { background-color: #ff42a5; }
.raritybulletultrarare { background-color: #ff4200; }
.raritybulletlegendary { background-color: #ffb100; }
</style>

<div class="body">
    <?php
    if (isset($_GET['id'])) {
        $sql = "SELECT * FROM masterlist LEFT JOIN species ON species.speciesid=masterlist.speciesid WHERE charaid=".$_GET['id'].";";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<h3 class="oofooCardTitle">'.$row['charaid'].' - '.$row['visualid'].'</h3>';
                echo '<div class="oofooCardBody">';
                echo '<img src="'.$row['charaimg'].'" style="width:100%;height: 20em;object-fit: contain">';
                echo '<p><b>Owner:</b> <a target="_blank" href="https://deviantart.com/'.$row['ownername'].'">'.$row['ownername'].'</a></p>';
                echo '<p><b>Designer:</b> <a target="_blank" href="https://deviantart.com/'.$row['designername'].'">'.$row['designername'].'</a></p>';
                echo "<p><u>".$row['speciesname']."</u></p>";

                $itemssql = "SELECT * FROM inventories LEFT JOIN items ON items.itemid=inventories.itemid WHERE charaid=".$_GET['id'].";";
                $itemsresult = mysqli_query($conn, $itemssql);
                if (mysqli_num_rows($itemsresult) > 0) {
                    while ($itemsrow = mysqli_fetch_assoc($itemsresult)) {
                        echo $itemsrow['quantity']." x <img src='".$itemsrow['itemimage']."'><br>";
                    }
                }
                echo '</div>';
            }
        }
    } else {
        echo '<h3 class="oofooCardTitle">Error</h3>';
        echo '<div class="oofooCardBody">';
        echo '    <p>Invalid Oofoo ID provided.</p>';
        echo '</div>';
    }
    ?>
</div>

<?php
include_once('footer.php');
?>
