<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Depreciations_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/assets/Assets_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11246";//Edit
}
else{
	$auth->roleid="11244";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->assetid)){
  $obj=$ob;
  $obj->depreciatedon=date("Y-m-d");
//   $obj->month=date("m",mktime(0,0,0,date("m") ,1,date("Y")));
//   $obj->year=date("Y",mktime(0,0,0,date("m") ,1,date("Y")));
}

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
	$depreciations=new Depreciations();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$depreciations->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$depreciations=$depreciations->setObject($obj);
		if($depreciations->add($depreciations)){
			$error=SUCCESS;
// 			redirect("adddepreciations_proc.php?id=".$depreciations->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$depreciations=new Depreciations();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$depreciations->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$depreciations=$depreciations->setObject($obj);
		if($depreciations->edit($depreciations)){
			$error=UPDATESUCCESS;
			redirect("adddepreciations_proc.php?id=".$depreciations->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$assets= new Assets();
	$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_assets.categoryid, assets_assets.departmentid, assets_assets.employeeid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, assets_assets.supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$depreciations=new Depreciations();
	$where=" where id=$id ";
	$fields="assets_depreciations.id, assets_depreciations.assetid, assets_depreciations.depreciatedon, assets_depreciations.amount, assets_depreciations.perc, assets_depreciations.month, assets_depreciations.year, assets_depreciations.createdon, assets_depreciations.createdby, assets_depreciations.lasteditedon, assets_depreciations.lasteditedby";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$depreciations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$depreciations->fetchObject;

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
$where=" where name='assets_depreciations' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "adddepreciations.php";
?>