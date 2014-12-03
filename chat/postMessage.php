<?php
include_once('../conf.php');
$a=new Auth($basepath,$dbFile);
$a->forceAuthentication();
$dbh = new PDO('sqlite:chat_db.sqlite') or die("Error opening DB");

$message=$_GET['m'];

$q="INSERT INTO chat VALUES (".$a->getEvent().",".time().",".$a->getUid().",'".$message."')";
$dbh->exec($q);
$dbh = null;
?>
