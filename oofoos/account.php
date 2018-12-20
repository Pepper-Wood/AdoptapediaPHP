<?php
include_once('includes/header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();
?>

<div class="body">
    <div class="row">
        <?php
        include_once('includes/leftMenu.php');
        ?>
        <div class="col-sm-8">
            <div class="oofooCard">
                <h3 class="oofooCardTitle">Your Inventory</h3>
        		<div class="oofooCardBody flextable flextable_5cols">
                    <?php
                        $sql = "SELECT items.name, items.img, siteuserInventories.quantity FROM siteuserInventories, items WHERE siteuserInventories.itemid=items.itemid AND userid=".$_SESSION['user']->getID().";";
        		        $result = mysqli_query($conn, $sql);
        		        if (mysqli_num_rows($result) > 0) {
                            $count = 0;
        		            while ($row = mysqli_fetch_assoc($result)) {
        						echo "<div class='flextable_cell inventoryItem'>";
        						echo "	<img class='fullWidth' src='images/items/".$row['img']."'>";
        						echo "	<p><b>".$row['name']."</b></p>";
                                echo "	<span class='inventoryQuantity'>".$row['quantity']."</span>";
        						echo "</div>";
                                $count += 1;
        		            }
                            while (($count % 5) != 0) {
                                echo "<div class='flextable_cell'></div>";
                                $count += 1;
                            }
        		        }
        			?>
        		</div>
        	</div>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.php');
CloseCon($conn);
?>
