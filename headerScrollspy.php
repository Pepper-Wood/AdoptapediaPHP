<?php
require('util/User.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Adoptapedia</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="assets/images/gt_favicon.png">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/hover.css">
	<link rel="stylesheet" href="assets/css/scrollspy.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans" >
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body data-spy="scroll" data-target="#myScrollspy" data-offset="15">

<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<a class="navbar-brand" href="index.php">Adoptapedia</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li class='dropdown'>
					<a href='#' class='dropdown-toggle' data-toggle='dropdown'>About <span class='caret'></span></a>
					<ul class='dropdown-menu'>
						<li><a href='aboutAdoptables.php'>What are Adoptables?</a></li>
						<li><a href='aboutAdoptapedia.php'>What is Adoptapedia?</a></li>
					</ul>
				</li>
				<li><a href="groupdirectory.php">DeviantArt Group Directory</a></li>
				<li><a href="generator.php">Adoptable Ideas Generator</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php
					if (!isset($_SESSION['user'])) {
						echo "<li><a href='login.php' class='loginlogout'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
					}
					else {
						echo "
						<li class='dropdown'>
							<a href='#' class='dropdown-toggle' data-toggle='dropdown'><span class='glyphicon glyphicon-plus'></span> Submit <span class='caret'></span></a>
							<ul class='dropdown-menu'>
								<li><a href='submit.php'>New DeviantArt Group</a></li>
								<li><a href='test.php'>New Original Species</a></li>
							</ul>
						</li>";
						if ($_SESSION['user']->getType() == 'admin') {
							echo "<li><a href='approve.php'><span class='glyphicon glyphicon-pencil'></span> Review Groups</a></li>";
						}
						echo "<li><a href='profile.php'><span class='glyphicon glyphicon-user'></span> ".$_SESSION['user']->getUsername()."</a></li>
						<li class='loginlogout'><a href='logout.php'><span class='glyphicon glyphicon-log-in'></span> Logout</a></li>";
					}
				?>
			</ul>
		</div>
	</div>
</nav>

<?php
if ($_GET['status'] == "login" && isset($_SESSION['user'])) {
    echo "<div class='divide-nav-login'><div class='container'><p class='divide-text'>You are logged in as ".$_SESSION['user']->getUsername().".</p></div></div>";
}

if ($_GET['status'] == "logout" && !isset($_SESSION['user'])) {
    echo "<div class='divide-nav-login'><div class='container'><p class='divide-text'>You have successfully logged out!</p></div></div>";
}
?>