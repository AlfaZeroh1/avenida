<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktrack_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="729";//Edit
}
else{
	$auth->roleid="727";//Add
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
	$stocktrack=new Stocktrack();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$stocktrack->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stocktrack=$stocktrack->setObject($obj);
		if($stocktrack->add($stocktrack)){
			$error=SUCCESS;
			redirect("addstocktrack_proc.php?id=".$stocktrack->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$stocktrack=new Stocktrack();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$stocktrack->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$stocktrack=$stocktrack->setObject($obj);
		if($stocktrack->edit($stocktrack)){
			$error=UPDATESUCCESS;
			redirect("addstocktrack_proc.php?id=".$stocktrack->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$stocktrack=new Stocktrack();
	$where=" where id=$id ";
	$fields="inv_stocktrack.id, inv_stocktrack.itemid, inv_stocktrack.tid, inv_stocktrack.documentno, inv_stocktrack.batchno, inv_stocktrack.quantity, inv_stocktrack.costprice, inv_stocktrack.value, inv_stocktrack.discount, inv_stocktrack.tradeprice, inv_stocktrack.retailprice, inv_stocktrack.applicabletax, inv_stocktrack.expirydate, inv_stocktrack.recorddate, inv_stocktrack.status, inv_stocktrack.remain, inv_stocktrack.transaction, inv_stocktrack.createdby, inv_stocktrack.createdon, inv_stocktrack.lasteditedby, inv_stocktrack.lasteditedon, inv_stocktrack.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$stocktrack->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$stocktrack->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->expirydate="0000-00-00";
	$obj->recorddate="0000-00-00";
	$obj->status="1";
	$obj->lasteditedon="0000-00-00 00:00:00";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Stocktrack ";
include "addstocktrack.php";
?>