<?php
include_once('header.php');

echo "<div class='container' style='margin-top: 20px;'>";

// Color button generation
echo "<button class='btn' onclick='randomizeColorAll()' style='width:100%';><b>randomize all colors</b></button>";
echo "<div class='row' style='padding: 10px 0;'>";
for ($x = 1; $x <= 3; $x++) {
    echo "<div class='col-md-4'><button id='color$x' type='button' class='btn btn-lg btn-block' onclick='randomizeColor(this.id)' style='color: #ffffff; text-shadow: 2px 2px 2px #000000; height:200px; background-color:#000000;'></button></div>";
}
echo "</div>";

// Word button generation
echo "<button class='btn' onclick='randomWordsAll()' style='width:100%';><b>randomize all words</b></button>";
echo "<div class='row' style='padding: 10px 0;'>";
for ($x = 1; $x <= 3; $x++) {
    echo "<div class='col-md-4'><button id='word$x' type='button' class='btn btn-lg btn-block' onclick='randomWords(this.id)'></button></div>";
}
echo "</div>";

// Image button generation
echo "<button class='btn' onclick='randomImageAll()' style='width:100%';><b>randomize all images</b></button>";
echo "<div class='row' style='padding: 10px 0;'>";
for ($x = 1; $x <= 3; $x++) {   
    echo "<div class='col-md-4'>";
    echo "<button id='image$x' class='btn btn-block' onclick ='randomImage(this.id)' style='padding:10px;'>regenerate Image $x</button>";
    echo "<a target='_blank' id='linkimage$x' href=''><img id='randimage$x' src='' class='img-cropped' style='object-fit:cover' height=400px width=400px></a>";
    echo "</div>";
}
echo "</div>";

echo "</div>";
?>

<script>
function randomizeColor(clicked_id) {
    var newColor = randomColors();
    document.getElementById(clicked_id).style.backgroundColor = newColor;
    document.getElementById(clicked_id).innerHTML = newColor.toUpperCase();
}

function randomizeColorAll() {
    for (i=1; i<4;i++) {
        var clicked_id = "color" + i;
        randomizeColor(clicked_id); 
    }
}

function randomColors() {
    var newColor =  Math.floor(Math.random() * 16777215).toString(16);
        while (newColor.length < 6) {
            newColor = "0" + newColor;
        }
    newColor = "#" + newColor;
    return newColor;
}

function randomWords(clicked_id) {
    var nouns= <?php echo trim(file_get_contents('assets/nouns.json')); ?>;
    var word = nouns[Math.floor(Math.random()*nouns.length)];
    document.getElementById(clicked_id).innerHTML = word;
}

function randomWordsAll() {
    for (i=1; i<4;i++) {
        var clicked_id = "word" + i;
        randomWords(clicked_id);
    }
}

function randomImage(clicked_id) {
    var images = <?php echo trim(file_get_contents('assets/inspirations.json')); ?>;
    var element = images[Math.floor(Math.random()*images.length)];
    document.getElementById('rand' + clicked_id).src = element.src;
    document.getElementById('link' + clicked_id).href = element.page;
}

function randomImageAll() {
    for (i=1; i<4;i++) {
        var clicked_id = "image" + i;
        randomImage(clicked_id);
    }
}
</script>

<body onload="randomizeColorAll(); randomWordsAll(); randomImageAll(); ">

<?php
include_once('footer.php');
?>