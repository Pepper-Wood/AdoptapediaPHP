<?php
include_once('includes/header.php');
?>

<div class="body">
    <div class="row">
        <?php
        include_once('includes/leftMenu.php');
        ?>
        <div class="col-sm-8">
            <div class="oofooCard">
                <h3 class="oofooCardTitle">Shell Calculator</h3>
        		<div class="oofooCardBody">
                    <select id="artType">
                        <option value='digitalArt'>Digital Art</option>
                        <option value='literature'>Literature</option>
                        <option value='threeDimensional'>3D</option>
                    </select>

                    <hr>

                    <div id="digitalArt" class="pointSection">
                    <input type="radio" name="polish" value="1"> Sketch<br>
                    <input type="radio" name="polish" value="3"> Lineart<br>
                    <br>
                    <input type='checkbox' value='2'> Coloring<br>
                    <input type='checkbox' value='2'> Shading<br>
                    <input type='checkbox' value='5'> Background<br>
                    </div>

                    <div id="literature" class="pointSection">
                        <input id="litInput" type='text' placeholder='Number of Words'>
                    </div>

                    <div id="threeDimensional" class="pointSection">
                        <ul>
                            <li>Plush</li>
                            <li>Clay Figure</li>
                            <li>Needle Felt</li>
                        </ul>
                    </div>

                    <hr>
                    Current Value = <span id="value">0 Shells</span>.
        		</div>
        	</div>
        </div>
    </div>
</div>

<script>
var value = 0;
var selectedPolish = 0;
var litCalc = 0;
$("#digitalArt").show();

function setValue(value) {
    if (value == 1) {
        $("#value").text(value + " Shell");
    } else {
        $("#value").text(value + " Shells");
    }
}

$('#artType').change(function() {
    $(".pointSection").slideUp();
    $("#" + this.value).slideDown();
    $("input[name=polish]").prop( "checked", false );
    $( "input[type=checkbox]" ).prop( "checked", false );
    value = 0;
    if (this.value == "threeDimensional") {
        value = 30;
    }
    setValue(value);
});

$("input[name=polish]").change(function() {
    if (selectedPolish == 0) {
        value += parseInt(this.value);
    } else if (selectedPolish == 1) {
        value += 2;
    } else {
        value -= 2;
    }
    selectedPolish = this.value;
    setValue(value);
});

$("input[type=checkbox]").change(function() {
    if ($(this).is(":checked")) {
        value += parseInt($(this).val());
    } else {
        value -= parseInt($(this).val());
    }
    setValue(value);
});

$("#litInput").keyup(function() {
    litCalc = parseInt(this.value/100);
    if (litCalc > 10) {
        litCalc = 10;
    }
    setValue(value);
});
</script>

<?php
include_once('includes/footer.php');
?>
