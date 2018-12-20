<?php
include_once('header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();
?>

<div class="body">
	<div class="sooshCard">
		<div class="sooshCardBody flextable flextable_5cols">
			<?php
		        $sql = "SELECT * FROM items ORDER BY itemid;";
		        $result = mysqli_query($conn, $sql);
		        if (mysqli_num_rows($result) > 0) {
                    $count = 0;
		            while ($row = mysqli_fetch_assoc($result)) {
						echo "<div class='flextable_cell'>";
						echo "	<img class='rounded-circle img-fluid d-block mx-auto fullWidth' src='img/items/".$row['itemimg']."'>";
						echo "	<p><b>".$row['itemname']."</b></p>";
						echo '	<p><i>'.$row['itemeffect'].'</i></p>';
						echo "</div>";
                        $count += 1;
		            }
                    while (($count % 5) != 0) {
                        echo "<div class='flextable_cell'></div>";
                        $count += 1;
                    }
		        } else {
			        echo "You do not have any sooshes registered here yet :<";
			    }
			?>
		</div>
	</div>
</div>

<?php
include_once('footer.php');
CloseCon($conn);
?>
