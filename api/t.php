<?php
include_once('../conf.php');

$a=new Auth($basepath,$dbFile);
$a->forceAuthentication();

if (isset($_GET['lat']))
{
    $uid=$_GET['uid'];
    $eid=$_GET['eid'];
    $lat=$_GET['lat'];
    $lon=$_GET['lon'];
    $ts=$_GET['ts'];
    $hdop=round($_GET['prec']);
    $speed=round($_GET['sp']);
    $alt=round($_GET['alt']);
    $dir=round($_GET['dir']);
    $nota=substr($_GET['note'],0,255);

    $dbh = new PDO('sqlite:'.$dbFile) or die("Error opening DB");

    if ( $nota=='..new..') {
            // copia tutti i record dell'utente nella tabella history
            archiveTrack('',$uid,$eid);
    }
    else{
        $sql = "INSERT INTO track ('user_id','event_id','lat', 'lon', 'timestamp','altitude', 'speed','direction', 'accuracy','note') VALUES ('$uid','$eid',$lat,$lon,'$ts',$alt,$speed,$dir,$hdop,'$nota')";
        $dbh->exec($sql);
    }
}
?>
