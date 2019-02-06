<?php
include_once('header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();
?>

<div class="body">
    <div class="sooshCard">
        <?php
        if (isset($_GET['username'])) {
            echo '<h3 class="sooshCardTitle">'.$_GET['username'].'\'s Inventory</h3>';
    		echo '<div class="sooshCardBody flextable flextable_5cols">';
            $sql = "SELECT userinventories.quantity as quantity, items.itemid as itemid, items.itemname as itemname, items.itemimg as itemimg, items.itemeffect as itemeffect FROM userinventories,items WHERE userinventories.username='".$_GET['username']."' AND userinventories.itemid=items.itemid ORDER BY items.itemid;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $count = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='flextable_cell'>";
					echo "	<img class='rounded-circle img-fluid d-block mx-auto fullWidth' src='img/items/".$row['itemimg']."'>";
					echo "	<p><b>".$row['itemname']."</b></p>";
                    echo "	<p><b>Quantity</b>: ".$row['quantity']."</p>";
					echo '	<p><i>'.$row['itemeffect'].'</i></p>';
					echo "</div>";
                    $count += 1;
                }
                while (($count % 5) != 0) {
                    echo "<div class='flextable_cell'></div>";
                    $count += 1;
                }
            } else {
                echo "You don't have any items yet :<";
            }
            echo "</div>";
        }
        ?>
	</div>
</div>

<?php
include_once('footer.php');
CloseCon($conn);
?>
