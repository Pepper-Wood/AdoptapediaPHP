<?php
include_once('includes/header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();
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
    <div class="row">
        <?php
        include_once('includes/leftMenu.php');
        ?>
        <div class="col-sm-8">
            <div class="oofooCard">
            <?php
                if (isset($_GET['id'])) {
                    $sql = "SELECT * FROM foos LEFT JOIN fooSpecies ON fooSpecies.speciesid=foos.speciesid WHERE fooid=".$_GET['id'].";";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<h3 class="oofooCardTitle">'.$row['theme'].'</h3>';
                            echo '<div class="oofooCardBody">';
                            echo '<img src="includes/watermark.php?f='.base64_encode($row['img']).'" style="width:100%;height: 20em;object-fit: contain">';
                            echo '<p><b>Owner:</b> <a target="_blank" href="https://deviantart.com/'.$row['ownername'].'">'.$row['ownername'].'</a></p>';
                            echo '<p><b>Creator:</b> <a target="_blank" href="https://deviantart.com/'.$row['creatorname'].'">'.$row['creatorname'].'</a></p>';
                            echo "<p><u>".$row['speciesname']."</u></p>";
                            $traitsql = "SELECT rarities.rarityname,rarities.rarityfullname,fooTraits.traitname FROM foosToTraits LEFT JOIN fooTraits ON fooTraits.traitid=foosToTraits.traitid LEFT JOIN rarities ON fooTraits.rarityid=rarities.rarityid WHERE foosToTraits.fooid=".$row['fooid'].";";
                            $traitresult = mysqli_query($conn, $traitsql);
                            if (mysqli_num_rows($traitresult) > 0) {
                                while ($traitrow = mysqli_fetch_assoc($traitresult)) {
                                    echo "<p><span class='raritybullet raritybullet".$traitrow['rarityname']."' title='".$traitrow['rarityfullname']."'></span> ".$traitrow['traitname']."</p>";
                                }
                            }
                            echo "<p>Oofoos are a closed species owned by <a href='deviantart.com/Pepper-Wood'>Pepper-Wood</a>. <a href='tos.php'>Terms of Service</a></p>";
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
            </div>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.php');
CloseCon($conn);
?>
