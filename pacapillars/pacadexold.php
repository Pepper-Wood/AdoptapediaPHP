<?php
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenPacaCon();

?>
<style>
img {
    display: inline;
    width: 100px;
}
</style>
<div>
    <?php
        $sql = "SELECT * FROM `character` ORDER BY idCharacter DESC;";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <img src="<?php echo $row['link']; ?>">
    <?php
            }
        }
	?>
</div>

<?php
CloseCon($conn);
?>
