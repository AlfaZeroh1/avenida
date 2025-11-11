<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Loans_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/incomes/Incomes_class.php");
require_once("../../fn/liabilitys/Liabilitys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1175";//Edit
}
else{
	$auth->roleid="1173";//Add
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
	$loans=new Loans();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$loans->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$loans=$loans->setObject($obj);
		if($loans->add($loans)){
			$error=SUCCESS;
			redirect("addloans_proc.php?id=".$loans->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$loans=new Loans();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$loans->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$loans=$loans->setObject($obj);
		if($loans->edit($loans)){
			$error=UPDATESUCCESS;
			redirect("addloans_proc.php?id=".$loans->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$incomes= new Incomes();
	$fields="fn_incomes.id, fn_incomes.name, fn_incomes.code, fn_incomes.remarks, fn_incomes.ipaddress, fn_incomes.createdby, fn_incomes.createdon, fn_incomes.lasteditedby, fn_incomes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$incomes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$loans=new Loans();
	$where=" where id=$id ";
	$fields="hrm_loans.id, hrm_loans.name, hrm_loans.method, hrm_loans.type, hrm_loans.incomeid,hrm_loans.liabilityid, hrm_loans.description, hrm_loans.createdby, hrm_loans.createdon, hrm_loans.lasteditedby, hrm_loans.lasteditedon, hrm_loans.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$loans->fetchObject;

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
	
	
$page_title="Loans ";
include "addloans.php";
?>