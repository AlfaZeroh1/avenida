<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Assets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/assetcategorys/Assetcategorys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="10310";//Edit
}
else{
	$auth->roleid="10308";//Add
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
	$assets=new Assets();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$assets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assets=$assets->setObject($obj);
		if($assets->add($assets)){
			$error=SUCCESS;
			redirect("addassets_proc.php?id=".$assets->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$assets=new Assets();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$assets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assets=$assets->setObject($obj);
		if($assets->edit($assets)){
			$error=UPDATESUCCESS;
			redirect("addassets_proc.php?id=".$assets->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$assetcategorys= new Assetcategorys();
	$fields="inv_assetcategorys.id, inv_assetcategorys.name, inv_assetcategorys.remarks, inv_assetcategorys.ipaddress, inv_assetcategorys.createdby, inv_assetcategorys.createdon, inv_assetcategorys.lasteditedby, inv_assetcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assetcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$assets=new Assets();
	$where=" where id=$id ";
	$fields="inv_assets.id, inv_assets.name, inv_assets.categoryid, inv_assets.quantity, inv_assets.costprice, inv_assets.remarks, inv_assets.ipaddress, inv_assets.createdby, inv_assets.createdon, inv_assets.lasteditedby, inv_assets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$assets->fetchObject;

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
$where=" where name='inv_assets' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addassets.php";
?>