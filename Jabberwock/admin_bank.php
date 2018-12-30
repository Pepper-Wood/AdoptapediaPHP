<label>Give Monocoins</label>
<div class="card">
    <div class="list-group-item">
        <div class="text-small text-muted">Award to Student</div>
        <div class="horizontalFlex horizontalMargin">
            <div>
                <select id="monocoinsStudent" class="form-control">
                    <?php
                        $sql = "SELECT studentid,studentname FROM students ORDER BY studentname;";
                        $result = mysqli_query($conn, $sql);
                        $firstName = "";
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['studentid']."'>".$row['studentname']."</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div>
                <button id="decrement10Monocoins" class="btn btn-secondary"><i class="fas fa-minus"></i> 10</button>
                <button id="decrement1Monocoins" class="btn btn-secondary"><i class="fas fa-minus"></i> 1</button>
                <button id="monocoinsQuantity" class="btn btn-outline-secondary" disabled>0</button>
                <button id="increment1Monocoins" class="btn btn-secondary"><i class="fas fa-plus"></i> 1</button>
                <button id="increment10Monocoins" class="btn btn-secondary"><i class="fas fa-plus"></i> 10</button>
            </div>
            <div class="flexFill">
                <input type="text" id="monocoinsNote" class="form-control" placeholder="Note...">
            </div>
            <div>
                <button id="giveMonocoins" class="btn btn-success"><i class="fas fa-dollar-sign"></i></button>
            </div>
        </div>
    </div>
</div>
<?php
$timezonesql = mysqli_query($conn, "SELECT timezone FROM siteusersettings WHERE userid=".$_SESSION['user']->getID().";");
$timezonerow = mysqli_fetch_assoc($timezonesql);
$usertimezone = $timezonerow['timezone'];
date_default_timezone_set($usertimezone);
?>
<label>Bank Transaction History</label>
<div class="card">
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>Timestamp</th>
                <th>Student</th>
                <th>Monocoins</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql ="SELECT b.timestamp as timestamp, b.monocoins as monocoins, b.note as note, s.studentname as studentname FROM banktransactions b LEFT JOIN students s ON b.studentid=s.studentid ORDER BY timestamp DESC;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo date('M d h:i a',$row['timestamp']); ?></td>
                        <td><?php echo $row['studentname']; ?></td>
                        <td><?php echo $row['monocoins']; ?></td>
                        <td><?php echo $row['note']; ?></td>
                    </tr>
            <?  }
            }
            ?>
        </tbody>
    </table>
</div>
