<?php
include_once('header.php');
?>

<?php if ((!isset($_SESSION['user'])) || ($_SESSION['user']->getType() != 'admin')): ?>
    <div class="container">
        <img src="texasTomErrorBanner.png" style="width: 100%">
        <h1 class="text-center">Hold it there, pardner!</h1>
        <p>You are not authorized to view this page.</p>
    </div>
<? else: ?>
<style>
.buffer {
    height: 0px;
}
.bannerButtons {
    padding-top: 10px;
    padding-bottom: 10px;
    background-color: #f6d6e9;
    margin-bottom: 10px;
}
</style>
<div class="container-fluid bannerButtons">
    <?php
    if ((!isset($_GET['p'])) || ($_GET['p'] == "dailies")) {
        echo "<a href='javascript:void(0)'><button class='btn btn-sm btn-primary' disabled>Dailies</button></a>";
    } else {
        echo "<a href='admin.php?p=dailies'><button class='btn btn-sm btn-primary'>Dailies</button></a>";
    }
    if ((isset($_GET['p'])) && ($_GET['p'] == "bank")) {
        echo "<a href='javascript:void(0)'><button class='btn btn-sm btn-primary' disabled>Bank</button></a>";
    } else {
        echo "<a href='admin.php?p=bank'><button class='btn btn-sm btn-primary'>Bank</button></a>";
    }
    if ((isset($_GET['p'])) && ($_GET['p'] == "discord")) {
        echo "<a href='javascript:void(0)'><button class='btn btn-sm btn-primary' disabled>Discord</button></a>";
    } else {
        echo "<a href='admin.php?p=discord'><button class='btn btn-sm btn-primary'>Discord</button></a>";
    }
    ?>
</div>
<div class="container">
    <?php
    if (!isset($_GET['p'])) {
        include_once('admin_dailies.php');
    } else if ($_GET['p'] == "dailies") {
        include_once('admin_dailies.php');
    } else if ($_GET['p'] == "bank") {
        include_once('admin_bank.php');
    } else if ($_GET['p'] == "discord") {
        include_once('admin_discord.php');
    }
    ?>
</div>

<div class="modal fade" id="giveDailiesModal" tabindex="-1" role="dialog" aria-labelledby="giveDailiesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="giveDailiesModalLabel">Confirm</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <b id="dailiesSelectedUser"><?php echo $firstName; ?></b> will receive <b id="dailiesSelectedQuantity">1</b> Daily Roll
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="giveDailies" class="btn btn-primary">Give Dailies</button>
            </div>
        </div>
    </div>
</div>

<script>
$("#dailiesUser").change(function() {
    $("#dailiesSelectedUser").text($("#dailiesUser option:selected").text());
});
$("#decrementDailies").click(function() {
    var addQuantity = parseInt($("#dailiesQuantity").text());
    if (addQuantity > 1) {
        $("#dailiesQuantity").text(addQuantity-1);
        $("#dailiesSelectedQuantity").text(addQuantity-1);
    }
});
$("#incrementDailies").click(function() {
    var addQuantity = parseInt($("#dailiesQuantity").text());
    if (addQuantity < 30) {
        $("#dailiesQuantity").text(addQuantity+1);
        $("#dailiesSelectedQuantity").text(addQuantity+1);
    }
});
$("#incrementMaxDailies").click(function() {
    $("#dailiesQuantity").text("30");
    $("#dailiesSelectedQuantity").text("30");
})
$("#giveDailies").click(function() {
    $.post("giveDailies.php", {userid: $("#dailiesUser").val(), numgathers: parseInt($("#dailiesQuantity").text())}, function(result) {
        location.reload();
    });
});
</script>

<?php
endif;
?>

<?php
include_once('footer.php');
?>
