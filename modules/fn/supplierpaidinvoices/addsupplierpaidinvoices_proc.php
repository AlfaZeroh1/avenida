<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Supplierpaidinvoices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4731";//Edit
}
else{
	$auth->roleid="4729";//Add
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
	$supplierpaidinvoices=new Supplierpaidinvoices();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$supplierpaidinvoices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$supplierpaidinvoices=$supplierpaidinvoices->setObject($obj);
		if($supplierpaidinvoices->add($supplierpaidinvoices)){
			$error=SUCCESS;
			redirect("addsupplierpaidinvoices_proc.php?id=".$supplierpaidinvoices->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$supplierpaidinvoices=new Supplierpaidinvoices();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$supplierpaidinvoices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$supplierpaidinvoices=$supplierpaidinvoices->setObject($obj);
		if($supplierpaidinvoices->edit($supplierpaidinvoices)){
			$error=UPDATESUCCESS;
			redirect("addsupplierpaidinvoices_proc.php?id=".$supplierpaidinvoices->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$supplierpaidinvoices=new Supplierpaidinvoices();
	$where=" where id=$id ";
	$fields="fn_supplierpaidinvoices.id, fn_supplierpaidinvoices.voucherno, fn_supplierpaidinvoices.invoiceno, fn_supplierpaidinvoices.amount, fn_supplierpaidinvoices.createdby, fn_supplierpaidinvoices.createdon, fn_supplierpaidinvoices.lasteditedby, fn_supplierpaidinvoices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$supplierpaidinvoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$supplierpaidinvoices->fetchObject;

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
	
	
$page_title="Supplierpaidinvoices ";
include "addsupplierpaidinvoices.php";
?>