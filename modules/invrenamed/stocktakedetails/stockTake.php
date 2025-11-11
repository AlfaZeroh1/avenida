<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../inv/items/Items_class.php");
require_once("../../inv/stocktakedetails/Stocktakedetails_class.php");
require_once("../../inv/stocktakes/Stocktakes_class.php");
require_once("../../inv/branchstocks/Branchstocks_class.php");
require_once("../../inv/stocktrack/Stocktrack_class.php");

$db = new DB();
$obj = (object)$_POST;

$query="select * from inv_items where id='$obj->itemid'";
$rw=mysql_fetch_object(mysql_query($query));

//get stocktakes
$query="select * from inv_stocktakes where brancheid='$obj->brancheid' and openedon='$obj->takenon'";
$rs = mysql_query($query);
if(mysql_affected_rows()>0){
  $st = mysql_fetch_object($rs);
}else{
  $st = new Stocktakes();
  $st->openedon=$obj->takenon;
  $st->brancheid=$obj->brancheid;
  $st->createdby=$_SESSION['userid'];
  $st->createdon=date("Y-m-d H:i:s");
  $st->lasteditedby=$_SESSION['userid'];
  $st->lasteditedon=date("Y-m-d H:i:s");
  $st->ipaddress=$_SERVER['REMOTE_ADDR'];
  $st = $st->setObject($st);
  $st->add($st);
}

$stocktakedetails = new Stocktakedetails();
$stocktakedetails->stocktakeid=$st->id;
$stocktakedetails->itemid=$obj->itemid;
$stocktakedetails->brancheid=$obj->brancheid;
$stocktakedetails->takenon=$obj->takenon;
$stocktakedetails->quantity=$obj->quantity;
$stocktakedetails->stock=$obj->stock;
$stocktakedetails->costprice=$rw->costprice;
$stocktakedetails = $stocktakedetails->setObject($stocktakedetails);

//check if record exists already
$query="select * from inv_stocktakedetails where itemid='$obj->itemid' and brancheid='$obj->brancheid' and takenon='$obj->takenon'";
$res = mysql_query($query);
if(mysql_affected_rows()>0){
  $items = mysql_fetch_object($res);
  $stocktakedetails->id = $items->id;
  $stocktakedetails->edit($stocktakedetails);
}else{
  $stocktakedetails->add($stocktakedetails);
}



$branchstockss = new Branchstocks();
$fields="*";
$where=" where itemid='$obj->itemid' and brancheid='$obj->brancheid' ";
$join="";
$having="";
$groupby="";
$orderby="";
$branchstockss->retrieve($fields, $join, $where, $having, $groupby, $orderby);
      
$branchstocks = new Branchstocks();
$branchstocks->brancheid=$obj->brancheid;
$branchstocks->itemid=$obj->itemid;
$branchstocks->itemdetailid=$obj->itemdetailid;
$branchstocks->documentno=$obj->documentno;
$branchstocks->recorddate=$obj->takenon;
$branchstocks->quantity=$obj->quantity;
$branchstocks->quantitys=$obj->quantity;
$branchstocks->transactionid=$transaction->id;

$branchstocks->transaction="Stocktake";

if($branchstockss->affectedRows>0){
  $branchstockss = $branchstockss->fetchObject;
  $branchstockss->recorddate=$obj->takenon;
  $branchstockss->transaction="Stocktake";
  
  $branchstockss->quantity=($obj->quantity);
  $branchstockss->quantitys=($obj->quantity);
  $branchstockss->recorddate=$obj->takenon;
  $branchstocks->edit($branchstockss);
  
}else{
  $branchstocks->quantity=($obj->quantity);
  $branchstocks->add($branchstocks);
}
?>
