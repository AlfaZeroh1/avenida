<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

$ob = (object)$_GET;
$ob->brancheid=$_SESSION['brancheid'];

//get stock levels
$query="select quantity from inv_branchstocks where itemid='$ob->itemid' and brancheid='$ob->brancheid'";
$row=mysql_fetch_object(mysql_query($query));

//get reorders
$query="select * from inv_reorderlevels where itemid='$ob->itemid' and brancheid='$ob->brancheid'";
$rw=mysql_fetch_object(mysql_query($query));

echo $row->cnt."|".$rw->reorderlevel."|".$rw->maxreorderlevel;
?>
