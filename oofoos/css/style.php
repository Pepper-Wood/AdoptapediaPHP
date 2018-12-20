<?php
    require('../../util/User.php');
    session_start();

    ob_start ("ob_gzhandler");
    header("Content-type: text/css; charset: UTF-8");
    header("Cache-Control: must-revalidate");
    $offset = 60 * 60;
    $ExpStr = "Expires: ".gmdate("D, d M Y H:i:s", time() + $offset)." GMT";
    header($ExpStr);

    include_once('../HIDDEN/DB_CONNECTIONS.php');
    $conn = OpenOofooCon();

    $primaryColor = "#981ceb";
    $secondaryColor = "#f4e8fd";

    if (isset($_SESSION['user'])) {
        $sql = "SELECT * FROM sitestyles, siteusers WHERE siteusers.userid=".$_SESSION['user']->getID()." AND sitestyles.styleid=siteusers.styleid;";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $primaryColor = $row['primarycolor'];
            $secondaryColor = $row['secondarycolor'];
        }
    }
?>
@font-face {
    font-family: EarlGrayTea-Regular;
    src: url(../fonts/EarlGrayTea-Regular.otf);
}
@font-face {
    font-family: HelloSunshine_ornaments;
    src: url(../fonts/HelloSunshine_ornaments.otf);
}
@font-face {
    font-family: HelloSunshine;
    src: url(../fonts/HelloSunshine.otf);
}
@font-face {
    font-family: HelloSunshineItalic;
    src: url(../fonts/HelloSunshineItalic.otf);
}
@font-face {
    font-family: HelloSunshineMarker;
    src: url(../fonts/HelloSunshineMarker.otf);
}

body {
    box-sizing: border-box;
    margin: 0;
    background-image: url(../images/background.jpg);
    background-size: 50px;
    font-family: 'Roboto', sans-serif;
}
h1 {
    font-family: HelloSunshine;
}
h2, h3, h4 {
    font-family: HelloSunshineMarker;
}
a, a:hover, a:focus {
    color: <?php echo $primaryColor; ?>;
    text-decoration: none;
}
.fullWidth {
    width: 100%;
}
.btn-primary, .btn-primary:hover, .btn-primary:focus {
    background-color: <?php echo $secondaryColor; ?>;
    color: <?php echo $primaryColor; ?>;
    border-color: <?php echo $secondaryColor; ?>;
}
.btn-secondary, .btn-secondary:hover, .btn-secondary:focus {
    background-color: #ffadb9;
    color: <?php echo $primaryColor; ?>;
    border-color: <?php echo $secondaryColor; ?>;
}
.btn-primary.active.focus, .btn-primary.active:focus, .btn-primary.active:hover, .btn-primary:active.focus, .btn-primary:active:focus, .btn-primary:active:hover, .open>.dropdown-toggle.btn-primary.focus, .open>.dropdown-toggle.btn-primary:focus, .open>.dropdown-toggle.btn-primary:hover, .btn-primary.active, .btn-primary:active, .open>.dropdown-toggle.btn-primary {
    color: <?php echo $primaryColor; ?>;
    background-color: <?php echo $secondaryColor; ?>;
    border-color: <?php echo $secondaryColor; ?>;
}
.btn-deviantart, .btn-deviantart:hover, .btn-deviantart:focus {
    background-color: #51cc74;
    color: #FFF;
    border-color: #51cc74;
}
.navbar-default {
    background-color: #FFF;
    border: 0;
    border-radius: 0;
    border-bottom: 5px solid <?php echo $secondaryColor; ?>;
    margin-bottom: 0;
}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
    color: <?php echo $primaryColor; ?>;
    background-color: <?php echo $secondaryColor; ?>;
}
li.dropdown:hover > .dropdown-menu {
    display: block;
}
.dropdown-divider {
    border-top: 1px solid #eee;
}
.horizontalFlex {
    display: flex;
    justify-content: space-between;
}
.flexGrow {
    flex-grow: 1;
}
.padding {
    padding: 10px;
}
.flextable {
    display: flex;
    flex-wrap: wrap;
    margin: 0 0 3em 0;
    padding: 0;
}
.flextable_cell {
    box-sizing: border-box;
    flex-grow: 1;
    width: 100%;
    padding: 0.8em 1.2em;
    overflow: hidden;
    list-style: none;
    border: solid @bw white;
    background: fade(slategrey,20%);
    > h1, > h2, > h3, > h4, > h5, > h6 { margin: 0; }
}
.flextable_2cols > .flextable_cell  { width: 50%; }
.flextable_3cols > .flextable_cell  { width: 33.33%; }
.flextable_4cols > .flextable_cell  { width: 25%; }
.flextable_5cols > .flextable_cell  { width: 20%; }
.flextable_6cols > .flextable_cell  { width: 16.6%; }
.flextable_7cols > .flextable_cell  { width: 14.28%; }
.body {
    background-color: rgba(255,255,255,0.7);
    padding: 10px;
}
.oofooCard {
    background-color: #FFF;
    margin-bottom: 10px;
    -webkit-box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
    box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
}
.oofooCardTitle {
    padding: 5px;
    margin: 0;
    background-color: <?php echo $secondaryColor; ?>;
    color: <?php echo $primaryColor; ?>;
}
.oofooCardBody {
    padding: 10px;
}
.list-group-item {
    border-radius: 0 !important;
    border-right: 0 !important;
    border-left: 0 !important;
}
.alertBadge {
    float: right;
    background-color: #F44336;
    padding: 0 5px;
    color: #FFF;
    border-radius: 3px;
}
.shadow {
    -webkit-box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
    box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
}
.profileInventoryImg {
    width: 100%;
    object-fit: contain;
}
.profileInventoryQuantity {
    position: absolute;
    top: 0;
    right: 0;
    width: 1.5em;
    height: 1.5em;
    line-height: 1.5em;
    background-color: #FF0000;
    color: #FFF;
    background-color: #FF0000;
    border-radius: 50%;
}
footer {
    background-color: <?php echo $secondaryColor; ?>;
    color: #FFF;
}
.inputError {
    border-color: #c9302c;
}
.bankIcon {
    display: inline-block;
    position: relative;
    width: 60px;
    height: 60px;
}
.adminBankIcon {
    height: 30px;
}
.inventoryItem {
    position: relative;
}
.inventoryQuantity {
    position: absolute;
    top: 0;
    right: 0;
    background-color: #7ed897;
    color: #fffdeb;
    font-weight: bold;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 20px;
    border-radius: 50%;
}
.pastCell {
    background-color: #eee;
}
.todayCell {
    background-color: #ddd;
}
#editNameForm {
    display: none;
}
.pointSection {
    display: none;
}
.rightFormButton {
    display: flex;
    flex-direction: column;
    margin-top: auto;
    margin-bottom: 15px;
    margin-left: 10px;
}
.websitestylecell {
    cursor: pointer;
    width: 50px;
    height: 50px;
    display: inline-block;
    margin: 5px;
    border-bottom: 10px solid;
}
.oofooPopup {
    display: none;
    position: absolute;
    border: 1px solid #000;
    padding: 5px;
}
.farmingPlot {
    display: inline-block;
    width: 50px;
    height: 50px;
}
.itemdatabase>p, .itemdatabase>h3 {
    margin: 0;
}
.itemdatabase_type {
    font-size: 12px;
    color: #a4a4a4;
}
.itemdatabase_artist {
    font-size: 10px;
    color: #a4a4a4;
}
.plantable {
    border: 4px solid #F00 !important;
}

<?php
CloseCon($conn);
?>
