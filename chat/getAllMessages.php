<?php
include_once('../conf.php');
$a=new Auth($basepath,$dbFile);
$a->forceAuthentication();
$dbh = new PDO('sqlite:chat_db.sqlite') or die("Error opening DB");

$q="SELECT * FROM chat WHERE event_id=".$a->getEvent();
$results=$dbh->query($q);
$results=$results->fetchAll();
echo json_encode($results);
$dbh = null;
?>
