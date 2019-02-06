<?php
include_once('includes/header.php');
include_once('../HIDDEN/DB_CONNECTIONS.php');
$conn = OpenOofooCon();
?>

<?php
if (!isset($_SESSION['user'])) :
    include_once('includes/error.php');
else : ?>

<div class="body">
    <?php
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'themeChange') {
            echo "<div class='alert alert-success alert-dismissible show' role='alert'>";
            echo "    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
            echo "        <span aria-hidden='true'>&times;</span>";
            echo "    </button>";
            echo "    Successfully changed website theme";
            echo "</div>";
        }
    }
    ?>
    <div class="oofooCard">
        <h3 class="oofooCardTitle">Change Theme Color</h3>
        <div class="oofooCardBody">
            <?php
                $userthemesql = "SELECT * FROM sitestyles, siteusers WHERE siteusers.userid=".$_SESSION['user']->getID()." AND sitestyles.styleid=siteusers.styleid;";
                $userthemeresult = mysqli_query($conn, $userthemesql);
                if (mysqli_num_rows($userthemeresult) > 0) {
                    $userthemerow = mysqli_fetch_assoc($userthemeresult);
                    $styleid = $userthemerow['styleid'];
                }

		        $sql = "SELECT * FROM sitestyles;";
		        $result = mysqli_query($conn, $sql);
		        if (mysqli_num_rows($result) > 0) {
		            while ($row = mysqli_fetch_assoc($result)) {
						echo "<div id='styleid".$row['styleid']."' class='websitestylecell";
                        if ($styleid == $row['styleid']) {
                            echo " shadow";
                        }
                        echo "' style='background-color:".$row['secondarycolor'].";border-color:".$row['primarycolor'].";'></div>";
		            }
		        }
			?>
        </div>
    </div>
</div>

<script>
$(".websitestylecell").click(function() {
    var styleid = $(this).attr("id").replace("styleid","");
    $.post("includes/changeTheme.php",
        { style_id: styleid  },
        function(response) {
            window.location.replace("https://adoptapedia.com/oofoos/settings.php?action=themeChange");
        }
    );
});
</script>

<?php endif; ?>

<?php
include_once('includes/footer.php');
CloseCon($conn);
?>
