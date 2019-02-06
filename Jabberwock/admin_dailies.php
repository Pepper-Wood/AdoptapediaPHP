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
                        $firstName = "";
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($firstName == "") {
                                    $firstName = $row['username'];
                                }
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
