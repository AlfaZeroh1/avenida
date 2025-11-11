<?php
require_once("../../../DB.php");

$db = new DB();

$obj = (object)$_POST;

$query="update fn_generaljournals set rate='$obj->rate' where id='$obj->id'";
mysql_query($query);

?>