<?php
$configs = include('adminconfig.php');

$configs[$_POST['adminkey']] = $_POST['adminvalue'];

$newJsonString = json_encode($configs);
file_put_contents('adminconfig.json', $newJsonString);
?>
