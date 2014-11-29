<?php
include('header.php');
$userid = $a->getUid();
$dbh = new PDO('sqlite:'.$dbFile) or die("Error opening DB");
$sql = "SELECT track_id, COUNT(NULLIF(note,'')) AS notes, COUNT(*) AS points FROM history WHERE user_id=$userid GROUP BY track_id";
$res= $dbh->query($sql);
$rows= $res->fetchAll();
?>
<div class="row">
    <div class="col-md-12">
        <h1>My tracks</h1>
<table class="table table-condensed table-hover table-bordered">
<tr><th>Track ID</th><th>Notes</th><th>Total points</th><th>Download</th></tr>
<?php
foreach($rows as $row){
    echo "<tr><td>".$row['track_id']."</td><td>".$row['notes']."</td><td>".$row['points']."</td><td><a href='api/getGPX.php?t=".$row['track_id']."'>GPX</a></td></tr>";
}
?>
</table>
    </div>
</div>
<?php include('footer.php');?>
