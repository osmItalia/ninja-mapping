<?php
include_once '../conf.php';

if (!isset($_GET['u'])) 
	echo 'No data';

$u = $_GET['u'];

$dbh = new PDO('sqlite:../'.$dbFile) or die("Error opening DB");

$sql = 'SELECT * FROM track WHERE user_id='.$u.' ORDER BY timestamp DESC LIMIT 1';
$result=$dbh->query($sql)->fetch(PDO::FETCH_ASSOC);

$geo=array('type'=>"FeatureCollection",'features'=>array());

$coo=array($result['lon'],$result['lat']);
unset($result['lon']);
unset($result['lat']);

  $questo=array('type'=>"Feature",'properties'=>$result,'geometry'=>array('type'=>'Point','coordinates'=>$coo));
  $geo['features'][]=$questo;
echo json_encode($geo,JSON_NUMERIC_CHECK);
?>
