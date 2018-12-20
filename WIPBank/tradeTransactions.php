<?php
include_once('header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();
?>

<?php
if (!isset($_SESSION['user'])) :
    include_once('error.php');
elseif (($_SESSION['user']->getType() != 'admin') && ($_SESSION['user']->getType() != 'superadmin')) :
    include_once('error.php');
else : ?>

<div class="body">
    <div class="oofooCard">
        <h3 class="oofooCardTitle">Trade Transactions</h3>
        <div class="oofooCardBody">
            <table class="table table-striped">
            <thead><tr><th>Transaction Date</th><th>Admin Facilitator</th><th>Sender Name</th><th>Action</th><th>Quantity</th><th>Item Name</th><th>Reason</th></tr></thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM `inventorytransactions` ORDER BY transactiondate DESC;";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$row['transactiondate']."</td><td>".$row['adminname']."</td><td>".$row['sendername']."</td><td>".$row['action']."</td><td>".$row['quantity']."</td><td>".$row['itemid']."</td><td>".$row['reason']."</td></tr>";
            }
            ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php endif; ?>

<?php
include_once('footer.php');
CloseCon($conn);
?>
