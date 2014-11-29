<?php
function archiveTrack($path,$uid,$evt){
    global $dbFile;
    $dbh = new PDO('sqlite:'.$path.$dbFile) or die("Error opening DB");

    $sql = "SELECT COUNT(*) FROM history";
    $res= $dbh->query($sql);
    $rows= $res->fetchColumn();

    if ($rows > 0)
    {
        //cerco il numero di track da inserire nel campo track_no
        $sql = "SELECT MAX(track_id) FROM history";
        $res= $dbh->query($sql);
        $track_no= $res->fetchColumn();
    }
    else {
        $track_no=0;
    }

    $track_no++;
    $sql = "INSERT INTO history SELECT $track_no,* FROM track WHERE user_id=$uid AND event_id=$evt";

    $sql = "DELETE FROM track WHERE user_id=$uid";
}

function track2GPX($path,$t){
    global $dbFile;
    $dbh = new PDO('sqlite:'.$path.$dbFile) or die("Error opening DB");

    $sql = 'SELECT * FROM history WHERE track_id='.$t.' ORDER BY timestamp ASC';
    $qresult=$dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    $track='<?xml version="1.0" encoding="UTF-8"?>
    <gpx creator="PHPgpx" xmlns="http://www.topografix.com/GPX/1/1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd"> <metadata><name>Trace '.$t.'</name>
    <desc></desc> <author><name></name></author></metadata>   <trk><trkseg><name>Live Track</name>';
$wpts="";
    foreach ($qresult as $row) {
        $track.='<trkpt lat="'.$row['lat'].'" lon="'.$row['lon'].'">';
        $track.='<time>'.$row['timestamp'].'</time>';
        $track.='<ele>'.$row['altitude'].'</ele>';
        $track.='<speed>'.$row['speed'].'</speed>';
        $track.='<name>'.$row['note'].'</name>';
        $track.='</trkpt>';
        if($row['note']!=""){
            $wpts.='<wpt lat="'.$row['lat'].'" lon="'.$row['lon'].'">';
            $wpts.='<time>'.$row['timestamp'].'</time>';
            $wpts.='<ele>'.$row['altitude'].'</ele>';
            $wpts.='<speed>'.$row['speed'].'</speed>';
            $wpts.='<name>'.$row['note'].'</name>';
            $wpts.='</wpt>';
        }
        }
    $track.="</trkseg></trk>";
    $track.=$wpts;

    $track.="</gpx>";
return $track;
}
?>
