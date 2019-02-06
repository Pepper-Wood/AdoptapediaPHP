<?php
include_once('includes/header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();
?>

<div class="body">
	<div class="oofooCard">
        <h3 class="oofooCardTitle">Oofoo Database</h3>
		<div class="oofooCardBody flextable flextable_5cols">
            <?php
		        $sql = "SELECT * FROM oofoos ORDER BY oofooid;";
		        $result = mysqli_query($conn, $sql);
		        if (mysqli_num_rows($result) > 0) {
                    $count = 0;
		            while ($row = mysqli_fetch_assoc($result)) {
						echo "<div class='flextable_cell itemdatabase'>";
                        echo '  <img src="includes/watermark.php?f='.base64_encode($row['img']).'">';
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
