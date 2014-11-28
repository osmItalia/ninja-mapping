<?php
include_once('../conf.php');

$a=new Auth($basepath,$dbFile);
$a->forceAuthentication();
$uid=$a->getUid();

include('../lib/functions.php');

archiveTrack('../',$uid);

?>
