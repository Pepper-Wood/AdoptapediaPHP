<?php
include('header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();
?>

<div class="body">
	<div class="sooshCard">
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
                        echo "<img class='bankIcon' src='img/items/".$row['itemimg']."'> x ".$row['quantity']." ";
		            }
		        }
			?>
		</div>
	</div>
</div>

<?php
include_once('footer.php');
CloseCon($conn);
?>
