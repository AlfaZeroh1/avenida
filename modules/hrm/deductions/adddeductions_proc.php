<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deductions_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/incomes/Incomes_class.php");
require_once("../../fn/expenses/Expenses_class.php");
require_once("../../fn/liabilitys/Liabilitys_class.php");



if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/deductiontypes/Deductiontypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1109";//Edit
}
else{
	$auth->roleid="1107";//Add
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
	$deductions=new Deductions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$deductions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deductions=$deductions->setObject($obj);
		if($deductions->add($deductions)){
			$error=SUCCESS;
			redirect("adddeductions_proc.php?id=".$deductions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$deductions=new Deductions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$deductions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deductions=$deductions->setObject($obj);
		if($deductions->edit($deductions)){
			$error=UPDATESUCCESS;
			redirect("adddeductions_proc.php?id=".$deductions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$deductiontypes= new Deductiontypes();
	$fields="hrm_deductiontypes.id, hrm_deductiontypes.name, hrm_deductiontypes.repeatafter, hrm_deductiontypes.remarks, hrm_deductiontypes.createdby, hrm_deductiontypes.createdon, hrm_deductiontypes.lasteditedby, hrm_deductiontypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deductiontypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$deductions=new Deductions();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$deductions->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->epays="no";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->overall="Individual";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Deductions ";
include "adddeductions.php";
?>