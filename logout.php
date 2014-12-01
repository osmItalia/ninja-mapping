<?php
//thisi is the logout page
$NOLOGIN=1;

include_once('conf.php');
$a=new Auth($basepath,$dbFile);
$a->logout();

include('header.php'); 
?>

<h3>Logged out</h3>

<?php
include('footer.php');
?>
