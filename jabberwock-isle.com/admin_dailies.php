<label>Give Daily Rolls</label>
<div class="card">
    <div class="list-group-item">
        <div class="text-small text-muted">Award to User</div>
        <div class="horizontalFlex horizontalMargin">
            <div class="flexFill">
                <select id="dailiesUser" class="form-control">
                    <?php
                        $sql = "SELECT * FROM siteusers WHERE type != 'user' ORDER BY username;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['userid']."'>".$row['username']."</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div>
                <button id="decrementDailies" class="btn btn-secondary"><i class="fas fa-minus"></i></button>
                <button id="dailiesQuantity" class="btn btn-outline-secondary" disabled>1</button>
                <button id="incrementDailies" class="btn btn-secondary"><i class="fas fa-plus"></i></button>
                <button id="incrementMaxDailies" class="btn btn-secondary">MAX</button>
            </div>
            <div>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#giveDailiesModal">
                    <button class="btn btn-primary"><i class="fas fa-chevron-right"></i></button>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="list-group-item horizontalFlex">
        <div>Student of the Month</div>
        <div style="display: inherit">
            <select id="studentsOfTheMonth" class="form-control">
                <?php
                    $configs = include('adminconfig.php');
                    $studentofthemonthid = (int) $configs['studentofthemonthid'];

                    $sql = "SELECT * FROM students;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='".$row['studentid']."'";
                            if ($row['studentid'] == $studentofthemonthid) {
                                echo " selected";
                            }
                            echo ">".$row['studentname']."</option>";
                        }
                    }
                ?>
            </select>
            <button id="changeStudentOfTheMonth" class="btn btn-success" style="display:none"><i class="fas fa-check"></i></button>
        </div>
    </div>
    <div class="list-group-item horizontalFlex">
        <div>Default Point Team</div>
        <div style="display: inherit">
            <select id="pointTeams" class="form-control">
                <?php
                    $configs = include('adminconfig.php');
                    $teamid = (int) $configs['defaultpointsteams'];

                    $sql = "SELECT * FROM pointteams;";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='".$row['teamid']."'";
                            if ($row['teamid'] == $teamid) {
                                echo " selected";
                            }
                            echo ">".$row['teamname']."</option>";
                        }
                    }
                ?>
            </select>
            <button id="changeDefaultPointTeam" class="btn btn-success" style="display:none"><i class="fas fa-check"></i></button>
        </div>
    </div>
</div>

<label>Weekly Assignment Status</label>
<div class="card">
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>Username</th>
                <th>Itemname</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT username, itemname, isDone FROM weeklyuserassignments LEFT JOIN siteusers ON weeklyuserassignments.ownerid=siteusers.userid LEFT JOIN items ON weeklyuserassignments.recipeid=items.itemid ORDER BY username;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['itemname']; ?></td>
                        <td>
                        <?php
                            if ($row['isDone'] == 1) {
                                echo "DONE";
                            } else {
                                echo "In Progress";
                            }
                        ?>
                        </td>
                    </tr>
            <?  }
            }
            ?>
        </tbody>
    </table>
</div>

<script>
$("#pointTeams").change(function() {
    $("#changeDefaultPointTeam").show();
});
$("#changeDefaultPointTeam").click(function() {
    console.log($("#pointTeams").val());
    $.post("adminconfigrewrite.php", {adminkey: "defaultpointsteams", adminvalue: $("#pointTeams").val()}, function(result) {
        $("#alertWarning").css("display","block");
        $("#alertWarning").addClass("show");
        $("#alertWarningText").html("Default point team changed.");
        $("#changeDefaultPointTeam").hide();
    });
});
$("#studentsOfTheMonth").change(function() {
    $("#changeStudentOfTheMonth").show();
});
$("#changeStudentOfTheMonth").click(function() {
    console.log($("#studentsOfTheMonth").val());
    $.post("adminconfigrewrite.php", {adminkey: "studentofthemonthid", adminvalue: $("#studentsOfTheMonth").val()}, function(result) {
        $("#alertWarning").css("display","block");
        $("#alertWarning").addClass("show");
        $("#alertWarningText").html("Student of the month changed.");
        $("#changeStudentOfTheMonth").hide();
    });
});
</script>
