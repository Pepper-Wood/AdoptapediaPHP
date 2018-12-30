<?php
include_once('header.php');
?>

<style>
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
.left .studentRow {
    display: flex;
    justify-content: flex-start;
}
.left .dropArea {
    border-left: 2px solid #fe2180;
    margin-left: 5px;
}
.center .studentRow {
    display: flex;
    justify-content: center;
}
.right .studentRow {
    display: flex;
    justify-content: flex-end;
}
.right .dropArea {
    border-right: 2px solid #fe2180;
    margin-right: 5px;
}
.purpleTable {
    width: 70px;
    height: 60px;
    display: block;
    background-color: #fe2180;
    margin: 5px auto 23px;
}
.faded {
    opacity: 0.3;
}
</style>

<div class="container-fluid">
    <h1 class="text-center">Trial Layout</h1>
    <div class="centerRow">
        <div class="sectionCol5 right">
            <div class="studentRow">
            <?php
            for ($x = 1; $x <= 16; $x++) {
                echo '<div class="dropArea" ondrop="drop(event)" ondragover="allowDrop(event)"></div>';
                if ($x % 4 == 0) {
                    echo '</div><div class="studentRow">';
                }
            }
            ?>
            </div>
        </div>
        <div class="sectionCol2 center">
            <div class="purpleTable"></div>
            <div class="studentRow">
                <div class="dropArea" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                <div class="dropArea" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
            </div>
        </div>
        <div class="sectionCol5 left">
            <div class="studentRow">
            <?php
            for ($x = 1; $x <= 16; $x++) {
                echo '<div class="dropArea" ondrop="drop(event)" ondragover="allowDrop(event)"></div>';
                if ($x % 4 == 0) {
                    echo '</div><div class="studentRow">';
                }
            }
            ?>
            </div>
        </div>
    </div>
    <p id="studentRow" class="centerRow">
    <?php
    $sql = "SELECT * FROM students WHERE isAlive=1;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<img id='drag".$row['studentid']."' class='student' src='".$row['studentsprite']."' draggable='true' ondragstart='drag(event)'>";
        }
    }
    ?>
    </p>
    <ul>
        <li>Drag and drop students into their seat</li>
        <li>Click on dropped students once to fade their appearance</li>
        <li>Click on dropped students twice to return them to the drag area</li>
    </ul>
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
