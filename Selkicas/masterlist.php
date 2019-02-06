<?php
include_once('header.php');
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
<div class="foopediabody">
    <?php
        $sql = "SELECT * FROM masterlist ORDER BY charaid DESC;";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <a class="foolink" href="tracker.php?id=<?php echo $row['charaid']; ?>">
            <div class="foo">
                <img class="fooimg" src="<?php echo $row['charaimg']; ?>">
			</div>
        </a>
    <?php
            }
        }
	?>
</div>

<?php
include_once('footer.php');
?>
