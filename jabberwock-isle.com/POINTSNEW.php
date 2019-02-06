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

.bgDasher { background-color: #2283FF; }
.bgDancer { background-color: #2283FF; }
.bgPrancer { background-color: #2283FF; }
.bgVixen { background-color: #2283FF; }
.bgComet { background-color: #2283FF; }
.bgCupid { background-color: #2283FF; }
.bgDonner { background-color: #2283FF; }
.bgBlitzen { background-color: #2283FF; }
.bgRudolph { background-color: #2283FF; }
</style>

<?php
$configs = include('adminconfig.php');
$teamid = (int) $configs['defaultpointsteams'];
if (isset($_GET['tid'])) {
    $teamid = $_GET['tid'];
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

?>

<div class="container-fluid">
    <h1 class="text-center">Points</h1>
    Teams: <select id="teamTypeSelect">
        <?php
            $pointteamssql = "SELECT * FROM pointteams;";
            $pointteamsresult = mysqli_query($conn, $pointteamssql);
            if (mysqli_num_rows($pointteamsresult) > 0) {
                while ($row = mysqli_fetch_assoc($pointteamsresult)) {
                    echo "<option value='".$row['teamid']."'";
                    if ($row['teamid'] == $teamid) {
                        echo " selected";
                    }
                    echo ">".$row['teamname']."</option>";
                }
            }
        ?>
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
                        <?php
                            $
                        ?>
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
                        <?php if ($teamType == 'reindeer') { ?>
                            <?php prettyPrintRow("minecraft", "Dasher", "Dasher", 0) ?>
                            <?php prettyPrintRow("minecraft", "Dancer", "Dancer", 1) ?>
                            <?php prettyPrintRow("minecraft", "Prancer", "Prancer", 2) ?>
                            <?php prettyPrintRow("minecraft", "Vixen", "Vixen", 3) ?>
                            <?php prettyPrintRow("minecraft", "Comet", "Comet", 4) ?>
                            <?php prettyPrintRow("minecraft", "Cupid", "Cupid", 5) ?>
                            <?php prettyPrintRow("minecraft", "Donner", "Donner", 6) ?>
                            <?php prettyPrintRow("minecraft", "Blitzen", "Blitzen", 7) ?>
                            <?php prettyPrintRow("minecraft", "Rudolph", "Rudolph", 8) ?>
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
                        <?php if ($teamType == 'reindeer') { ?>
                            <?php prettyPrintRow("bank", "Dasher", "Dasher", 0) ?>
                            <?php prettyPrintRow("bank", "Dancer", "Dancer", 1) ?>
                            <?php prettyPrintRow("bank", "Prancer", "Prancer", 2) ?>
                            <?php prettyPrintRow("bank", "Vixen", "Vixen", 3) ?>
                            <?php prettyPrintRow("bank", "Comet", "Comet", 4) ?>
                            <?php prettyPrintRow("bank", "Cupid", "Cupid", 5) ?>
                            <?php prettyPrintRow("bank", "Donner", "Donner", 6) ?>
                            <?php prettyPrintRow("bank", "Blitzen", "Blitzen", 7) ?>
                            <?php prettyPrintRow("bank", "Rudolph", "Rudolph", 8) ?>
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
    window.location.href = updateQueryStringParameter(window.location.href,"tid",$(this).val());
});
</script>

<?php
include_once('footer.php');
?>
