<?php
include_once('header.php');
?>

<script>
// JavaScript fun: verifies two things and disables the submit button if at least one test fails
// NOTE: disabling the submit button is not a foolproof way to stop submission errors, thus
// errors are checked again in the PHP. 
function verify() {
    var catsFailed = false;
    var e = document.getElementsByClassName("cats");
    var maxCats = 2;
    var checkedNum = 0;
    for (i = 0; i < e.length; i++) {
        if (e[i].checked) {
            checkedNum++;
        }
    }
    // Disable checkboxes once a user has selected two categories
    for (i = 0; i < e.length; i++) {
        if (checkedNum >= maxCats) {
           if (!e[i].checked) {
               e[i].setAttribute('disabled','disabled');
           }
        } else {
            e[i].removeAttribute('disabled');
        }
    }
    // If a user has entered no category or somehow exceeded two categories, verification fails
    if (checkedNum == 0 || checkedNum > maxCats) {
        catsFailed = true;
    } else {
        catsFailed = false;
    }

    str = document.getElementsByName("groupname")[0].value;
    
    // Use AJAX to verify correctness of group name
    // Only checks against malformed group names or group names already in the database
    // (i.e. checks that take a fraction of a second)
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "SUCCESS") {
                document.getElementById("grouptext").innerHTML = "Looks good!";
                document.getElementById("group").className = "form-group has-success";
                if (!catsFailed) {
                    document.getElementById('submit').removeAttribute('disabled');
                } else {
                    document.getElementById('submit').setAttribute('disabled','disabled');
                }
            } else {
                document.getElementById("grouptext").innerHTML = this.responseText;
                document.getElementById("group").className = "form-group has-error";
                document.getElementById('submit').setAttribute('disabled','disabled');
            }
        }
    };
    xmlhttp.open("GET", "util/verifyname.php?q=" + str, true);
    xmlhttp.send();
}
</script>

<div class='container'><h2>Submit an Original Species</h2><p>Fill this form out if you want to submit your open, semi-open, or closed species to our database. You must be the owner of the species to submit it.</p>
<p><b style="color:#ff0000;">Note: This form does not work yet. It is here for testing purposes</b></p>
<hr>

<form class="form-horizontal">
<fieldset>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Species Name</label>  
  <div class="col-md-4">
  <input id="textinput" name="textinput" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="filebutton">Thumbnail Image</label>
  <div class="col-md-4">
    <input id="filebutton" name="filebutton" class="input-file" type="file">
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Availability Status</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="1">Open</option>
      <option value="2">Semi-Open</option>
      <option value="3">Closed</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Reference Sheet URL</label>  
  <div class="col-md-4">
  <input id="textinput" name="textinput" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="selectbasic">Species Status</label>
  <div class="col-md-4">
    <select id="selectbasic" name="selectbasic" class="form-control">
      <option value="1">Active</option>
      <option value="2">Retired</option>
    </select>
  </div>
</div>

<!-- Multiple Checkboxes (inline) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="checkboxes">Tags</label>
  <div class="col-md-4">
    <label class="checkbox-inline" for="checkboxes-0">
      <input type="checkbox" name="checkboxes" id="checkboxes-0" value="1">
      Human/Humanoid
    </label>
    <label class="checkbox-inline" for="checkboxes-1">
      <input type="checkbox" name="checkboxes" id="checkboxes-1" value="2">
      Anthro
    </label>
    <label class="checkbox-inline" for="checkboxes-2">
      <input type="checkbox" name="checkboxes" id="checkboxes-2" value="3">
      Feral
    </label>
  </div>
</div>

<!-- Text input
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Additional Links</label>  
  <div class="col-md-4">
  <input id="textinput" name="textinput" type="text" placeholder="" class="form-control input-md">
  <span class="help-block">i.e. links to masterlist, official website, etc. Maximum of 3 links.</span>  
  </div>
</div> -->

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Official Artist/Partner</label>  
  <div class="col-md-4">
  <input id="textinput" name="textinput" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Extra Links input -->
<div class="form-group">
	<label class="col-md-4 control-label" for="textinput">Additional Links</label>
	<div class="col-md-4">
		<button type = "button" class = "btn btn-success" id="add">Add Field</button>
	</div>
</div><div class="form-group">
	<div class="col-md-4"></div>
	<div id="items" class="col-md-4" style="background-color:#ff00ff;">
		<div action="" class="form-inline">
			<div class="form-group"><input type="text" class="form-control" placeholder="MinVal"></div>
			<div class="form-group"><input type="text" class="form-control" placeholder="MaxVal"></div>
		</div>
	</div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label"> </label>  
  <div class="col-md-4">
  <input type='submit' id='submit' class='btn btn-block btn-info' value='Submit' disabled>
    
  </div>
</div>
</fieldset>
</form>



	
	
	</div><div class='modal fade' id='CategoriesModal' role='dialog'>
<div class='modal-dialog'>
<div class='modal-content'>
<div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    <h2 class="modal-title text-center">Categories</h2> 
</div>
<div class='modal-body'>
    <p class="text-center">Each adoptable group falls under various categories to help you be able to filter them according to your tastes. Below are the definitions for the abbreviations shown:</p>
    <table class='table table-striped'>
        <tr><td><b>All</b></td><td>Adoptable groups without restrictions on submissions.</td></tr>
        <tr><td><b>Agency</b></td><td>Adoptable Agencies. These are typically groups where purchasing adopts is done via an in-world currency and also focus more on roleplay than exchanging money.</td></tr>
        <tr><td><b>Closed</b></td><td>User-made species restricted groups. Named closed due to the vast majority of user-made species being closed species. However, this category also contains groups for open species.</td></tr>
        <tr><td><b>Fandom</b></td><td>Fandom-based groups, i.e. groups that accept adopts that fall within a popular show or game's universe like Homestuck or My Little Pony.</td></tr>
        <tr><td><b>Misc</b></td><td>Groups that don't fall under the other categories, i.e. adoptable base groups and hatchable groups.</td></tr>
        <tr><td><b>Payment</b></td><td>Payment-restricted groups, i.e. groups that only accept points or paypal for payment.</td></tr>
        <tr><td><b>Quality</b></td><td>Quality-restricted groups. These may require artists to submit an application before being accepted and allowed to submit.</td></tr>
        <tr><td><b>Species</b></td><td>Groups that filter based on generalized species. For example, canine-only, feline-only, kemonomimi-only, etc. This does not include user-made species.</td></tr>
    </table>
</div></div></div></div>

<script>
//when the Add Field button is clicked
$("#add").click(function (e) {
 //Append a new row of code to the "#items" div
 alert("The paragraph was clicked.");
 $("#items").append('<div><div class="form-inline"><div class="form-group"><input type="text" class="form-control" placeholder="MinVal"></div><div class="form-group"><input type="text" class="form-control" placeholder="MaxVal"></div><div class="form-group"><button type = "button" class = "btn btn-danger delete">Delete</button></div></div></div>'); });


$("body").on("click", ".delete", function (e) {
	$(this).parent("div").parent("div").remove();
});
</script>

<?php
include_once('footer.php');
?>