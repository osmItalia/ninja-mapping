<?php
include('lib/ulogin.php');

$a=new Auth('/','database.sqlite');
echo $a->getUsernameById(3);
?>