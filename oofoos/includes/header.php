<?php
require('../util/User.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oofoos</title>
    <link rel="icon" href="images/items/placeholder.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.php">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
</head>
<body>

<div class="container shadow" style="padding:0">
<a href="index.php"><img src="images/header.png" style="width:100%"></a>
<nav class="navbar navbar-default">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>
	<div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li class="<?php if (basename($_SERVER['SCRIPT_NAME']) == "index.php") { echo " active"; } ?>"><a href='index.php'>Home</a><li>
            <li class="dropdown<?php if ((basename($_SERVER['SCRIPT_NAME']) == "tos.php") || (basename($_SERVER['SCRIPT_NAME']) == "oofooDatabase.php") || (basename($_SERVER['SCRIPT_NAME']) == "gettingStarted.php")) { echo " active"; } ?>">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)"><s>General</s></a></li>
                    <li><a href="javascript:void(0)"><s>Anatomy & Traits</s></a></li>
                    <li><a href="tos.php">Terms of Service</a></li>
                    <li><a href='oofooDatabase.php'>Oofoo Database</a><li>
                    <li><a href="javascript:void(0)"><s>Getting Started</s></a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">World & Lore <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)"><s>General Society</s></a></li>
                    <li><a href="javascript:void(0)"><s>Magic</s></a></li>
                    <li><a href="javascript:void(0)"><s>Life and Death</s></a></li>
                    <li><a href="javascript:void(0)"><s>Relationships</s></a></li>
                    <li><a href="javascript:void(0)"><s>Currency</s></a></li>
                </ul>
            </li>
            <li class="dropdown<?php if ((basename($_SERVER['SCRIPT_NAME']) == "bank.php") || (basename($_SERVER['SCRIPT_NAME']) == "itemDatabase.php")) { echo " active"; } ?>">
                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gameplay <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href='trials.php'>Trials</a><li>
                    <li class="dropdown-divider"><li>
                    <li><a href='itemDatabase.php'>All Items</a><li>
                    <li><a href='bank.php'>Bank</a><li>
                </ul>
            </li>
            <li class="<?php if (basename($_SERVER['SCRIPT_NAME']) == "calendar.php") { echo " active"; } ?>"><a href='calendar.php'>Calendar</a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<?php
			if (!isset($_SESSION['user'])) {
				echo "<li><a href='login.php'>Login</a><li>";
			} else {
                echo '<li class="dropdown';
                if ((basename($_SERVER['SCRIPT_NAME']) == "admin.php") || (basename($_SERVER['SCRIPT_NAME']) == "account.php") || (basename($_SERVER['SCRIPT_NAME']) == "settings.php")) { echo " active"; }
                echo '">';
                echo '    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$_SESSION['user']->getUsername().' <span class="caret"></span></a>';
                echo '    <ul class="dropdown-menu">';
                if ($_SESSION['user']->getType() == 'admin') {
                    echo '        <li><a href="admin.php">ADMIN</a></li>';
                }
                echo '        <li><a href="account.php">Profile</a></li>';
                echo '        <li><a href="settings.php">Settings</a></li>';
                echo '        <li><a href="logout.php">Log Out</a></li>';
                echo '    </ul>';
                echo '</li>';
			}
			?>
		</ul>
	</div>
</nav>
