<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Allowances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/allowancetypes/Allowancetypes_class.php");
require_once("../../fn/expenses/Expenses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1101";//Edit
}
else{
	$auth->roleid="1099";//Add
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
	$allowances=new Allowances();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$allowances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$allowances=$allowances->setObject($obj);
		if($allowances->add($allowances)){
			$error=SUCCESS;
			redirect("addallowances_proc.php?id=".$allowances->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$allowances=new Allowances();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$allowances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$allowances=$allowances->setObject($obj);
		if($allowances->edit($allowances)){
			$error=UPDATESUCCESS;
			redirect("addallowances_proc.php?id=".$allowances->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$allowancetypes= new Allowancetypes();
	$fields="hrm_allowancetypes.id, hrm_allowancetypes.name, hrm_allowancetypes.repeatafter, hrm_allowancetypes.remarks, hrm_allowancetypes.createdby, hrm_allowancetypes.createdon, hrm_allowancetypes.lasteditedby, hrm_allowancetypes.lasteditedon, hrm_allowancetypes.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$allowancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$expenses= new Expenses();
	$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$allowances=new Allowances();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$allowances->fetchObject;

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
	
	
$page_title="Allowances ";
include "addallowances.php";
?>