<?php
include_once '../conf.php';

$a=new Auth($basepath,$dbFile);
$a->forceAuthentication();

if (!isset($_GET['e'])) {
	echo 'No data';
	die();
	}

$e = $_GET['e'];

$dbh = new PDO('sqlite:'.$dbFile) or die("Error opening DB");

$sql = 'SELECT  t.user_id,lat,lon,t.timestamp,altitude,speed,direction,accuracy,note FROM track AS t INNER JOIN (SELECT user_id, MAX(timestamp) AS timestamp FROM track GROUP BY user_id) AS q ON t.user_id=q.user_id AND t.timestamp=q.timestamp WHERE t.event_id ='.$e;

$qresult=$dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$geo=array('type'=>"FeatureCollection",'features'=>array());

foreach($qresult as $result)
{
$coo=array($result['lon'],$result['lat']);

  $questo=array('type'=>"Feature",'properties'=>$result,'geometry'=>array('type'=>'Point','coordinates'=>$coo));
  $geo['features'][]=$questo;
}
echo json_encode($geo,JSON_NUMERIC_CHECK);
?>
