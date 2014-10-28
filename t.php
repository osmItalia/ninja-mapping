<?php

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

$file='database.sqlite';

$dbh = new SQLite3($file);

$nota_quoted = SQLite3::escapeString($nota);

$sql = "insert into track ('user_id','event_id','lat', 'lon', 'timestamp','altitude', 'speed','direction', 'accuracy','note') values ('$uid','$eid',$lat,$lon,'$ts',$alt,$speed,$dir,$hdop,'$nota_quoted')";

$dbh->exec($sql);

if ( $nota=='..new..') {
        // copia tutti i record dell'utente nella tabella history

        //controllo se history e' vuota
        $sql = "select count(*) from history";
        $rows = $dbh->querySingle($sql);
        if ($rows > 0) {
                //cerco il numero di track da inserire nel campo track_no
                $sql = "select max(track_id) from history";
                $track_no = $dbh->querySingle($sql);
                }
        else{
                $track_no=0;
                }

        $track_no++;
        $sql = "insert into history select $track_no,* from track where user_id='$uid'";
        $dbh->exec($sql);

        $sql = "delete from track where user_id='$uid'";
        $dbh->exec($sql);
        }

$dbh->close();

}
?>
