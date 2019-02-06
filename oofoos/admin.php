<?php
include_once('includes/header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();

if (!isset($_SESSION['user'])) :
    include_once('includes/error.php');
elseif ($_SESSION['user']->getType() != 'admin') :
    include_once('includes/error.php');
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
        } else if ($_GET['action'] == 'addItem') {
            echo "<div class='alert alert-success alert-dismissible show' role='alert'>";
            echo "    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            echo "        <span aria-hidden='true'>&times;</span>";
            echo "    </button>";
            echo "    Successfully added item: ".$_GET['name'];
            echo "</div>";
        } else if ($_GET['action'] == 'inputError') {
            echo "<div class='alert alert-danger alert-dismissible show' role='alert'>";
            echo "    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            echo "        <span aria-hidden='true'>&times;</span>";
            echo "    </button>";
            echo "    <b>ERROR</b> - One or more of the inputs were wrong. Please try again.";
            echo "</div>";
        } else if ($_GET['action'] == 'addItemImageError') {
            echo "<div class='alert alert-danger alert-dismissible show' role='alert'>";
            echo "    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            echo "        <span aria-hidden='true'>&times;</span>";
            echo "    </button>";
            echo "    <b>ERROR</b> - ";
            if ($_GET['error'] == 'notAnImage') {
                echo "File is not an image.";
            } else if ($_GET['error'] == 'fileExists') {
                echo "File already exists.";
            } else if ($_GET['error'] == 'tooLarge') {
                echo "File is too large.";
            } else if ($_GET['error'] == 'incorrectType') {
                echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            } else if ($_GET['error'] == 'uploadError') {
                echo "There was an error uploading your file.";
            }
            echo "</div>";
        }
    }
    ?>
    <div class="oofooCard">
        <h3 class="oofooCardTitle">Inventory Management</h3>
        <div class="oofooCardBody">
            <div class="row">
                <div class="col-md-4">
                    <b>Add Inventory to User</b>
                </div>
                <div class="col-md-8">
                    <form action="includes/addInventoryToUser.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="usernames">Username:</label>
                                    <input list="usernames" name="usernames" class="form-control" autocomplete="off">
                                    <datalist id="usernames">
                                        <?php
                            		        $sql = "SELECT DISTINCT username FROM siteusers ORDER BY username;";
                            		        $result = mysqli_query($conn, $sql);
                            		        if (mysqli_num_rows($result) > 0) {
                                                $count = 0;
                            		            while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='".$row['username']."'>";
                            		            }
                            		        }
                            			?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Item:</label>
                                    <input list="items" name="items" class="form-control" autocomplete="off">
                                    <datalist id="items">
                                        <?php
                            		        $sql = "SELECT * FROM items ORDER BY itemid;";
                            		        $result = mysqli_query($conn, $sql);
                            		        if (mysqli_num_rows($result) > 0) {
                                                $count = 0;
                            		            while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='".$row['name']."'>";
                            		            }
                            		        }
                            			?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="removeQuantity">Quantity:</label>
                                    <input type="number" name="addQuantity" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="horizontalFlex">
                            <div class="form-group flexGrow">
                                <label for="transactionreason">Transaction Reason:</label>
                                <input type="text" name="transactionreason" maxlength="50" class="form-control" autocomplete="off">
                            </div>
                            <div class="rightFormButton">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <b>Remove Inventory from User</b>
                </div>
                <div class="col-md-8">
                    <form action="includes/removeInventoryFromUser.php" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="usernames">Username:</label>
                                    <input list="usernames" name="usernames" class="form-control" autocomplete="off">
                                    <datalist id="usernames">
                                        <?php
                            		        $sql = "SELECT DISTINCT username FROM siteusers ORDER BY username;";
                            		        $result = mysqli_query($conn, $sql);
                            		        if (mysqli_num_rows($result) > 0) {
                                                $count = 0;
                            		            while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='".$row['username']."'>";
                            		            }
                            		        }
                            			?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Item:</label>
                                    <input list="items" name="items" class="form-control" autocomplete="off">
                                    <datalist id="items">
                                        <?php
                            		        $sql = "SELECT * FROM items ORDER BY itemid;";
                            		        $result = mysqli_query($conn, $sql);
                            		        if (mysqli_num_rows($result) > 0) {
                                                $count = 0;
                            		            while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='".$row['name']."'>";
                            		            }
                            		        }
                            			?>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="removeQuantity">Quantity:</label>
                                    <input type="number" name="removeQuantity" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="horizontalFlex">
                            <div class="form-group flexGrow">
                                <label for="transactionreason">Transaction Reason:</label>
                                <input type="text" name="transactionreason" maxlength="50" class="form-control" autocomplete="off">
                            </div>
                            <div class="rightFormButton">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="oofooCard">
        <h3 class="oofooCardTitle">Trade Transactions</h3>
        <div class="oofooCardBody">
            <a href="tradeTransactions.php">View all trade transactions</a>
            <table class="table table-striped">
            <thead><tr><th>Transaction Date</th><th>Admin Facilitator</th><th>Sender Name</th><th>Action</th><th>Quantity</th><th>Item Name</th><th>Reason</th></tr></thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM `inventorytransactions` ORDER BY transactiondate DESC LIMIT 5;";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$row['transactiondate']."</td><td>".$row['adminname']."</td><td>".$row['sendername']."</td><td>".$row['action']."</td><td>".$row['quantity']."</td><td>".$row['itemname']."</td><td>".$row['reason']."</td></tr>";
            }
            ?>
            </tbody>
            </table>
        </div>
    </div>
    <div class="oofooCard">
        <h3 class="oofooCardTitle">Current Bank</h3>
        <?php
            $sql = "SELECT siteusers.username as username, items.itemid as itemid, items.name as name, items.img as img, siteuserInventories.quantity as quantity FROM siteuserInventories, siteusers, items WHERE siteuserInventories.itemid=items.itemid AND siteusers.userid=siteuserInventories.userid AND siteuserInventories.quantity!=0 ORDER BY username, itemid;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $currUser = "";
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($currUser != $row['username']) {
                        if ($currUser != "") {
                            echo "</div>";
                        }
                        $currUser = $row['username'];
                        echo "<div class='list-group-item'>";
                        echo "<p>".$row['username']."</p>";
                    }
                    echo '<a href="javascript:void(0)" data-toggle="tooltip" title="'.$row['name'].'">';
                    echo "<div class='bankIcon'>";
                    echo "	<img class='fullWidth' src='images/items/".$row['img']."'>";
                    echo "	<span class='inventoryQuantity'>".$row['quantity']."</span>";
                    echo "</div></a>";
                }
                echo "</div>";
            }
        ?>
    </div>
    <div class="oofooCard">
        <h3 class="oofooCardTitle">Item Database</h3>
        <div class="oofooCardBody">
            <div class="row">
                <div class="col-md-4">
                    <b>Add Item</b>
                </div>
                <div class="col-md-8">
                    <form action="includes/addItemToDatabase.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="itemname">Name:</label>
                                    <input type="text" name="itemname" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="itemtype">Type:</label>
                                    <input type="text" name="itemtype" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="itemimage">Image:</label>
                                    <input type="file" name="itemimage" id="itemimage" autocomplete="off">
                                    <p class = "help-block">Must be 300px by 300px image.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="itemartist">Artist:</label>
                                    <input type="text" name="itemartist" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="horizontalFlex">
                            <div class="form-group flexGrow">
                                <label for="itemdescription">Description:</label>
                                <input type="text" name="itemdescription" maxlength="200" class="form-control" autocomplete="off">
                            </div>
                            <div class="rightFormButton">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

<?php
include_once('includes/footer.php');
CloseCon($conn);
?>
