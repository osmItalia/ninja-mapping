<?php
function archiveTrack($path,$uid){
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
    $sql = "INSERT INTO history SELECT $track_no,* FROM track WHERE user_id='$uid'";
    $dbh->exec($sql);

    $sql = "DELETE FROM track WHERE user_id='$uid'";
    $dbh->exec($sql);
}
?>
