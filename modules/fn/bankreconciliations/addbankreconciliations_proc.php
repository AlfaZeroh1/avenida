<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bankreconciliations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/banks/Banks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4375";//Edit
}
else{
	$auth->roleid="4375";//Add
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
	$bankreconciliations=new Bankreconciliations();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$bankreconciliations->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$bankreconciliations=$bankreconciliations->setObject($obj);
		if($bankreconciliations->add($bankreconciliations)){
			$error=SUCCESS;
			redirect("addbankreconciliations_proc.php?id=".$bankreconciliations->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$bankreconciliations=new Bankreconciliations();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$bankreconciliations->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$bankreconciliations=$bankreconciliations->setObject($obj);
		if($bankreconciliations->edit($bankreconciliations)){
			$error=UPDATESUCCESS;
			redirect("addbankreconciliations_proc.php?id=".$bankreconciliations->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$banks= new Banks();
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$bankreconciliations=new Bankreconciliations();
	$where=" where id=$id ";
	$fields="fn_bankreconciliations.id, fn_bankreconciliations.bankid, fn_bankreconciliations.recondate, fn_bankreconciliations.balance";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$bankreconciliations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$bankreconciliations->fetchObject;

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
	
	
$page_title="Bankreconciliations ";
include "addbankreconciliations.php";
?>