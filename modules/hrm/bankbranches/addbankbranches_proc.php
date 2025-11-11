<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bankbranches_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employeebanks/Employeebanks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4816";//Edit
}
else{
	$auth->roleid="4814";//Add
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
	$bankbranches=new Bankbranches();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$bankbranches->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$bankbranches=$bankbranches->setObject($obj);
		if($bankbranches->add($bankbranches)){
			$error=SUCCESS;
			redirect("addbankbranches_proc.php?id=".$bankbranches->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$bankbranches=new Bankbranches();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$bankbranches->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$bankbranches=$bankbranches->setObject($obj);
		if($bankbranches->edit($bankbranches)){
			$error=UPDATESUCCESS;
			redirect("addbankbranches_proc.php?id=".$bankbranches->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employeebanks= new Employeebanks();
	$fields="hrm_employeebanks.id, hrm_employeebanks.code, hrm_employeebanks.name, hrm_employeebanks.remarks, hrm_employeebanks.createdby, hrm_employeebanks.createdon, hrm_employeebanks.lasteditedby, hrm_employeebanks.lasteditedon, hrm_employeebanks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeebanks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$bankbranches=new Bankbranches();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$bankbranches->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$bankbranches->fetchObject;

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
	
	
$page_title="Bankbranches ";
include "addbankbranches.php";
?>