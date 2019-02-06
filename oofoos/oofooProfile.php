<?php
include_once('includes/header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();
?>

<div class="body">
    <div class="row">
        <?php
        include_once('includes/leftMenu.php');
        ?>
        <div class="col-sm-8">
            <?php
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'nameChange') {
                    echo "<div class='alert alert-success alert-dismissible show' role='alert'>";
                    echo "    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                    echo "        <span aria-hidden='true'>&times;</span>";
                    echo "    </button>";
                    echo "    Successfully changed your Oofoo's name.";
                    echo "</div>";
                }
            }
            ?>
            <div class="oofooCard">
            <?php
                if (isset($_GET['id'])) {
                    $sql = "SELECT * FROM oofoos, oofooPCs, siteusers WHERE oofoos.oofooid=".$_GET['id']." AND oofoos.oofooid=oofooPCs.oofooid AND siteusers.userid=oofooPCs.userid;";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<h3 class="oofooCardTitle">'.$row['theme'].'</h3>';
                            echo '<div class="oofooCardBody">';
                            echo '    <img src="includes/watermark.php?f='.base64_encode($row['img']).'" style="width:100%;height: 20em;object-fit: contain">';
                            echo '    <div class="oofooCardBody flextable flextable_2cols">';
                            echo "    <div class='flextable_cell'>";
                            echo '        <p><b>Creator:</b> <a target="_blank" href="https://'.$row['creator'].'.deviantart.com">'.$row['creator'].'</a></p>';
                            echo '        <a target="_blank" href="'.$row['databaseUrl'].'"><p>Database URL</p></a>';
                            echo '        <p><u>'.$row['realm'].' Oofoo</u></p>';
                            $traitids = explode(",", $row['traits']);
                            foreach ($traitids as $traitid) {
                                $traitsql = "SELECT * FROM oofooTraits WHERE traitid=".$traitid.";";
                                $traitresult = mysqli_query($conn, $traitsql);
                                if (mysqli_num_rows($traitresult) > 0) {
                                    while ($traitrow = mysqli_fetch_assoc($traitresult)) {
                                        echo '    <p>'.$traitrow['rarityid'].') '.$traitrow['traitname'].' '.$traitrow['traitgroup'].'</p>';
                                    }
                                }
                            }
                            echo '    </div>';
                            echo "    <div class='flextable_cell'>";
                            if ((isset($_SESSION['user'])) && ($row['userid'] == $_SESSION['user']->getID())) {
                                echo "<p id='editNameTrigger'>Name: <b>".$row['name']."</b> <i class='fas fa-edit'></i></p>";
                                echo '<form id="editNameForm" action="includes/changeOofooName.php" method="post">';
                                echo '<input name="oofooID" type="hidden" value="'.$row['oofooid'].'">';
                                echo '<div class="horizontalFlex"><input type="text" class="flexGrow" name="newOofooName" placeholder="New Name">';
                                echo '<input type="submit" value="Submit"></div>';
                                echo '</form>';
                            } else {
                                echo "<p>Name: <b>".$row['name']."</b></p>";
                            }
                            echo "        <p>Owned by <b>".$row['username']."</b></p>";
                            if ($row['certifiedInGathering'] == 1) {
                                $currGatheringExp = $row['gatheringexp'];
                                $tiersql = "SELECT * FROM `dailyExpTiers` ORDER BY tierId;";
                                $tierresult = mysqli_query($conn, $tiersql);
                                $printedFlag = false;
                                while ($tierrow = mysqli_fetch_assoc($tierresult)) {
                                    if ($currGatheringExp >= $tierrow['tierExpNeeded']) {
                                        $currGatheringExp -= $tierrow['tierExpNeeded'];
                                    } else {
                                        echo '        <div class="horizontalFlex"><div>'.$tierrow['tierName'].' Gatherer</div><div>'.$currGatheringExp.'/'.$tierrow['tierExpNeeded'].' Exp.</div></div>';
                                        $percent = floor($currGatheringExp/$tierrow['tierExpNeeded']*100);
                                        echo '        <div class="progress">';
                                        echo '            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:'.$percent.'%">'.$percent.'%</div>';
                                        echo '        </div>';
                                        $printedFlag = true;
                                        break;
                                    }
                                }
                                if ($printedFlag == false) {
                                    echo '        <div class="horizontalFlex"><div>Ultimate Gatherer</div><div>750/750 Exp.</div></div>';
                                    echo '        <div class="progress">';
                                    echo '            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">100%</div>';
                                    echo '        </div>';
                                }
                            }
                            echo '    </div>';
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

<script>
$("#editNameTrigger").click(function() {
    $("#editNameForm").slideToggle();
});
</script>

<?php
include_once('includes/footer.php');
CloseCon($conn);
?>
