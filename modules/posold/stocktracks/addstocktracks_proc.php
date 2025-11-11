<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktracks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="3761";//Edit
}
else{
	$auth->roleid="3759";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$stocktracks=new Stocktracks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$stocktracks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stocktracks=$stocktracks->setObject($obj);
		if($stocktracks->add($stocktracks)){
			$error=SUCCESS;
			redirect("addstocktracks_proc.php?id=".$stocktracks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$stocktracks=new Stocktracks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$stocktracks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stocktracks=$stocktracks->setObject($obj);
		if($stocktracks->edit($stocktracks)){
			$error=UPDATESUCCESS;
			redirect("addstocktracks_proc.php?id=".$stocktracks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.costprice, pos_items.tradeprice, pos_items.retailprice, pos_items.discount, pos_items.tax, pos_items.stock, pos_items.reorderlevel, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$stocktracks=new Stocktracks();
	$where=" where id=$id ";
	$fields="pos_stocktracks.id, pos_stocktracks.itemid, pos_stocktracks.tid, pos_stocktracks.documentno, pos_stocktracks.batchno, pos_stocktracks.quantity, pos_stocktracks.costprice, pos_stocktracks.value, pos_stocktracks.discount, pos_stocktracks.tradeprice, pos_stocktracks.retailprice, pos_stocktracks.tax, pos_stocktracks.expirydate, pos_stocktracks.recorddate, pos_stocktracks.status, pos_stocktracks.remain, pos_stocktracks.transaction, pos_stocktracks.createdby, pos_stocktracks.createdon, pos_stocktracks.lasteditedby, pos_stocktracks.lasteditedon, pos_stocktracks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$stocktracks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$stocktracks->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->status="1";
	$obj->lasteditedon="0000-00-00 00:00:00";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Stocktracks ";
include "addstocktracks.php";
?>