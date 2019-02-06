<?php
include_once('header.php');

if (!isset($_SESSION['user'])) {
    include_once('index_loggedout.php');
} else {
    include_once('index_loggedin.php');
}

include_once('footer.php');
?>
