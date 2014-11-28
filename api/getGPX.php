<?php
include_once '../conf.php';

$a=new Auth($basepath,$dbFile);
$a->forceAuthentication();

if (!isset($_GET['t'])) {
	echo 'No data';
	die();
	}

$t = $_GET['t'];

$dbh = new PDO('sqlite:../'.$dbFile) or die("Error opening DB");

$sql = 'SELECT * FROM history WHERE track_id='.$t.' ORDER BY timestamp ASC';
$qresult=$dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

header("Content-type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=trace.gpx"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 


echo('<?xml version="1.0" encoding="UTF-8"?>
<gpx creator="PHPgpx" xmlns="http://www.topografix.com/GPX/1/1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.topografix.com/GPX/1/1 http://www.topografix.com/GPX/1/1/gpx.xsd">'."\n");
echo(' <metadata><name>Trace '.$t.'</name>
        <desc></desc>
        <author><name></name></author></metadata>   <trk><trkseg><name>Live Track</name> 
');
        
foreach ($qresult as $row) {?>  
  <trkpt lat="<?php echo $row['lat']; ?>" lon="<?php echo $row['lon']; ?>"> 
      <time><?php echo $row['timestamp']; ?></time> 
      <ele><?php echo $row['altitude']; ?></ele>
      <speed><?php echo $row['speed']; ?></speed>
  </trkpt> 
    <?php }

$dbh->close();
?>
  </trkseg></trk>
</gpx> 
