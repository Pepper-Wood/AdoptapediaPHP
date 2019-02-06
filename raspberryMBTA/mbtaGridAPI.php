<?php
$opts = array(
    'http'=>array(
        'method'=>"GET",
        'header'=>  "Content-Type: application/json\r\n" .
                    "key: eabb204ea25842c293215af0ac85bf51\r\n"
    )
);
$context = stream_context_create($opts);
$currentVehicle = "5454433B";
$file = file_get_contents('https://api-v3.mbta.com/vehicles/'.$currentVehicle, false, $context);
$json = json_decode($file);

$currentStatus = $json->{'data'}->{'attributes'}->{'current_status'};
$trainX = $json->{'data'}->{'attributes'}->{'longitude'};
$trainY = $json->{'data'}->{'attributes'}->{'latitude'};

echo $currentStatus."?".$trainX."?".$trainY;
?>
