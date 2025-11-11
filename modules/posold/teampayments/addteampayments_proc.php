<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Teampayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="12476";//Edit
}
else{
	$auth->roleid="12476";//Add
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
	$teampayments=new Teampayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$teampayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teampayments=$teampayments->setObject($obj);
		if($teampayments->add($teampayments)){
			$error=SUCCESS;
			redirect("addteampayments_proc.php?id=".$teampayments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$teampayments=new Teampayments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$teampayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teampayments=$teampayments->setObject($obj);
		if($teampayments->edit($teampayments)){
			$error=UPDATESUCCESS;
			redirect("addteampayments_proc.php?id=".$teampayments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$teampayments=new Teampayments();
	$where=" where id=$id ";
	$fields="pos_teampayments.id, pos_teampayments.teamdetailid, pos_teampayments.cashier, pos_teampayments.brancheid, pos_teampayments.paymentmodeid, pos_teampayments.bankid, pos_teampayments.imprestaccountid, pos_teampayments.amount, pos_teampayments.remarks, pos_teampayments.ipaddress, pos_teampayments.createdby, pos_teampayments.createdon, pos_teampayments.lasteditedby, pos_teampayments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teampayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$teampayments->fetchObject;

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
$where=" where name='pos_teampayments' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addteampayments.php";
?>