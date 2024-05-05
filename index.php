<?php
//By Shunxian Wu
//orchid.x@outlook.com

ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

//subscription infomation
$key = ''; //Default subscription key
$region = ''; //Default subscription region
//require('./subscription.php'); //this file can define $key and $region

//set param
if (isset($_GET['type'])) $data_type = $_GET['type'];
else $data_type = 'xml';
if (isset($_GET['key'])) $key = $_GET['key'];
if (isset($_GET['region'])) $region = $_GET['region'];
if (empty($key) || empty($region)) {
	echo 'Error: Subscription error';
	exit();
}

//get post data
$raw_data = file_get_contents('php://input');
if (empty($raw_data)) {
	echo "Error: Empty data";
	exit();
}

require('./xml.php');

//convert data
switch ($data_type) {
	case 'json':
		$data = build_mstts_xml(json_decode($raw_data,true));
		if (empty($data)) {
			echo 'Error: JSON Data Error';
			exit();
		}
		break;
	case 'xml':
		$data = $raw_data;
		break;
	default:
		echo "Error: Unknown data type";
		exit();
}

require('./tts.php');

$return_xml = true;
$dt = get_audio($region,get_token($region,$key),$data, function ($c,$d) {
	global $return_xml;
	echo $d;
	$return_xml = false;
	return strlen($d);
});

if ($return_xml) echo $data;

?>