<?php
include_once('includes/header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();
?>

<div class="body">
	<div class="oofooCard">
        <h3 class="oofooCardTitle">All Items</h3>
		<div class="oofooCardBody flextable flextable_5cols">
            <?php
		        $sql = "SELECT * FROM items ORDER BY itemid;";
		        $result = mysqli_query($conn, $sql);
		        if (mysqli_num_rows($result) > 0) {
                    $count = 0;
		            while ($row = mysqli_fetch_assoc($result)) {
						echo "<div class='flextable_cell itemdatabase'>";
						echo "	<img class='fullWidth' src='images/items/".$row['img']."'>";
						echo "	<h3>".$row['name']."</h3>";
                        echo '	<p class="itemdatabase_type"><i>'.$row['type'].'</i></p>';
						echo '	<p class="itemdatabase_description">'.$row['description'].'</p>';
                        echo '	<p class="itemdatabase_artist">Art by <a href="https://'.$row['artist'].'.deviantart.com/">'.$row['artist'].'</a></p>';
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

<?php
include_once('includes/footer.php');
CloseCon($conn);
?>
