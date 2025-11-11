<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Insurances_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4499";//Edit
}
else{
	$auth->roleid="4499";//Add
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
	
	
if($obj->action=="Save"){
	$insurances=new Insurances();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$insurances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$insurances=$insurances->setObject($obj);
		if($insurances->add($insurances)){
			$error=SUCCESS;
			redirect("addinsurances_proc.php?id=".$insurances->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$insurances=new Insurances();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$insurances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$insurances=$insurances->setObject($obj);
		if($insurances->edit($insurances)){
			$error=UPDATESUCCESS;
			redirect("addinsurances_proc.php?id=".$insurances->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$insurances=new Insurances();
	$where=" where id=$id ";
	$fields="hos_insurances.id, hos_insurances.name, hos_insurances.remarks, hos_insurances.createdby, hos_insurances.createdon, hos_insurances.lasteditedby, hos_insurances.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$insurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$insurances->fetchObject;

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
	
	
$page_title="Insurances ";
include "addinsurances.php";
?>