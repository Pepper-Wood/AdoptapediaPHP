<?php
include_once('header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenPacaCon();

function paginationCell($currPage) {
    global $pagenum;
    echo '<li class="page-item';
    if ($pagenum == $currPage) {
        echo ' active';
    }
    echo '"><a class="page-link" href="?page='.$currPage.'">'.$currPage.'</a></li>';
}
function disabledPaginationCell() {
    echo '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)">...</a></li>';
}

$pagenum = 1;
$offset = 0;
$pagesize = 30;
if (isset($_GET['page'])) {
    $pagenum = (int)$_GET['page'];
    $offset = $pagesize * ($pagenum-1);
}
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
    $numEntriesSql = mysqli_query($conn, "SELECT COUNT(*) as numEntries FROM `character`;");
    $numEntriesRow = mysqli_fetch_assoc($numEntriesSql);
    $numEntries = $numEntriesRow['numEntries'];
    echo "<hr>";
    ?>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
        <?php
            $numpages = ceil($numEntries/$pagesize);
            $lowerRange = $pagenum-2;
            $upperRange = $pagenum+2;
            $leftDotFlag = True;
            $rightDotFlag = True;
            if (($pagenum >= 1) && ($pagenum <= 4)) {
                $lowerRange = 2;
                $upperRange = 6;
                $leftDotFlag = False;
            }
            if (($pagenum >= ($numpages-3)) && ($pagenum <= $numpages)) {
                $lowerRange = $numpages-5;
                $upperRange = $numpages-1;
                $rightDotFlag = False;
            }

            echo '<li class="page-item';
            if ($pagenum == 1) {
                echo ' disabled';
            }
            echo '"><a class="page-link" href="?page='.($pagenum-1).'">Previous</a></li>';
            paginationCell(1);
            if ($leftDotFlag) { disabledPaginationCell(); }
            for ($x = $lowerRange; $x <= $upperRange; $x++) {
                paginationCell($x);
            }
            if ($rightDotFlag) { disabledPaginationCell(); }
            paginationCell($numpages);
            echo '<li class="page-item';
            if ($pagenum == $numpages) {
                echo ' disabled';
            }
            echo '"><a class="page-link" href="?page='.($pagenum+1).'">Next</a></li>';
        ?>
        </ul>
    </nav>
    <div class="masterlist">
        <?php
        $transactionsql = "SELECT * FROM `character` ORDER BY idCharacter DESC LIMIT ".$pagesize." OFFSET ".$offset.";";
        $transactionresult = mysqli_query($conn, $transactionsql);
        if (mysqli_num_rows($transactionresult) > 0) {
            while ($row = mysqli_fetch_assoc($transactionresult)) { ?>
                <div class="masterlistCell">
                    <a class="clearLink" href="pacaprofile.php?id=<?php echo $row['idCharacter']; ?>">
                        <div class="pacadexNum"><?php echo $row['idCharacter']; ?></div>
                        <div class="pacadexOwner">Pepper-Wood</div>
                        <img class="masterlistImg" src="<?php echo $row['link']; ?>">
                    </a>
                </div>
        <?  }
        }
        ?>
    </div>
</div>

<?php
CloseCon($conn);
include_once('footer.php');
?>
