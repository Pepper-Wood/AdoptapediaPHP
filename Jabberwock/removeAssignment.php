<?php
require('../util/User.php');
session_start();
$conn = new mysqli("localhost", "adoptape", "u7w58d3294s", "adoptape_jabberwockdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM assignments WHERE ownerid=".$_SESSION['user']->getID()." AND recipeid=".$_POST['removeAssignmentID']." LIMIT 1;";
$result = mysqli_query($conn, $sql);

?>
