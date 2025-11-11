<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Assetcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="10336";//Edit
}
else{
	$auth->roleid="10336";//Add
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
	$assetcategorys=new Assetcategorys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$assetcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assetcategorys=$assetcategorys->setObject($obj);
		if($assetcategorys->add($assetcategorys)){
			$error=SUCCESS;
			redirect("addassetcategorys_proc.php?id=".$assetcategorys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$assetcategorys=new Assetcategorys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$assetcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assetcategorys=$assetcategorys->setObject($obj);
		if($assetcategorys->edit($assetcategorys)){
			$error=UPDATESUCCESS;
			redirect("addassetcategorys_proc.php?id=".$assetcategorys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$assetcategorys=new Assetcategorys();
	$where=" where id=$id ";
	$fields="inv_assetcategorys.id, inv_assetcategorys.name, inv_assetcategorys.remarks, inv_assetcategorys.ipaddress, inv_assetcategorys.createdby, inv_assetcategorys.createdon, inv_assetcategorys.lasteditedby, inv_assetcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assetcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$assetcategorys->fetchObject;

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
$where=" where name='inv_assetcategorys' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addassetcategorys.php";
?>