<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

$db = new DB();

$obj = (object)$_POST;

$query="update pos_orderdetails set voids='$obj->voids' where id='$obj->id'";//echo $query;
mysql_query($query);

?>
