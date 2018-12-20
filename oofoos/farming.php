<?php
include_once('includes/header.php');
date_default_timezone_set('US/Eastern');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();
?>

<style>
.oofootooltip {
    position: relative;
    display: inline-block;
}
.oofootooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
}
.oofootooltip .tooltiptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}
.oofootooltip:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}
.reapedNotification {
  position: fixed;
  background-color: #7ed897;
  padding: 10px;
  border-radius: 10px;
  color: #FFF;
  z-index: 102;
  opacity: 0;
}
</style>



<div class="body">
    <div class="row">
        <?php
        include_once('includes/leftMenu.php');
        ?>
        <div class="col-sm-8">
            <?php
            $sql = "SELECT * FROM oofooPCs WHERE userid=".$_SESSION['user']->getID().";";
            $result = mysqli_query($conn, $sql);
            $farmerCount = 0;

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['certifiedInFarming'] == 1) {
                        if ($farmerCount == 0) {
                            echo "<div class='oofooCard'>";
                            echo "  <h3 class='oofooCardTitle'>Farming Inventory</h3>";
                            echo "  <div class='oofooCardBody'>";
                            $inventorysql = "SELECT farmItems.itemid, items.name, items.img, siteuserInventories.quantity, farmItems.growtime, farmItems.wilttime FROM siteuserInventories, farmItems, items WHERE siteuserInventories.userid = ".$_SESSION['user']->getID()." AND siteuserInventories.itemid = farmItems.itemid AND items.itemid = farmItems.itemid AND siteuserInventories.quantity>0;";
                            $inventoryresult = mysqli_query($conn, $inventorysql);

                            if (mysqli_num_rows($inventoryresult) > 0) {
                                while ($inventoryrow = mysqli_fetch_assoc($inventoryresult)) {
                                    echo "<div id='farminginventory".$inventoryrow["itemid"]."' class='bankIcon'>";
                                    echo "	<img class='fullWidth' src='images/items/".$inventoryrow['img']."'>";
                                    echo "	<span class='inventoryQuantity'>".$inventoryrow['quantity']."</span>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p>You have no farmable seeds in your inventory</p>";
                            }
                            echo "</div></div>";
                        }
                        echo "<div class='oofooCard'>";
                        echo "  <h3 class='oofooCardTitle'>".$row['name']."'s Farm</h3>";
                        echo "  <div class='oofooCardBody'>";
                        $plotsql = "SELECT * FROM farmPlots WHERE farmPlots.farmPlotid IN (".$row['farmPlotids'].");";
                        $plotresult = mysqli_query($conn, $plotsql);
                        if (mysqli_num_rows($plotresult) > 0) {
                            while ($plotrow = mysqli_fetch_assoc($plotresult)) {
                                if ($plotrow['cropid'] == 0) {
                                    echo '<div class="oofootooltip">';
                                    echo '  <img id="farmingplot'.$plotrow['farmPlotid'].'" class="farmingPlot emptyPlot" src="images/emptyPlot.png">';
                                    echo '  <span class="tooltiptext">Plant a Seed</span>';
                                    echo '</div>';
                                } else {
                                    $plotimgsql = "SELECT * FROM farmItems WHERE itemid=".$plotrow['cropid'].";";
                                    $plotimgresult = mysqli_query($conn, $plotimgsql);
                                    $plotimgrow = mysqli_fetch_assoc($plotimgresult);
                                    if (time() <= $plotrow['cropGrownTime']) {
                                        echo '<div class="oofootooltip">';
                                        echo '  <img id="farmingplot'.$plotrow['farmPlotid'].'" class="farmingPlot" src="images/'.$plotimgrow['growingimg'].'">';
                                        echo '  <span class="farmingPlotCountdown tooltiptext">'.$plotrow['cropGrownTime'].'</span>';
                                        echo '  <span id="reapedNotification'.$plotrow['farmPlotid'].'" class="reapedNotification"></span>';
                                        echo '</div>';
                                    } elseif (time() <= $plotrow['cropWiltedTime']) {
                                        echo '<div class="oofootooltip">';
                                        echo '  <img id="farmingplot'.$plotrow['farmPlotid'].'" class="farmingPlot grownPlot" src="images/'.$plotimgrow['grownimg'].'">';
                                        echo '  <span class="tooltiptext">Grown Crop!</span>';
                                        echo '  <span id="reapedNotification'.$plotrow['farmPlotid'].'" class="reapedNotification"></span>';
                                        echo '</div>';
                                    } elseif (time() > $plotrow['cropWiltedTime']) {
                                        echo '<div class="oofootooltip">';
                                        echo '  <img id="farmingplot'.$plotrow['farmPlotid'].'" class="farmingPlot grownPlot" src="images/'.$plotimgrow['wiltedimg'].'">';
                                        echo '  <span class="tooltiptext">Wilted Crop</span>';
                                        echo '  <span id="reapedNotification'.$plotrow['farmPlotid'].'" class="reapedNotification"></span>';
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                        echo "</div></div>";
                        $farmerCount++;
                    }
                }
            }
            if ($farmerCount == 0) {
                echo "<div class='oofooCard'>";
                echo "  <h3 class='oofooCardTitle'>Farming</h3>";
                echo "  <div class='oofooCardBody'>";
                echo "      You don't have any oofoos certified in farming.";
                echo "</div></div>";
            }
            ?>
        </div>
    </div>
</div>

<script>
/**
 * @author Alexander Manzyuk <admsev@gmail.com>
 * Copyright (c) 2012 Alexander Manzyuk - released under MIT License
 * https://github.com/admsev/jquery-play-sound
**/

(function ($) {
    $.extend({
        playSound: function () {
            return $(
                   '<audio class="sound-player" autoplay="autoplay" style="display:none;">'
                     + '<source src="' + arguments[0] + '" />'
                     + '<embed src="' + arguments[0] + '" hidden="true" autostart="true" loop="false"/>'
                   + '</audio>'
                 ).appendTo('body');
        },
        stopSound: function () {
            $(".sound-player").remove();
        }
    });
})(jQuery);

function setBackground(jQObject, color) {
    jQObject.css("background-color", color);
}

function resetDroppables() {
    $(".bankIcon").draggable({
        revert: true
    });

    $(".emptyPlot").droppable({
        activeClass: "plantable",

        drop: function (event, ui) {
            var farmitem_id = ui.draggable.attr("id");
            var farmplot_id = event.target.id;
            $.post("includes/plantemptyplot.php",
                { farmItemId: farmitem_id, farmPlotId: farmplot_id },
                function(response) {
                    var plantedInfo = response.split(",");
                    // farmitem_id  = farminginventory8
                    // farmplot_id  = farmingplot1
                    // plantedInfo[0] = cropGrownTime, 150888427
                    // plantedInfo[1] = growingimg, 2893671398.gif
                    // plantedInfo[2] = grownimg, grown9.png

                    var farmPlotID = "#" + farmplot_id;
                    $(farmPlotID).removeClass("emptyPlot").removeClass("ui-droppable");
                    $(farmPlotID).attr("src","images/" + plantedInfo[1]);
                    $(farmPlotID).next().text(plantedInfo[0]);
                    resetCountdowns();

                    // change plot to show "pending" and tooltip to show countdown to growntime
                    // TODO - change to pending plot
                }
            );
        }
    });
}

function resetCountdowns() {
    //var plotTimes = [1528428512,1528429012,1528429512];
    //var plotIntervals = [0,0,0];
    var plotTimes = [];
    var plotIntervals = [];
    $('.farmingPlotCountdown').each(function(i, obj) {
        plotTimes[i] = $(obj).text();
        plotIntervals[i] = 0;
    });

    $('.farmingPlotCountdown').each(function(i, obj) {
        plotIntervals[i] = setInterval(function() {
            var secondsUntil = parseInt(plotTimes[i]) - Math.floor(Date.now() / 1000);

            var seconds = Math.floor(secondsUntil % 60);
            var minutes = Math.floor((secondsUntil % 3600) / 60);
            var hours = Math.floor((secondsUntil % 86400) / 3600);
            var days = Math.floor((secondsUntil % (86400 * 30)) / 86400);

            // Output the result in an element with id="demo"
            var timeStr = "";
            if (days > 0) {
                timeStr += days + ":";
            }
            if (hours > 0) {
                if (hours < 10) {
                    timeStr += "0";
                }
                timeStr += hours + ":";
            }
            if (minutes < 10) {
                timeStr += "0";
            }
            timeStr += minutes + ":";
            if (seconds < 10) {
                timeStr += "0";
            }
            timeStr += seconds;
            $(obj).text(timeStr);

            if (secondsUntil < 0) {
                $.playSound('sounds/growBeep.wav');
                clearInterval(plotIntervals[i]);
                $(obj).text('EXPIRED');
                // TODO - change to grown plot
            }
        }, 1000);
    });
}

$(document).ready(function() {
    resetDroppables();

    $(".grownPlot").click(function(e) {
        var farmplot_id = $(this).attr("id");
        $.post("includes/reapgrownplot.php",
            { farmPlotId: farmplot_id },
            function(response) {
                reapgrownplotresult = response.split(",");
                if (reapgrownplotresult[0] == "REAPED") {
                    var reapedNotificationID = "#reapedNotification"+farmplot_id.replace("farmingplot","");
                    $(reapedNotificationID).text("+" + reapgrownplotresult[1] + " " + reapgrownplotresult[2]);
                    $(reapedNotificationID).css({"left":e.pageX, "top":e.pageY-50, "opacity":1});
                    $(reapedNotificationID).animate({ top: '-=50', opacity: 0 }, 2000, "linear");
                }
                var farmPlotID = "#" + farmplot_id;
                $(farmPlotID).removeClass("grownPlot").addClass("emptyPlot").addClass("ui-droppable");
                $(farmPlotID).attr("src","images/emptyPlot.png");

                resetDroppables();
            }
        );
    });

    resetCountdowns();
});
</script>
<?php
include_once('includes/footer.php');
CloseCon($conn);
?>
