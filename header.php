<?php
require('util/User.php');
session_start();
?>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Adoptapedia | Assisting the Adopt Community Since 2013</title>
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" media="screen,projection"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/slick.min.js"></script>
</head>
<body>
	<div id="menu">
		<ul>
			<li><a href="groupdirectory.php">Adopt Group Directory</a></li>
			<li><a href="generator.php">Inspiration Center</a></li>
            <li><a href="speciestrades.php">Species Trading Center</a></li>
			<li><a href="about.php">About & FAQ</a></li>
			<?php
				if (!isset($_SESSION['user'])) {
					echo "<li><a href='login.php'>Login</a></li>";
				}
				else {
					echo "
					<li><a href='javascript:void(0)'><div class='horizontalFlex'>
							<div>Hi <b>".$_SESSION['user']->getUsername()."</b>! <span class='adminAlertNum'>1</span></div>
							<div class='verticalCenterFlex'><i class='fas fa-angle-down'></i></div>
						</div></a>
							<ul class='submenu'>
								<li><a href='profile.php'>Profile</a></li>";
					if ($_SESSION['user']->getType() == 'admin') {
						echo "<li><a href='approve.php' class='adminAlert'>Admin Area <span class='adminAlertNum'>1</span></a></li>";
					}
					echo "
								<li><a href='logout.php'>Log Out</a></li>
							</ul>
					</li>";
				}
			?>

		</ul>
	</div>
	<div id="right">
		<div id="navigation" class="container-fluid horizontalFlex shadow flexHideOnMobile">
			<ul class="horizontalList">
				<li><a href="groupdirectory.php">Adopt Group Directory</a></li>
				<li><a href="generator.php">Inspiration Center</a></li>
                <li><a href="speciestrades.php">Species Trading Center</a></li>
				<li><a href="about.php">About & FAQ</a></li>
			</ul>
			<ul class="horizontalList">
				<?php
					if (!isset($_SESSION['user'])) {
						echo "<li><a href='login.php' class='loginlogout'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
					}
					else {
						echo "
						<li class='dropdown'>Hi <b>".$_SESSION['user']->getUsername()."</b>!  <span class='adminAlertNum'>1</span> <i class='fas fa-angle-down'></i>
							<div class='dropdown-content'>
								<a href='#'>Profile</a>";
						if ($_SESSION['user']->getType() == 'admin') {
							echo "<a href='approve.php' class='adminAlert'>Admin Area <span class='adminAlertNum'>1</span></a>";
						}
						echo "
								<a href='logout.php'>Log Out</a>
							</div>
						</li>";
					}
				?>
			</ul>
		</div>
		<div id="directorySearch">
			<div class="container horizontalFlex flexCenter">
				<div id="leftMenuTrigger" class="showOnMobile"><i class="fas fa-bars"></i></div>
				<div class="logo">
					<a href="index.php"><img src="assets/img/logo.png" style="height:60px"></a>
				</div>
				<div class="horizontalFlex flexGrow flexHideOnMobile">
					<input id="headerSearch" class="form-control form-inline flexGrow noRightBorderRadius" type="text" placeholder="Search for adopt groups..." aria-label="Search">
					<button class="btn btn-primary noLeftBorderRadius">Search</button>
				</div>
			</div>
		</div>
		<div id="directoryCategories">
			<div class="container horizontalFlex">
				<a href="javascript:void(0)">High-Quality Adopts</a>
				<a href="javascript:void(0)">Canine Adopts</a>
				<a href="javascript:void(0)">Feline Adopts</a>
				<a href="javascript:void(0)">Humanoid Adopts</a>
				<a href="javascript:void(0)">Contests</a>
				<a href="javascript:void(0)">ARPGs</a>
				<a href="javascript:void(0)">Closed Species</a>
				<a href="javascript:void(0)">Open Species</a>
			</div>
		</div>

<script>
$('#menu li:has("ul")').children('ul').hide();
$('#leftMenuTrigger').click(function() {
if ($('#right').css("left") == "0px") {
	$('#right').animate({left: 200});
} else {
	$('#right').animate({left: 0});
}
});
$('#menu li:has("ul")').click(function(){
$(this).children('ul').slideToggle();
});
</script>
