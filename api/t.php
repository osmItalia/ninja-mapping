<?php
include_once('../conf.php');
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

    $dbh = new PDO('sqlite:../'.$dbFile) or die("Error opening DB");

    if ( $nota=='..new..') {
            // copia tutti i record dell'utente nella tabella history

            //controllo se history e' vuota
            $sql = "SELECT COUNT(*) FROM history";
            //$rows = $dbh->querySingle($sql);
            $res= $dbh->query($sql);
            $rows= $res->fetchColumn();

            if ($rows > 0) {
                    //cerco il numero di track da inserire nel campo track_no
                    $sql = "SELECT MAX(track_id) FROM history";
                    //$track_no = $dbh->querySingle($sql);
                    $res= $dbh->query($sql);
                    $track_no= $res->fetchColumn();
            }
            else {
                    $track_no=0;
                }

            $track_no++;
            $sql = "INSERT INTO history SELECT $track_no,* FROM track WHERE user_id='$uid'";
            $dbh->exec($sql);

            $sql = "DELETE FROM track WHERE user_id='$uid'";
            $dbh->exec($sql);
    }
    else{
        $sql = "INSERT INTO track ('user_id','event_id','lat', 'lon', 'timestamp','altitude', 'speed','direction', 'accuracy','note') VALUES ('$uid','$eid',$lat,$lon,'$ts',$alt,$speed,$dir,$hdop,'$nota')";

        $dbh->exec($sql);
    }
}
?>
