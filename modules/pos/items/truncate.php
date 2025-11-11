<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

mysql_query("update pos_items set stock=0");
mysql_query("update post_barcodes set status=0");
mysql_query("truncate pos_itemstocks");

?>