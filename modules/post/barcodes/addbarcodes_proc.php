<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Barcodes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/greenhouses/Greenhouses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11235";//Edit
}
else{
	$auth->roleid="11235";//Add
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
	$barcodes=new Barcodes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$barcodes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$barcodes=$barcodes->setObject($obj);
		if($barcodes->add($barcodes)){
			$error=SUCCESS;
			redirect("addbarcodes_proc.php?id=".$barcodes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$barcodes=new Barcodes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$barcodes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$barcodes=$barcodes->setObject($obj);
		if($barcodes->edit($barcodes)){
			$error=UPDATESUCCESS;
			redirect("addbarcodes_proc.php?id=".$barcodes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$greenhouses= new Greenhouses();
	$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$barcodes=new Barcodes();
	$where=" where id=$id ";
	$fields="post_barcodes.id, post_barcodes.barcode, post_barcodes.greenhouseid, post_barcodes.itemid, post_barcodes.status, post_barcodes.generatedon, post_barcodes.remarks, post_barcodes.ipaddress, post_barcodes.createdby, post_barcodes.createdon, post_barcodes.lasteditedby, post_barcodes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$barcodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$barcodes->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='post_barcodes' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addbarcodes.php";
?>