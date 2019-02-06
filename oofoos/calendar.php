<?php
date_default_timezone_set('US/Eastern');
include_once('includes/header.php');
?>

<div class="body">
	<div class="oofooCard">
        <h3 class="oofooCardTitle">June 2018</h3>
		<div class="oofooCardBody flextable flextable_7cols">
			<div class='flextable_cell'><b>Sunday</b></div>
			<div class='flextable_cell'><b>Monday</b></div>
			<div class='flextable_cell'><b>Tuesday</b></div>
			<div class='flextable_cell'><b>Wednesday</b></div>
			<div class='flextable_cell'><b>Thursday</b></div>
			<div class='flextable_cell'><b>Friday</b></div>
			<div class='flextable_cell'><b>Saturday</b></div>
            <?php
                $today = date("d");
                $count = 0;
				for ($prevMonth = 0; $prevMonth < 5; $prevMonth++) {
					echo "<div class='flextable_cell pastCell'></div>";
                    $count++;
				}
                for ($day = 1; $day <= 30; $day++) {
					echo "<div class='flextable_cell";
                    if ($day < $today) {
                        echo " pastCell";
                    } else if ($day == $today) {
                        echo " todayCell";
                    }
                    echo "'>";
                    echo "<b>".$day."</b>";
					if ($day == 1) {
                        //echo "<p>Closed Beta begins</p>";
                    }
                    echo "</div>";
					$count++;
                }
                while ($count % 7 != 0) {
                    echo "<div class='flextable_cell pastCell'></div>";
                    $count++;
                }
            ?>
		</div>
    </div>
</div>

<?php
include_once('includes/footer.php');
?>
