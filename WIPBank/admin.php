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
    <?php
    if (isset($_GET['action'])) {
        if (($_GET['action'] == 'addInventory') || ($_GET['action'] == 'removeInventory')) {
            echo "<div class='alert alert-success alert-dismissible show' role='alert'>";
            echo "    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            echo "        <span aria-hidden='true'>&times;</span>";
            echo "    </button>";
            if ($_GET['action'] == 'addInventory') {
                echo "    Successfully added ".$_GET['quantity']." ".$_GET['itemname'];
                if ($_GET['quantity'] > 1) { echo "s"; }
                echo " to ".$_GET['username']."'s inventory.";
            } else {
                echo "    Successfully removed ".$_GET['quantity']." ".$_GET['itemname']." from ".$_GET['username']."'s inventory.";
            }
            echo "</div>";
        } else if ($_GET['action'] == 'insufficientInventory') {
            echo "<div class='alert alert-danger alert-dismissible show' role='alert'>";
            echo "    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            echo "        <span aria-hidden='true'>&times;</span>";
            echo "    </button>";
            echo "    <b>ERROR</b> - ".$_GET['username']." does not have ".$_GET['quantity']." ".$_GET['itemname'];
            if ($_GET['quantity'] > 1) { echo "s"; }
            echo " in their inventory to be able to remove ";
            if ($_GET['quantity'] > 1) {
                echo "them";
            } else {
                echo "it";
            }
            echo ".</div>";
        } else if ($_GET['action'] == 'inputError') {
            echo "<div class='alert alert-danger alert-dismissible show' role='alert'>";
            echo "    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            echo "        <span aria-hidden='true'>&times;</span>";
            echo "    </button>";
            echo "    <b>ERROR</b> - One or more of the inputs were wrong. Please try again.";
            echo "</div>";
        }
    }
    ?>
    <?php if($_SESSION['user']->getType() == 'superadmin') : ?>
    <div class="sooshCard">
        <h3 class="sooshCardTitle">Add Inventory to User</h3>
        <div class="sooshCardBody">
            <form action="addInventoryToUser.php" method="post">
                <input list="usernames" name="usernames" placeholder="Username">
                <datalist id="usernames">
                    <?php
        		        $sql = "SELECT DISTINCT username FROM userinventories ORDER BY username;";
        		        $result = mysqli_query($conn, $sql);
        		        if (mysqli_num_rows($result) > 0) {
                            $count = 0;
        		            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['username']."'>";
        		            }
        		        }
        			?>
                </datalist>
                <input list="items" name="items" placeholder="Item">
                <datalist id="items">
                    <?php
        		        $sql = "SELECT * FROM items ORDER BY itemid;";
        		        $result = mysqli_query($conn, $sql);
        		        if (mysqli_num_rows($result) > 0) {
                            $count = 0;
        		            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['itemname']."'>";
        		            }
        		        }
        			?>
                </datalist>
                <input type="number" name="addQuantity" placeholder="Quantity">
                <input type="text" name="transactionreason" maxlength="280" placeholder="Transaction Reason">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
    <div class="sooshCard">
        <h3 class="sooshCardTitle">Remove Inventory from User</h3>
        <div class="sooshCardBody">
            <form action="removeInventoryFromUser.php" method="post">
                <input list="usernames" name="usernames" placeholder="Username">
                <datalist id="usernames">
                    <?php
        		        $sql = "SELECT DISTINCT username FROM userinventories ORDER BY username;";
        		        $result = mysqli_query($conn, $sql);
        		        if (mysqli_num_rows($result) > 0) {
                            $count = 0;
        		            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['username']."'>";
        		            }
        		        }
        			?>
                </datalist>
                <input list="items" name="items" placeholder="Item">
                <datalist id="items">
                    <?php
        		        $sql = "SELECT * FROM items ORDER BY itemid;";
        		        $result = mysqli_query($conn, $sql);
        		        if (mysqli_num_rows($result) > 0) {
                            $count = 0;
        		            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['itemname']."'>";
        		            }
        		        }
        			?>
                </datalist>
                <input type="number" name="removeQuantity" placeholder="Quantity">
                <input type="text" name="transactionreason" maxlength="280" placeholder="Transaction Reason">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div class="sooshCard">
        <h3 class="sooshCardTitle">Current Bank</h3>
        <div class="sooshCardBody">
            <?php
                $sql = "SELECT userinventories.username as username, items.itemid as itemid, items.itemimg as itemimg, userinventories.quantity as quantity FROM userinventories, items WHERE userinventories.itemid=items.itemid ORDER BY username, itemid;";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $currUser = "";
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($currUser != $row['username']) {
                            $currUser = $row['username'];
                            echo "<hr>";
                            echo "<p><a href='https://adoptapedia.com/SushiDogs/inventory.php?username=".$row['username']."'>".$row['username']."</a></p>";
                        }
                        echo "<img class='adminBankIcon' src='img/items/".$row['itemimg']."'> x ".$row['quantity']." ";
                    }
                }
            ?>
        </div>
    </div>
</div>

<?php endif; ?>

<?php
include_once('footer.php');
CloseCon($conn);
?>
