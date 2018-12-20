<?php
include_once('header.php');
?>

<style>
img {
    vertical-align: baseline;
}
.centerRow {
    display: flex;
    justify-content: center;
}
.dropArea {
    display: inline-block;
    width: 30px;
    height: 35px;
    border-bottom: 1px dotted #cecece;
}
.sectionCol5 {
    width: 150px;
}
.sectionCol2 {
    width: 100px;
}
.studentRow {
    height: 35px;
}
.studentSection {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.faded {
    opacity: 0.3;
}
</style>

<div class="container-fluid">
    <h1 class="text-center">Trial Layout</h1>
    <p id="studentRow" class="centerRow">
        <?php
        $sql = "SELECT * FROM students WHERE isAlive=1;";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<img id='drag".$row['studentid']."' class='student' src='studentsprites/originalsprites/".$row['studentsprite']."' draggable='true' ondragstart='drag(event)'>";
            }
        }
        ?>
    </p>
    <div class="studentRow">
        <?php
        $rows = 10;
        $cols = 20;
        for ($x = 1; $x <= ($rows*$cols); $x++) {
            echo '<div class="dropArea" ondrop="drop(event)" ondragover="allowDrop(event)"></div>';
            if ($x % $cols == 0) {
                echo '</div><div class="studentRow">';
            }
        }
        ?>
    </div>
</div>

<script>
function allowDrop(ev) {
    ev.preventDefault();
}
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}
function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
}
$(".student").click(function() {
    if ($(this).hasClass("faded")) {
        $(this).removeClass("faded");
        console.log($(this).parent().html());
        $("#studentRow").append($(this).parent().html());
        $(this).remove();
    } else {
        $(this).addClass("faded");
    }
});
</script>
<?php
include_once('footer.php');
?>
