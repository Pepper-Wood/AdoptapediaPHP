<?php
include_once('header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenPacaCon();
?>

<style>
#wrapper #content-wrapper {
    background: #EDEFEC;
}
.masterlist {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}
.masterlistCell {
    position: relative;
    width: 33%;
    padding: 1em;
}
.masterlistCell:hover {
    cursor: pointer;
}
.masterlistImg {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.pacadexNum {
    background-color: #C99D5B;
    color: #EDEFEC;
    font-weight: bold;
    padding: 0px 10px;
    border-radius: 40px;
    position: absolute;
    top: 0;
    left: 0;
    font-size: 18px;
    z-index: 10;
}
.pacadexOwner {
    background-color: #925525;
    color: #C99D5B;
    font-weight: bold;
    padding: 0px 10px;
    border-radius: 5px;
    font-size: 16px;
    position: absolute;
    top: 24px;
    left: 10px;
    z-index: 9;
}
</style>
<div class="container-fluid">
    <h1 class="text-center">Pacadex</h1>
    <?php
    if (!isset($_GET['id'])) {
        echo "there's no paca selected";
    } else {
    ?>
    <div class="masterlist">
        <?php
        $transactionsql = "SELECT * FROM `character` WHERE idCharacter='".$_GET['id']."';";
        $transactionresult = mysqli_query($conn, $transactionsql);
        if (mysqli_num_rows($transactionresult) > 0) {
            while ($row = mysqli_fetch_assoc($transactionresult)) { ?>
                <div class="masterlistCell">
                    <div class="pacadexNum"><?php echo $row['idCharacter']; ?></div>
                    <div class="pacadexOwner">Pepper-Wood</div>
                    <img class="masterlistImg" src="<?php echo $row['link']; ?>">
                </div>
        <?  }
        }
        ?>
    </div>
    <?php } ?>
</div>

<?php
CloseCon($conn);
include_once('footer.php');
?>
