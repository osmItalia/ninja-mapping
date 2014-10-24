<?php
include('lib/ulogin.php');
$a=new Auth('/ninja-mapping','database.sqlite');
$a->logout();
?>