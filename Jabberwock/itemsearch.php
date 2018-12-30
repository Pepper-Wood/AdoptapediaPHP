<?php
include_once('header.php');
?>
<style>
canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>

<div class="container-fluid">
	<h1 class="text-center">Item Search</h1>
    Look for ...
    <select id="scavengerItem">
    <?php
    $sql = "SELECT * FROM items ORDER BY itemname;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <option value="<?php echo $row['itemid']; ?>"<?php if ((isset($_GET['iid'])) && ($_GET['iid'] == $row['itemid'])) { echo " selected"; }?>><?php echo $row['itemname']; ?></option>
    <?  }
    }
    echo "</select><br><hr>";

    if (isset($_GET['iid'])) {
        $sql = mysqli_query($conn, "SELECT itemname FROM items WHERE itemid=".$_GET['iid'].";");
        $row = mysqli_fetch_assoc($sql);
        echo "Showing results for: <b>".$row['itemname']."</b>";
        ?>
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
        <?php

        $sql = "SELECT ownerid, username, quantity FROM inventories LEFT JOIN siteusers ON inventories.ownerid=siteusers.userid WHERE itemid=".$_GET['iid']." AND quantity > 0 AND type != 'user' ORDER BY quantity desc,username;";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$row['quantity']."</td><td><a target='_blank' href='https://adoptapedia.com/Jabberwock/inventories.php?uid=".$row['ownerid']."'>".$row['username']."</a></td></tr>";
            }
        }
        echo "</tbody></table>";
    }
    ?>
</div>

<script>
$("#scavengerItem").change(function() {
    window.location.href = "https://adoptapedia.com/Jabberwock/itemsearch.php?iid=" + $(this).val();
});
</script>

<?php
include_once('footer.php');
?>
