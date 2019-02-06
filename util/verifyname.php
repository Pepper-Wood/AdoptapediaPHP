<?php
// Not a class. This script gets called by AJAX in submit.php

// DeviantArt acceptable group name format:
// 3 to 20 characters, alphanumeric or hyphens, hyphens cannot start or end the group name
include_once('../HIDDEN/DB_CONNECTIONS.php');

if (preg_match('/^[A-Za-z0-9][A-Za-z0-9-]{1,18}[A-Za-z0-9]$/', $_GET['q'])) {
    $conn = OpenMainCon();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
    $qry = "SELECT * FROM groups WHERE groupname = '".$_GET['q']."';";
    $result = $conn->query($qry);
    if (mysqli_num_rows($result) != 0) {
        echo "Group is already in the database!";
    } else {
        $qry = "SELECT * FROM requestsgroups WHERE groupname='".$_GET['q']."' AND status='pending';";
        if (mysqli_num_rows($conn->query($qry)) != 0) {
            echo "Group is already pending!";
        } else {
            // "SUCCESS" is used to differentiate the many possible error messages from the one success message
            echo "SUCCESS";
        }
    }
    CloseCon($conn);
} else {
    echo "Please enter a valid name!";
}
