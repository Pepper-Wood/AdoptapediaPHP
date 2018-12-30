<?php
include_once("header.php");
?>
<button id="testbutton">click me for weekly test</button>

<script>
$("#testbutton").click(function() {
	$.post("asdf_weeklygatherassignments.php", function(result) {
		console.log(result);
	});
});
</script>