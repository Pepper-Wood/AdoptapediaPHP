<?php
include_once('header.php');
?>
<style>
.studentHeightWrapper {
    overflow: hidden;
    white-space: nowrap;
}
.studentHeightSprite {
    vertical-align: bottom;
    image-rendering: pixelated;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
}
.ruler {
    width: 80px;
    display: flex;
    justify-content: flex-end;
    flex-direction: column;
}
.ruler>div {
    height: <?php echo (15.24*1.5); ?>px;
    border-left: 1px solid #000;
    border-top: 1px dotted #000;
}
.doubleTop {
    border-top: 2px solid #000 !important;
}
.flexRow {
    display: flex;
    justify-content: space-between;
}
.studentHeightWrapper a {
    display: inline-block;
}
.slidecontainer {
    width: 100%;
}
.slider {
    -webkit-appearance: none;
    width: 100%;
    height: 25px;
    background: #d3d3d3;
    outline: none;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
}
.slider:hover {
    opacity: 1;
}
.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 25px;
    height: 25px;
    background: #FE2181;
    cursor: pointer;
}
.slider::-moz-range-thumb {
    width: 25px;
    height: 25px;
    background: #FE2181;
    cursor: pointer;
}
</style>
<?php
$query = "studentname";
if (isset($_GET['q'])) {
    $query = $_GET['q'];
}
?>

<div class="container-fluid">
    <h1 class="text-center">Student Heights</h1>
    Sort by: <select id="sortHeightSelect">
        <option value='studentname' <?php if ($query == "studentname") { echo "selected"; } ?>>Name, A-Z</option>
        <option value='cmheight-DESC' <?php if ($query == "cmheight-DESC") { echo "selected"; } ?>>Tallest to Shortest</option>
        <option value='cmheight-ASC' <?php if ($query == "cmheight-ASC") { echo "selected"; } ?>>Shortest to Tallest</option>
    </select>
    <br>
    <hr>
    <div class="flexRow">
        <div class="ruler">
            <div class="doubleTop"></div>
            <div></div>
            <div class="doubleTop"></div>
            <div></div>
            <div class="doubleTop"></div>
            <div></div>
            <div class="doubleTop"></div>
            <div></div>
            <div class="doubleTop"></div>
            <div></div>
            <div class="doubleTop"></div>
            <div></div>
        </div>
        <div id="studentHeightWrapper" class="studentHeightWrapper">
            <?php
            $sql = "SELECT * FROM students ORDER BY ".str_replace("-"," ",$query).";";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['cmheight'] != 0) {
                        echo '<a href="javascript:void(0)" data-toggle="tooltip" title="" data-original-title="'.$row['cmheight'].'cm">';
                        echo "  <img class='studentHeightSprite' src='studentsprites/croppedsprites/".$row['studentsprite']."' style='height: ".($row['cmheight']*1.5)."px;'>";
                        echo "</a>";
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="slidecontianer">
        <input type="range" id="scrollbarRange" min="0" max="1000" value="0" class="slider">
    </div>
</div>

<script>
$("#sortHeightSelect").change(function() {
    window.location.href = "https://jabberwock-isle.com/studentheights.php?q=" + $(this).val();
});
$('#scrollbarRange').on("change mousemove", function() {
    var maxscrollleft = $('#studentHeightWrapper').get(0).scrollWidth - $('#studentHeightWrapper').get(0).clientWidth;
    var scrollLeftVal = ($(this).val()*0.001)*maxscrollleft;
    $("#studentHeightWrapper").scrollLeft(scrollLeftVal);
});
</script>

<?php
include_once('footer.php');
?>
