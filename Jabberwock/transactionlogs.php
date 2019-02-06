<?php
include_once('header.php');
?>
<style>
table td:nth-child(1) {
    width: 150px;
}
td {
    padding-right: 5px !important;
}
.actionPill {
    font-size: 12px;
    color: #FFF;
    padding: 2px;
    border-radius: 5px;
}
.bgadd { background-color: #2196f3; }
.bgremove { background-color: #f44336; }
.bgdaily { background-color: #9c27b0; }
.bgmonthly { background-color: #ffc107; }
.bgcraft { background-color: #4caf50; }
</style>

<?php
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

<div class="container-fluid">
    <h1 class="text-center">Transaction Logs</h1>
    View Transaction Logs of
    <select id="transactionLogSelect">
    <?php
    $sql = "SELECT userid,username FROM siteusers WHERE type != 'user' ORDER BY username;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<option value='all'>--View All--</option>";
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <option value="<?php echo $row['userid']; ?>"<?php if ((isset($_GET['uid'])) && ($_GET['uid'] == $row['userid'])) { echo " selected"; }?>><?php echo $row['username']; ?></option>
    <?  }
    }
    echo "</select><br>";

    $numEntriesSql = mysqli_query($conn, "SELECT COUNT(*) as numEntries FROM transactionhistory;");
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
    <table class="table table-sm table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Action</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            date_default_timezone_set("America/New_York");

            $numTransactionSql = mysqli_query($conn, "SELECT COUNT(*) as transcount FROM transactionhistory;");
            $numTransactionRow = mysqli_fetch_assoc($numTransactionSql);
            $numTransactions = $numTransactionRow['transcount'];

            $transactionsql = "SELECT * FROM transactionhistory LEFT JOIN siteusers ON transactionhistory.userid=siteusers.userid LEFT JOIN items ON transactionhistory.itemid=items.itemid ";
            if (isset($_GET['uid'])) {
                $transactionsql .= "WHERE transactionhistory.userid=".$_GET['uid']." ";
            }
            $transactionsql .= "ORDER BY timestamp DESC LIMIT ".$pagesize." OFFSET ".$offset.";";
            $transactionresult = mysqli_query($conn, $transactionsql);
            if (mysqli_num_rows($transactionresult) > 0) {
                while ($row = mysqli_fetch_assoc($transactionresult)) { ?>
                    <tr>
                        <td><?php echo date('M d h:i a',$row['timestamp']); ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><span class="actionPill bg<?php echo $row['action']; ?>"><?php echo $row['action']; ?></span></td>
                        <td><?php echo $row['fullaction']; ?></td>
                    </tr>
            <?  }
            }
            ?>
        </tbody>
    </table>
</div>

<script>
$("#transactionLogSelect").change(function() {
    if ($(this).val() == "all") {
        window.location.href = "https://adoptapedia.com/Jabberwock/transactionlogs.php";
    } else {
        window.location.href = "https://adoptapedia.com/Jabberwock/transactionlogs.php?uid=" + $(this).val();
    }
});
</script>

<?php
include_once('footer.php');
?>
