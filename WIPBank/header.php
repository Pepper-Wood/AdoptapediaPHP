<?php
require('../util/User.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sushi Dogs Bank</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="img/favicon.gif">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container shadow" style="padding:0">
<img src="http://intranet.chsfl.org/CHSI/media/-intranet-images/Header-BeWise-PiggyBank.png" style="width:100%">
<nav class="navbar navbar-default">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="index.php">Sushi Dogs</a>
	</div>
	<div id="navbar" class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
			<li><a href='itemdatabase.php'>All Items</a><li>
			<li><a href='bank.php'>Bank</a><li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<?php
			if (!isset($_SESSION['user'])) {
				echo "<li><a href='login.php'>Login</a><li>";
			} else {
				if (($_SESSION['user']->getType() == 'admin') || ($_SESSION['user']->getType() == 'superadmin')) {
					echo "<li><a href='admin.php'>ADMIN</a></li>";
					echo "<li><a href='tradeTransactions.php'>TRADE TRANSACTIONS</a></li>";
				}
				echo "<li><a href='inventory.php?username=".$_SESSION['user']->getUsername()."'>Your Inventory</a></li>";
				echo "<li><a href='logout.php'>Log Out</a></li>";
			}
			?>
		</ul>
	</div>
</nav>
