<?php
date_default_timezone_set('US/Eastern');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();
?>
<div class="col-sm-4">
    <div class="oofooCard">
        <?php
        if (isset($_SESSION['user'])) {
            echo "<h3 class='oofooCardTitle'>".$_SESSION['user']->getUsername()."'s Oofoos</h3>";
        } else {
            echo '<h3 class="oofooCardTitle">You are not logged in</h3>';
            echo "<div class='oofooCardBody'>";
            echo "    <p><a href='login.php'><button class='btn btn-deviantart'><i class='fab fa-deviantart'></i> Login</button></a></p>";
            echo "</div></div>";
        }
        ?>
        <?php
		if (isset($_SESSION['user'])) {
            $sql = "SELECT * FROM oofooPCs WHERE userid=".$_SESSION['user']->getID().";";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<div>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<a class="list-group-item" href="oofooProfile.php?id='.$row['oofooid'].'"><div class="horizontalFlex">';
                    echo '<div><img src="https://a.deviantart.net/avatars/o/o/oofoodatabase.gif?1"></div>';
                    echo '<div class="flexGrow padding">'.$row['name'].'';
                    if ($row['certifiedInGathering'] == 1) {
                        echo '<br>Gatherer';
                    }
                    if ($row['certifiedInFarming'] == 1) {
                        echo '<br>Farmer';
                    }
                    echo '</div></div></a>';
                }
                echo "</div></div>";

                echo '<div class="oofooCard">';
                echo '    <h3 class="oofooCardTitle">Dailies</h3>';
                echo "    <div>";
                echo '        <a href="gathering.php" class="list-group-item">Gathering';
                $today = date("Y-m-d");
                $gatheringAlertSql = "SELECT * FROM oofooPCs WHERE userid=".$_SESSION['user']->getID()." AND certifiedInGathering=1 AND lastGathered!='".$today."';";
                $gatheringAlertResult = mysqli_query($conn, $gatheringAlertSql);
                if (mysqli_num_rows($gatheringAlertResult) > 0) {
                    echo "<span id='gatheringAlert' class='alertBadge'>".mysqli_num_rows($gatheringAlertResult)."</span>";
                }
                echo '</a>';
                if ($_SESSION['user']->getType() == 'admin') {
                    echo '        <a href="farming.php" class="list-group-item">Farming</a>';
				}
                echo "    </div>";
                echo "</div>";
            } else {
                echo "</div>";
            }
		}
		?>
    </div>
<?php
CloseCon($conn);
?>
