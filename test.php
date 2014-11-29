<?php
include('conf.php');

$a=new Auth('/','database.sqlite');
//echo $a->getUsernameById(3);

$dbh = new PDO('sqlite:'.$dbFile) or die("Error opening DB");

//$sql = "INSERT INTO track ('user_id','event_id','lat', 'lon', 'timestamp','altitude', 'speed','direction', 'accuracy','note') VALUES ('2','2',40.40,8.8,'404040440',1.1,3.3,60,12,'manuale')";

$sql="INSERT INTO USER VALUES (1,'pippo','2345')";
var_dump($dbh->query($sql));
?>
