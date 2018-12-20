<?php
include_once('includes/header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();
?>
<style>
.foopediabody {
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
}
.foolink {
    width: 200px;
}
.foolink:hover {
    background-color: #f5f5f5;
    cursor: pointer;
}
.foo {
    display: flex;
    align-items: center;
    position: relative;
}
.fooimg {
    width: 200px;
    height: 200px;
    object-fit: contain;
}
.footheme {
    position: absolute;
    z-index: 2;
    bottom: 0;
    background-color: rgba(225, 225, 225, 0.5);
    width: 100%;
}
</style>
<div class="body">
	<div class="oofooCard">
        <h3 class="oofooCardTitle">Foopedia</h3>
		<div class="oofooCardBody foopediabody">
            <?php
		        $sql = "SELECT * FROM foos ORDER BY fooid DESC;";
		        $result = mysqli_query($conn, $sql);
		        if (mysqli_num_rows($result) > 0) {
		            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <a class="foolink" href="foo.php?id=<?php echo $row['fooid']; ?>">
                    <div class="foo">
                        <img class="fooimg" src="includes/watermark.php?f=<?php echo base64_encode($row['img']); ?>">
                        <div class="footheme"><?php echo $row['img']; ?></div>
    				</div>
                </a>
            <?php
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
