<?php
function getStoreStatuses($storeType, $url) {
    global $msg;
    $msg .= $storeType." ERRORS\r\n";
    ini_set('default_socket_timeout', 360);
    $cartjson = file_get_contents($url);
    $cartobj = json_decode($cartjson);
    $storeErrors = 0;
    foreach ($cartobj as $key => $value) {
        if ($value->{"status"} != "green") {
            $msg .= $value->{"store_name"}."\r\n".$value->{"error"}."\r\n\r\n";
            $storeErrors++;
        }
    }
    if ($storeErrors == 0) {
        $msg .= "There are no ".$storeType." errors.\r\n";
    }
    $msg .= "=================\r\n";
}

$msg = "";
getStoreStatuses('GSTORE','https://checkout.unboundcommerce.com/gcart/status.jsp?pass=twdnkumus');
getStoreStatuses('YSTORE','https://checkout.unboundcommerce.com/ycart/status.jsp?pass=twdnkumus');
$msg = wordwrap($msg,70);
echo $msg;
date_default_timezone_set('US/Eastern');
$date = date("m-d-Y");
mail("kathryn@unboundcommerce.com","Account Monitor for ".$date,$msg);
?>
