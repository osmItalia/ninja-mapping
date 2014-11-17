<?php
include_once '../conf.php';

$a=new Auth($basepath,$dbFile);
$a->forceAuthentication();

if (!isset($_GET['u'])) {
	echo 'No data';
	die();
	}

$u = $_GET['u'];

$dbh = new PDO('sqlite:../'.$dbFile) or die("Error opening DB");

$sql = 'SELECT * FROM track WHERE user_id='.$u.' ORDER BY timestamp DESC';
$qresult=$dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$geo=array('type'=>"FeatureCollection",'features'=>array());

foreach($qresult as $result){

$coo=array($result['lon'],$result['lat']);
unset($result['lon']);
unset($result['lat']);
$track[]=$coo;

  $a_point=array('type'=>"Feature",'properties'=>$result,'geometry'=>array('type'=>'Point','coordinates'=>$coo));
  $geo['features'][]=$a_point;
}
$a_track=array('type'=>"Feature",'properties'=>NULL,'geometry'=>array('type'=>'LineString','coordinates'=>$track));
$geo['features'][]=$a_track;
echo json_encode($geo,JSON_NUMERIC_CHECK);
?>
