<?php
include_once('../conf.php');
$a=new Auth($basepath,$dbFile);
$a->forceAuthentication();
$dbh = new PDO('sqlite:chat_db.sqlite') or die("Error opening DB");

$eid=$_GET['e'];
$ts=$_GET['ts'];
$q="SELECT * FROM chat WHERE eventid=$eid AND timestamp < $ts";

$results=$dbh->query($q);
$results=$results->fetchAll();
echo json_encode($results);
?>
