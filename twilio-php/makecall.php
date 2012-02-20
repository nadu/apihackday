<?php
require "Services/Twilio.php";

/* Set our AccountSid and AuthToken */
$AccountSid = 'ACc59c478180144c19b6029ec595f0719f';
$AuthToken = '2273acfc6ba1c74c14e7e43d3eebe971';
$APP_SID = 'AP2b37a570129042129404c14db4cedba0';


/* Your Twilio Number or an Outgoing Caller ID you have previously validated
	with Twilio */
$from= '2159872011'; 
/* Number you wish to call */
$to= '4048243444'; // the mentor
$mentee_number = '2154997415';//$_REQUEST['called'];
$mentee_name = "Jeff";  

/* Directory location for callback.php file (for use in REST URL)*/
$url = 'http://www.naduism.com/apihackday/twilio-php/';

/* Instantiate a new Twilio Rest Client */
$client = new Services_Twilio($AccountSid, $AuthToken);
/*
if (!isset($_REQUEST['called'])) {
    $err = urlencode("Must specify your phone number");
    header("Location: index.php?msg=$err");
    die;
}
*/
/* make Twilio REST request to initiate outgoing call */
$call = $client->account->calls->create($from, $to, $url . 'callback.php?name=' . $mentee_name .'&number='.$mentee_number);

/* redirect back to the main page with CallSid */
$msg = urlencode("Connecting... ".$call->sid);
header("Location: index.php?msg=$msg");
?>
