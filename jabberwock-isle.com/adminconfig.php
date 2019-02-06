<?php
$jsonString = file_get_contents('adminconfig.json');
$configs = json_decode($jsonString, true);
return $configs;
?>
