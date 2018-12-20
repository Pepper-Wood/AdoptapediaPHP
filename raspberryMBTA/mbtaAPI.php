<?php
/*
class Vehicle {
    public $currentStatus;
    public $stopID;
    public $stopName;

    function printVehicle() {
        echo $currentStatus." ".$stopName." (".$stopID.")\r\n\r\n";
    }
    function updateVehicle($newCurrentStatus, $newStopID) {
        if ($this->currentStatus != $newCurrentStatus) {
            $this->currentStatus = $newCurrentStatus;
            if ($this->stopID != $newStopID) {
                $file = file_get_contents('https://api-v3.mbta.com/stops/'.$newStopID, false, $context);
                $json = json_decode($file);
                $this->stopID = $newStopID;
                $this->stopName = $json->{'data'}->{'attributes'}->{'name'};
            }
            $this->printVehicle();
        }
    }
}
*/

$opts = array(
    'http'=>array(
        'method'=>"GET",
        'header'=>  "Content-Type: application/json\r\n" .
                    "key: eabb204ea25842c293215af0ac85bf51\r\n"
    )
);
$context = stream_context_create($opts);
$currentVehicle = "O-5455A0F8";
$file = file_get_contents('https://api-v3.mbta.com/vehicles/'.$currentVehicle, false, $context);
$json = json_decode($file);

$currentStatus = $json->{'data'}->{'attributes'}->{'current_status'};
$stopID = $json->{'data'}->{'relationships'}->{'stop'}->{'data'}->{'id'};
//$file = file_get_contents('https://api-v3.mbta.com/stops/'.$stopID, false, $context);
//$json = json_decode($file);
//$stopName = $json->{'data'}->{'attributes'}->{'name'};

date_default_timezone_set('US/Eastern');
//echo date("h:i:sa")."?".$currentStatus."?".$stopID."?".$stopName;
echo date("h:i:sa")."?".$currentStatus."?".$stopID;

//$orangeBuddy = new Vehicle;

//while (true) {
//$file = file_get_contents('https://api-v3.mbta.com/vehicles/'.$currentVehicle, false, $context);
//$json = json_decode($file);
//$orangeBuddy->updateVehicle($json->{'data'}->{'attributes'}->{'current_status'},$json->{'data'}->{'relationships'}->{'stop'}->{'data'}->{'id'});
//sleep(5);
//}
?>
