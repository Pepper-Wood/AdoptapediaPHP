<?php
include_once('header.php');
?>

<div class="container">
    <div id="alertWarning" class="alert alert-success alert-dismissible fade" role="alert" style="display:none">
        <span id="alertWarningText"><strong>Holy guacamole!</strong> You should check in on some of those fields below.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span></button>
    </div>


    <?php if (!isset($_SESSION['user'])): ?>
        <div class="container">
            <img src="texasTomErrorBanner.png" style="width: 100%">
            <h1 class="text-center">Hold it there, pardner!</h1>
            <p>You are not logged into this page.</p>
        </div>
    <? else: ?>

    <?php
        $sql = mysqli_query($conn, "SELECT * FROM siteusersettings WHERE userid=".$_SESSION['user']->getID().";");
        $row = mysqli_fetch_assoc($sql);
    ?>
    <label>User Settings</label>
    <div class="card">
        <div class="list-group-item horizontalFlex">
            <div><b>Timezone</b></div>
            <div style="display: inherit">
                <?php
                $regions = array(
                    'Africa' => DateTimeZone::AFRICA,
                    'America' => DateTimeZone::AMERICA,
                    'Antarctica' => DateTimeZone::ANTARCTICA,
                    'Asia' => DateTimeZone::ASIA,
                    'Atlantic' => DateTimeZone::ATLANTIC,
                    'Australia' => DateTimeZone::AUSTRALIA,
                    'Europe' => DateTimeZone::EUROPE,
                    'Indian' => DateTimeZone::INDIAN,
                    'Pacific' => DateTimeZone::PACIFIC
                );
                $timezones = array();
                foreach ($regions as $name => $mask) {
                    $zones = DateTimeZone::listIdentifiers($mask);
                    foreach($zones as $timezone) {
                		$time = new DateTime(NULL, new DateTimeZone($timezone));
                		$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
                		$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
                	}
                }
                echo '<select id="timezone" class="form-control">';
                foreach($timezones as $region => $list) {
                	echo '<optgroup label="'.$region.'">';
                	foreach($list as $timezone => $name) {
                		echo '<option value="'.$timezone.'"';
                        if ($timezone == $row['timezone']) {
                            echo ' selected';
                        }
                        echo '>'.$name.'</option>';
                	}
                	echo '<optgroup>';
                }
                echo '</select>';
                ?>
                <button id="changeTimezoneConfirm" class="btn btn-success" style="display:none"><i class="fas fa-check"></i></button>
            </div>
        </div>
        <div class="list-group-item horizontalFlex">
            <div><b>Change Primary Student</b></div>
            <div style="display: inherit">
                <?php
                echo '<select id="changeMainStudent" class="form-control">';
                $studentsql = "SELECT studentid,studentname FROM students WHERE ownerid=".$_SESSION['user']->getID().";";
                $studentresult = mysqli_query($conn, $studentsql);
                if (mysqli_num_rows($studentresult) > 0) {
                    while ($studentsqlrow = mysqli_fetch_assoc($studentresult)) {
                        echo "<option value='".$studentsqlrow['studentid']."'";
                        if ($studentsqlrow['studentid'] == $row['mainstudentid']) {
                            echo " selected";
                        }
                        echo ">".$studentsqlrow['studentname']."</option>";
                    }
                }
                echo '</select>';
                ?>
                <button id="changeMainStudentConfirm" class="btn btn-success" style="display:none"><i class="fas fa-check"></i></button>
            </div>
        </div>
    </div>

    <?php
    $mainstudentsql = mysqli_query($conn, "SELECT * FROM students WHERE studentid=".$row['mainstudentid'].";");
    $mainstudentrow = mysqli_fetch_assoc($mainstudentsql);
    ?>
    <label>Your Primary Character: <?php echo $mainstudentrow['studentname']; ?></label>
    <div class="card">
        <div class="list-group-item horizontalFlex">
            <div><b>Class Year</b></div>
            <div><?php echo $mainstudentrow['class']; ?></div>
        </div>
        <div class="list-group-item horizontalFlex">
            <div><b>Halloween Team</b></div>
            <div><?php echo $mainstudentrow['halloweenTeam']; ?></div>
        </div>
    </div>


<script>
$("#addNewAssignment").click(function() {
    $.post("addNewAssignment.php", {newAssignmentID: $("#newAssignment").val()}, function(result) {
        location.reload();
    });
});
$(".removeAssignment").click(function() {
    $.post("removeAssignment.php", {removeAssignmentID: $(this).attr("id").replace("removeAssignment","")}, function(result) {
        location.reload();
    });
});
$("#timezone").change(function() {
    $("#changeTimezoneConfirm").show();
});
$("#changeTimezoneConfirm").click(function() {
    $.post("changetimezone.php", {newtimezone: $("#timezone").val()}, function(result) {
        $("#alertWarning").css("display","block");
        $("#alertWarning").addClass("show");
        $("#alertWarningText").html("Timezone changed.");
        $("#changeTimezoneConfirm").hide();
    });
});
$("#changeMainStudent").change(function() {
    $("#changeMainStudentConfirm").show();
});
$("#changeMainStudentConfirm").click(function() {
    $.post("changemainstudent.php", {newstudentid: $("#changeMainStudent").val()}, function(result) {
        $("#alertWarning").css("display","block");
        $("#alertWarning").addClass("show");
        $("#alertWarningText").html("Main student changed.");
        $("#changeMainStudentConfirm").hide();
    });
});
</script>

<?php
endif;
?>
</div>

<?php
include_once('footer.php');
?>
