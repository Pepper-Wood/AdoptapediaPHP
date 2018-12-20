<?php
include_once('header.php');

echo "<p>About Us page coming soon!</p>";

if (isset($_SESSION['user'])) {
    echo "<p>Welcome to Adoptapedia, ".$_SESSION['user']->getUsername()."!</p>";
}

include_once('footer.php');