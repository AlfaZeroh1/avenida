<?php
session_start();
require_once "../../../DB.php";
require_once "../../../lib.php";

$db = new DB();

$obj = (object)$_GET;

$query="select * from inv_branchstocks where itemid='$obj->itemid' and brancheid='$obj->brancheid'";
$rs = mysql_query($query);
$rw = mysql_fetch_object($rs);

echo $rw->quantity;

?>