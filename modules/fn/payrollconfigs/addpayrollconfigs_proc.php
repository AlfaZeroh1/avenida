<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Payrollconfigs_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once("../../fn/liabilitys/Liabilitys_class.php");
require_once("../../assets/assets/Assets_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="10106";//Edit
}
else{
	$auth->roleid="10104";//Add
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
	$payrollconfigs=new Payrollconfigs();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$payrollconfigs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payrollconfigs=$payrollconfigs->setObject($obj);
		if($payrollconfigs->add($payrollconfigs)){
			$error=SUCCESS;
			redirect("addpayrollconfigs_proc.php?id=".$payrollconfigs->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$payrollconfigs=new Payrollconfigs();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$payrollconfigs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payrollconfigs=$payrollconfigs->setObject($obj);
		if($payrollconfigs->edit($payrollconfigs)){
			$error=UPDATESUCCESS;
			redirect("addpayrollconfigs_proc.php?id=".$payrollconfigs->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$payrollconfigs=new Payrollconfigs();
	$where=" where id=$id ";
	$fields="fn_payrollconfigs.id, fn_payrollconfigs.name, fn_payrollconfigs.type, fn_payrollconfigs.value, fn_payrollconfigs.remarks, fn_payrollconfigs.ipaddress, fn_payrollconfigs.createdby, fn_payrollconfigs.createdon, fn_payrollconfigs.lasteditedby, fn_payrollconfigs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$payrollconfigs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$payrollconfigs->fetchObject;

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
$where=" where name='fn_payrollconfigs' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addpayrollconfigs.php";
?>