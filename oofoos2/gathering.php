<?php
date_default_timezone_set('US/Eastern');
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
        	<div class="oofooCard">
                <h3 class="oofooCardTitle">Gathering</h3>
        		<div class="oofooCardBody">
                    <select id="location">
                        <option>Pleasant Pond</option>
                    </select>
                </div>
                <?php
                $sql = "SELECT * FROM oofooPCs WHERE userid=".$_SESSION['user']->getID().";";
                $result = mysqli_query($conn, $sql);
                $gathererCount = 0;

                if (mysqli_num_rows($result) > 0) {
                    echo "<div>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['certifiedInGathering'] == 1) {
                            $today = date("Y-m-d");
                            if ($today != $row['lastGathered']) {
                                echo '<div class="list-group-item"><span id="'.$row['oofooid'].'?'.$row['name'].'">'.$row['name'].'</span> is excited to <button class="btn btn-primary gatherBtn">Gather!</button></div>';
                            } else {
                                echo '<div class="list-group-item">'.$row['name'].' has already gathering for today. Check back here tomorrow.</div>';
                            }
                            $gathererCount++;
                        }
                    }
                    echo "</div>";
                }
                if ($gathererCount == 0) {
                    echo "<div class='oofooCardBody'>You don't have any oofoos certified in gathering. <a href='http://fav.me/dcbi3ca'>Complete a Gathering Trial to get started</a>.</div>";
                }
                ?>
        	</div>
        </div>
    </div>
</div>

<script>
$('.gatherBtn').click(function() {
    var gatherParent = $(this).parent();
    var oofooIdAndName = $(this).prev().attr('id').split("?");
    console.log(oofooIdAndName);
    $.post("includes/gatheringResponse.php",
        { location: $("#location option:selected").text(), oofoo_id: oofooIdAndName[0]  },
        function(response) {
            console.log(response);
            var itemInfo = response.split(", ");
            var gatherResult = oofooIdAndName[1];
            if (itemInfo.length == 1) {
                gatherResult += " got nothing today :(";
            } else if (itemInfo.length == 2) {
                //gatherResult += " got nothing and a negative status effect :(";
                gatherResult += " got nothing today :(";
            } else if (itemInfo.length == 3) {
                gatherResult += " got " + itemInfo[1].replace("quantity:","") + " " + itemInfo[2].replace("itemname:","") + " and " + itemInfo[3].replace("exp:","") + " exp!";
            } else if (itemInfo.length == 4) {
                gatherResult += " got " + itemInfo[1].replace("quantity:","") + " " + itemInfo[2].replace("itemname:","") + " and " + itemInfo[3].replace("exp:","") + " exp!";// + " and a positive effect!";
            }
            gatherParent.html(gatherResult);
            var gatheringAlertNum = parseInt($("#gatheringAlert").text());
            gatheringAlertNum -= 1;
            if (gatheringAlertNum == 0) {
                $("#gatheringAlert").hide();
            } else {
                $("#gatheringAlert").text(gatheringAlertNum);
            }
        }
    );
});
</script>
<?php
include_once('includes/footer.php');
CloseCon($conn);
?>
