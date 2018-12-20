<style>
.switch-input {
    display: none;
}
.switch-label {
    position: relative;
    display: inline-block;
    min-width: 112px;
    cursor: pointer;
    font-weight: 500;
    text-align: left;
    margin: 0px;
    padding-left: 44px;
}
.switch-label:before, .switch-label:after {
    content: "";
    position: absolute;
    margin: 0;
    outline: 0;
    top: 50%;
    -ms-transform: translate(0, -50%);
    -webkit-transform: translate(0, -50%);
    transform: translate(0, -50%);
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
.switch-label:before {
    left: 1px;
    width: 34px;
    height: 14px;
    background-color: #9E9E9E;
    border-radius: 8px;
}
.switch-label:after {
    left: 0;
    width: 20px;
    height: 20px;
    background-color: #FAFAFA;
    border-radius: 50%;
    box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.14), 0 2px 2px 0 rgba(0, 0, 0, 0.098), 0 1px 5px 0 rgba(0, 0, 0, 0.084);
}
.switch-label .toggle--on {
    display: none;
}
.switch-label .toggle--off {
    display: inline-block;
}
.switch-input:checked + .switch-label:before {
    background-color: #A5D6A7;
}
.switch-input:checked + .switch-label:after {
    background-color: #4CAF50;
    -ms-transform: translate(80%, -50%);
    -webkit-transform: translate(80%, -50%);
    transform: translate(80%, -50%);
}
.switch-input:checked + .switch-label .toggle--on {
    display: inline-block;
}
.switch-input:checked + .switch-label .toggle--off {
    display: none;
}
</style>

<label>Give Monocoins</label>
<div class="card">
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <select id="monocoinsUser" class="form-control">
                        <?php
                            $sql = "SELECT userid,username FROM siteusers WHERE type != 'user' ORDER BY username;";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='".$row['userid']."'>".$row['username']."</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="number" id="monocoinsCount" class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text">MBC</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="monocoinsBattleForTheBank" name="set-name" class="switch-input" checked>
                	<label for="monocoinsBattleForTheBank" class="switch-label">This <span class="toggle--on">will</span><span class="toggle--off">won't</span> count for Battle for the Bank</label>
                </div>
                <button id="giveMonocoins" class="btn btn-block btn-success"><i class="fas fa-dollar-sign"></i></button>
            </div>
            <div class="col-md-8">
                <div style="height:100%">
                    <textarea class="form-control" id="monocoinsNote" rows="3" placeholder="Transaction Note" style="height:100%"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$("#giveMonocoins").click(function() {
    var battleForTheBankBool = 0;
    if (document.getElementById('monocoinsBattleForTheBank').checked) {
        battleForTheBankBool = 1;
    }
    $.post("giveMonocoins.php", {
        userid: $("#monocoinsUser").val(),
        monocoins: parseInt($("#monocoinsCount").val()),
        battleForTheBank: battleForTheBankBool,
        note: $("#monocoinsNote").val()
    }, function(result) {
        location.reload();
    });
});
</script>

<?php
$timezonesql = mysqli_query($conn, "SELECT timezone FROM siteusersettings WHERE userid=".$_SESSION['user']->getID().";");
$timezonerow = mysqli_fetch_assoc($timezonesql);
$usertimezone = $timezonerow['timezone'];
date_default_timezone_set($usertimezone);
?>
<style>
.table-sm td {
    padding: 0.3rem;
}
.bankcol { white-space: nowrap; }
</style>

<label>Bank Transaction History</label>
<div class="card">
    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th class="bankcol">Timestamp</th>
                    <th class="bankcol">User</th>
                    <th class="bankcol">MBC</th>
                    <th class="bankcol">BftB</th>
                    <th class="bankcol">Note</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql ="SELECT b.timestamp as timestamp, b.monocoins as monocoins, b.battleForTheBank as battleForTheBank, b.note as note, s.username as username FROM banktransactions b LEFT JOIN siteusers s ON b.userid=s.userid ORDER BY timestamp DESC;";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td class="bankcol"><?php echo date('M d h:i a',$row['timestamp']); ?></td>
                            <td class="bankcol"><?php echo $row['username']; ?></td>
                            <td class="bankcol"><?php echo $row['monocoins']; ?></td>
                            <td class="bankcol">
                                <?php if ($row['battleForTheBank'] == 1) {
                                    echo '<i class="fas fa-check"></i>';
                                } ?>
                            </td>
                            <td class="bankcol"><?php echo $row['note']; ?></td>
                        </tr>
                <?  }
                }
                ?>
            </tbody>
        </table>
</div>
