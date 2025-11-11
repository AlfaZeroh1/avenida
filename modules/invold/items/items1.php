<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

$db = new DB();

$query="select * from pos_items";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  if(mysql_query("update pos_items set stock=(select sum(quantity) from pos_itemstocks where itemid=pos_items.id) where id='$row->id'"))
    echo "Product: Update $row->name\n";
}

$query="select * from prod_varietys";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  if(mysql_query("update prod_varietys set stock=(select sum(quantity) from prod_varietystocks where itemid=prod_varietys.id) where id='$row->id'"))
    echo "Variety: Update $row->name\n";
}
?>
