<?php
include_once '../conf.php';

$a=new Auth($basepath,$dbFile);
$a->forceAuthentication();

if (!isset($_GET['t'])) {
	echo 'No data';
	die();
	}

$t = $_GET['t'];

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=track.gpx");
header("Pragma: no-cache");
header("Expires: 0");

echo track2GPX("",$t);
?>
