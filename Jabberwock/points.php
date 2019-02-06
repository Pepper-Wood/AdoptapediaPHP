<?php
include_once('header.php');
date_default_timezone_set("America/Los_Angeles");
?>
<style>
.centerImage {
    display: block;
    margin: 0 auto;
}
.progressWrapper {
    display: flex;
    width: 100%;
    height: 100%;
    align-items: center;
    margin-bottom: 5px;
    flex-direction: column;
    justify-content: center;
}
.progress {
    height: 40px;
    width: 100%;
}
.smProgress {
    height: 20px;
    width: 100%;
}
.studentRankSprite {
    width: 30px;
}
.studentRankSprite>img {
    display: block;
    margin: 0 auto;
}
.bgFreshman { background-color: #2283FF; }
.bgSophomore { background-color: #FF22BA; }
.bgJunior { background-color: #FFC107; }
.bgSenior { background-color: #FF5722; }

.bgVampire { background-color: #E68649; }
.bgWerewolf { background-color: #9442A1; }
</style>

<?php
$teamType = "halloween";
if (isset($_GET['t'])) {
    $teamType = $_GET['t'];
}

function getTimestampQuery() {
    $transactionsql = "";
    if (isset($_GET['d'])) {
        $firstDates = array_map('intval', explode("-",$_GET['d']));
        $firstYear = $firstDates[0];
        $firstMonth = $firstDates[1];
        if ($firstMonth == 12) {
            $lastYear = $firstYear + 1;
            $lastMonth = 1;
        } else {
            $lastYear = $firstYear;
            $lastMonth = $firstMonth + 1;
        }
        $firstSelectedDate = date("F", mktime(0, 0, 0, $firstMonth, 10))." ".$firstYear;
        $lastSelectedDate = date("F", mktime(0, 0, 0, $lastMonth, 10))." ".$lastYear;
        $oFirst = strtotime('first day of '.$firstSelectedDate);
        $oLast = strtotime('first day of '.$lastSelectedDate);
        $transactionsql .= "timestamp >= ".$oFirst." AND timestamp < ".$oLast;
    } else {
        $oFirst = strtotime('first day of '.date('F Y'));
        $transactionsql .= "timestamp > ".$oFirst;
    }
    return $transactionsql;
}
$timestampQuery = getTimestampQuery();

function getTeamCounts() {
    global $conn, $teamType;
    $teamTypeStr = "";
    if ($teamType == 'halloween') {
        $teamTypeStr = "halloweenTeam";
    } else if ($teamType == 'classwars') {
        $teamTypeStr = "class";
    }
    $sql = "SELECT ".$teamTypeStr." as teamType, COUNT(*) as numStudents FROM students GROUP BY ".$teamTypeStr.";";
    $result = mysqli_query($conn, $sql);
    $teamCounts = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $teamCounts[$row['teamType']] = $row['numStudents'];
        }
    }
    return $teamCounts;
}
function getMinecraftClassPoints($classType) {
    global $timestampQuery, $teamType, $conn;
    $totalpointsquery = "SELECT SUM(points) AS totalpoints FROM craftingpoints LEFT JOIN students ON craftingpoints.studentid=students.studentid WHERE ";
    if ($teamType == 'halloween') {
        $totalpointsquery .= 'halloweenTeam';
    } else if ($teamType == 'classwars') {
        $totalpointsquery .= 'class';
    }
    $totalpointsquery .= "='".$classType."' AND ".$timestampQuery.";";
    $totalpointssql = mysqli_query($conn, $totalpointsquery);
    $totalpointsrow = mysqli_fetch_assoc($totalpointssql);
    return $totalpointsrow['totalpoints'];
}
function printMinecraftClassStudents($classType) {
    global $timestampQuery, $teamType, $conn;
    $sql = "SELECT DISTINCT studentsprite FROM craftingpoints LEFT JOIN students ON craftingpoints.studentid=students.studentid WHERE ";
    if ($teamType == 'halloween') {
        $sql .= 'halloweenTeam';
    } else if ($teamType == 'classwars') {
        $sql .= 'class';
    }
    $sql .= "='".$classType."' AND ".$timestampQuery.";";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<img src='".$row['studentsprite']."'>";
        }
    }
}
function getBankClassPoints($classType) {
    global $timestampQuery, $teamType, $conn;
    $totalpointsquery = "SELECT SUM(banktransactions.monocoins) AS totalcoins FROM banktransactions LEFT JOIN students ON banktransactions.studentid=students.studentid WHERE banktransactions.monocoins>0 AND ";
    if ($teamType == 'halloween') {
        $totalpointsquery .= 'halloweenTeam';
    } else if ($teamType == 'classwars') {
        $totalpointsquery .= 'class';
    }
    $totalpointsquery .= "='".$classType."' AND ".$timestampQuery.";";
    $totalpointssql = mysqli_query($conn, $totalpointsquery);
    $totalpointsrow = mysqli_fetch_assoc($totalpointssql);
    return $totalpointsrow['totalcoins'];
}
function printBankClassStudents($classType) {
    global $timestampQuery, $teamType, $conn;
    $sql = "SELECT DISTINCT studentsprite FROM banktransactions LEFT JOIN students ON banktransactions.studentid=students.studentid WHERE ";
    if ($teamType == 'halloween') {
        $sql .= 'halloweenTeam';
    } else if ($teamType == 'classwars') {
        $sql .= 'class';
    }
    $sql .= "='".$classType."' AND ".$timestampQuery.";";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<img src='".$row['studentsprite']."'>";
        }
    }
}
function prettyPrintLeftCell($filterType, $filterName, $displayName) {
    echo "<small class='text-muted'>".$displayName."</small><br>";
    if ($filterType == 'minecraft') {
        echo printMinecraftClassStudents($filterName);
    } else if ($filterType == 'bank') {
        echo printBankClassStudents($filterName);
    }
}
function prettyPrintRightCell($filterType, $filterName, $displayName, $filterIndex) {
    global $minecraftclasspoints, $bankclasspoints, $minecraftclassavgpoints, $bankclassavgpoints, $maxminecraftpoints, $maxbankpoints, $teamCounts;
    $currPoints = 0;
    $totalPoints = 0;
    if ($filterType == 'minecraft') {
        $currPoints = $minecraftclassavgpoints[$filterIndex];
        $totalPoints = $minecraftclasspoints[$filterIndex];
    } else if ($filterType == 'bank') {
        $currPoints = $bankclassavgpoints[$filterIndex];
        $totalPoints = $bankclasspoints[$filterIndex];
    }
    echo "<div class='progressWrapper'><div class='progress'>";
    echo "<div class='progress-bar progress-bar-striped progress-bar-animated bg".$filterName."' role='progressbar' style='width: ";
    if ($filterType == 'minecraft') {
        echo ($currPoints/$maxminecraftpoints)*100;
    } else if ($filterType == 'bank') {
        echo ($currPoints/$maxbankpoints)*100;
    }
    echo "%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'>";
    echo $currPoints;
    echo "</div></div><small class='text-muted'>Total = ".$totalPoints."; Students = ".$teamCounts[$filterName]."</small></div>";
}
function prettyPrintRow($filterType, $filterName, $displayName, $filterIndex) {
    echo "<div class='col-md-3'>";
    prettyPrintLeftCell($filterType, $filterName, $displayName);
    echo "</div>";
    echo "<div class='col-md-9'>";
    prettyPrintRightCell($filterType, $filterName, $displayName, $filterIndex);
    echo "</div>";
}

function printMinecraftStudentRankings() {
    global $timestampQuery, $conn;
    $maxpoints = 0;
    $sql = "SELECT DISTINCT students.studentsprite as studentsprite, sum(points) as studentpoints FROM craftingpoints LEFT JOIN students ON craftingpoints.studentid=students.studentid WHERE ".$timestampQuery." GROUP BY craftingpoints.studentid ORDER BY studentpoints DESC;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($maxpoints == 0) {
                $maxpoints = $row['studentpoints'];
            }
            echo "<div class='horizontalFlex'><div class='studentRankSprite'><img src='".$row['studentsprite']."'></div>";
            echo "<div class='flexFill'>";
            echo "<div class='progressWrapper'><div class='progress smProgress'>";
            echo "<div class='progress-bar";
            if ($maxpoints == $row['studentpoints']) {
                echo " bg-primary";
            } else {
                echo " bg-secondary";
            }
            echo "' role='progressbar' style='width: ";
            echo ($row['studentpoints']/$maxpoints)*100;
            echo "%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'>";
            echo $row['studentpoints'];
            echo "</div></div></div>";
            echo "</div></div>";
        }
    }
}
function printBankStudentRankings() {
    global $timestampQuery, $conn;
    $maxcoins = 0;
    $sql = "SELECT DISTINCT students.studentsprite as studentsprite, sum(banktransactions.monocoins) as studentcoins FROM banktransactions LEFT JOIN students ON banktransactions.studentid=students.studentid WHERE ".$timestampQuery." AND banktransactions.monocoins>0 GROUP BY banktransactions.studentid ORDER BY studentcoins DESC;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($maxcoins == 0) {
                $maxcoins = $row['studentcoins'];
            }
            echo "<div class='horizontalFlex'><div class='studentRankSprite'><img src='".$row['studentsprite']."'></div>";
            echo "<div class='flexFill'>";
            echo "<div class='progressWrapper'><div class='progress smProgress'>";
            echo "<div class='progress-bar";
            if ($maxcoins == $row['studentcoins']) {
                echo " bg-primary";
            } else {
                echo " bg-secondary";
            }
            echo "' role='progressbar' style='width: ";
            echo ($row['studentcoins']/$maxcoins)*100;
            echo "%' aria-valuenow='50' aria-valuemin='0' aria-valuemax='100'>";
            echo $row['studentcoins'];
            echo "</div></div></div>";
            echo "</div></div>";
        }
    }
}

/* This is so hideous, I'm so sorry */
$teamCounts = getTeamCounts();
$minecraftclasspoints = array();
$minecraftclassavgpoints = array();
$bankclasspoints = array();
$bankclassavgpoints = array();
if ($teamType == 'classwars') {
    array_push($minecraftclasspoints, getMinecraftClassPoints("Freshman"));
    array_push($minecraftclassavgpoints, round($minecraftclasspoints[0]/$teamCounts["Freshman"],2));
    array_push($minecraftclasspoints, getMinecraftClassPoints("Sophomore"));
    array_push($minecraftclassavgpoints, round($minecraftclasspoints[1]/$teamCounts["Sophomore"],2));
    array_push($minecraftclasspoints, getMinecraftClassPoints("Junior"));
    array_push($minecraftclassavgpoints, round($minecraftclasspoints[2]/$teamCounts["Junior"],2));
    array_push($minecraftclasspoints, getMinecraftClassPoints("Senior"));
    array_push($minecraftclassavgpoints, round($minecraftclasspoints[3]/$teamCounts["Senior"],2));
    array_push($bankclasspoints, getBankClassPoints("Freshman"));
    array_push($bankclassavgpoints, round($bankclasspoints[0]/$teamCounts["Freshman"],2));
    array_push($bankclasspoints, getBankClassPoints("Sophomore"));
    array_push($bankclassavgpoints, round($bankclasspoints[1]/$teamCounts["Sophomore"],2));
    array_push($bankclasspoints, getBankClassPoints("Junior"));
    array_push($bankclassavgpoints, round($bankclasspoints[2]/$teamCounts["Junior"],2));
    array_push($bankclasspoints, getBankClassPoints("Senior"));
    array_push($bankclassavgpoints, round($bankclasspoints[3]/$teamCounts["Senior"],2));
} else if ($teamType == 'halloween') {
    array_push($minecraftclasspoints, getMinecraftClassPoints("Vampire"));
    array_push($minecraftclassavgpoints, round($minecraftclasspoints[0]/$teamCounts["Vampire"],2));
    array_push($minecraftclasspoints, getMinecraftClassPoints("Werewolf"));
    array_push($minecraftclassavgpoints, round($minecraftclasspoints[1]/$teamCounts["Werewolf"],2));
    array_push($bankclasspoints, getBankClassPoints("Vampire"));
    array_push($bankclassavgpoints, round($bankclasspoints[0]/$teamCounts["Vampire"],2));
    array_push($bankclasspoints, getBankClassPoints("Werewolf"));
    array_push($bankclassavgpoints, round($bankclasspoints[1]/$teamCounts["Werewolf"],2));
}
$maxminecraftpoints = max($minecraftclassavgpoints);
$maxbankpoints = max($bankclassavgpoints);
?>

<div class="container-fluid">
    <h1 class="text-center">Points</h1>
    Teams: <select id="teamTypeSelect">
        <option value='halloween' <?php if ($teamType == "halloween") { echo "selected"; } ?>>Vampires vs. Werewolves</option>
        <option value='classwars' <?php if ($teamType == "classwars") { echo "selected"; } ?>>Class Wars</option>
    </select>
    Showing Month: <select id="dateSelect"></select>
    <br>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <img class="centerImage" src="minecraftWars.png">
                    <h5 class="card-title text-center">Minecraft Hunger Games</h5>
                    <p class="text-center">Crafting Competition</p>
                    <div class="row">
                        <?php if ($teamType == 'classwars') { ?>
                            <?php prettyPrintRow("minecraft", "Freshman", "Freshmen", 0) ?>
                            <?php prettyPrintRow("minecraft", "Sophomore", "Sophomores", 1) ?>
                            <?php prettyPrintRow("minecraft", "Junior", "Juniors", 2) ?>
                            <?php prettyPrintRow("minecraft", "Senior", "Seniors", 3) ?>
                        <?php } ?>
                        <?php if ($teamType == 'halloween') { ?>
                            <?php prettyPrintRow("minecraft", "Vampire", "Vampires", 0) ?>
                            <?php prettyPrintRow("minecraft", "Werewolf", "Werewolves", 1) ?>
                        <?php } ?>
                    </div>
                    <hr>
                    <p class="text-center">Student Rankings</p>
                    <?php printMinecraftStudentRankings(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <img class="centerImage" src="battleBank.png">
                    <h5 class="card-title text-center">Battle for the Bank</h5>
                    <p class="text-center">Artwork Competition</p>
                    <div class="row">
                        <?php if ($teamType == 'classwars') { ?>
                            <?php prettyPrintRow("bank", "Freshman", "Freshmen", 0) ?>
                            <?php prettyPrintRow("bank", "Sophomore", "Sophomores", 1) ?>
                            <?php prettyPrintRow("bank", "Junior", "Juniors", 2) ?>
                            <?php prettyPrintRow("bank", "Senior", "Seniors", 3) ?>
                        <?php } ?>
                        <?php if ($teamType == 'halloween') { ?>
                            <?php prettyPrintRow("bank", "Vampire", "Vampires", 0) ?>
                            <?php prettyPrintRow("bank", "Werewolf", "Werewolves", 1) ?>
                        <?php } ?>
                    </div>
                    <hr>
                    <p class="text-center">Student Rankings</p>
                    <?php printBankStudentRankings(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function getMonthName(number) {
    if (number == "01") { return "January"; }
    else if (number == "02") { return "February"; }
    else if (number == "03") { return "March"; }
    else if (number == "04") { return "April"; }
    else if (number == "05") { return "May"; }
    else if (number == "06") { return "June"; }
    else if (number == "07") { return "July"; }
    else if (number == "08") { return "August"; }
    else if (number == "09") { return "September"; }
    else if (number == "10") { return "October"; }
    else if (number == "11") { return "November"; }
    else if (number == "12") { return "December"; }
}

function getToday() {
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth()+1;
    var displayMonth = month < 10 ? '0'+month : month;
    return [year, displayMonth].join('-');
}

function dateRange(startDate, endDate) {
    var start      = startDate.split('-');
    var end        = endDate.split('-');
    var startYear  = parseInt(start[0]);
    var endYear    = parseInt(end[0]);
    var dateHTML   = [];
    var selectedDate = getParameterByName('d');
    var optionStr = "";

    for (var i = startYear; i <= endYear; i++) {
        var endMonth = i != endYear ? 11 : parseInt(end[1]) - 1;
        var startMon = i === startYear ? parseInt(start[1])-1 : 0;
        for (var j = startMon; j <= endMonth; j = j > 12 ? j % 12 || 11 : j+1) {
            var month = j+1;
            var displayMonth = month < 10 ? '0'+month : month;
            optionStr = "<option value='" + [i, displayMonth].join('-') + "'";
            if (selectedDate != null && ([i, displayMonth].join('-') == selectedDate)) {
                optionStr += " selected";
            }
            optionStr += ">" + getMonthName(displayMonth) + " " + i + "</option>";
            dateHTML.push(optionStr);
        }
    }
    dateHTML.reverse();
    $("#dateSelect").html(dateHTML.join(""));
}

var today = new Date();
dateRange('2018-09', getToday());

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
        return uri + separator + key + "=" + value;
    }
}

$("#dateSelect").change(function() {
    window.location.href = updateQueryStringParameter(window.location.href,"d",$(this).val());
});
$("#teamTypeSelect").change(function() {
    window.location.href = updateQueryStringParameter(window.location.href,"t",$(this).val());
});
</script>

<?php
include_once('footer.php');
?>
