<?php

session_start();

if (isset($_SESSION['user'])) {
    // Clear the session
    $_SESSION = array();
    header('Location: https://jabberwock-isle.com/index.php');
}
