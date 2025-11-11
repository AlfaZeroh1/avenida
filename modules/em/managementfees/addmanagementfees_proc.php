<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Managementfees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4352";//Edit
}
else{
	$auth->roleid="4350";//Add
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
	$managementfees=new Managementfees();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$managementfees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$managementfees=$managementfees->setObject($obj);
		if($managementfees->add($managementfees)){
			$error=SUCCESS;
			redirect("addmanagementfees_proc.php?id=".$managementfees->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$managementfees=new Managementfees();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$managementfees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$managementfees=$managementfees->setObject($obj);
		if($managementfees->edit($managementfees)){
			$error=UPDATESUCCESS;
			redirect("addmanagementfees_proc.php?id=".$managementfees->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$managementfees=new Managementfees();
	$where=" where id=$id ";
	$fields="em_managementfees.id, em_managementfees.clientid, em_managementfees.clienttype, em_managementfees.paymenttermid, em_managementfees.perc, em_managementfees.vatclasseid, em_managementfees.vatamount, em_managementfees.amount, em_managementfees.total, em_managementfees.month, em_managementfees.year, em_managementfees.chargedon, em_managementfees.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$managementfees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$managementfees->fetchObject;

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
	
	
$page_title="Managementfees ";
include "addmanagementfees.php";
?>