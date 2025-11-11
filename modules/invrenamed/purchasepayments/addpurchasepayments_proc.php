<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchasepayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="713";//Edit
}
else{
	$auth->roleid="711";//Add
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
	$purchasepayments=new Purchasepayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$purchasepayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchasepayments=$purchasepayments->setObject($obj);
		if($purchasepayments->add($purchasepayments)){
			$error=SUCCESS;
			redirect("addpurchasepayments_proc.php?id=".$purchasepayments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$purchasepayments=new Purchasepayments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$purchasepayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchasepayments=$purchasepayments->setObject($obj);
		if($purchasepayments->edit($purchasepayments)){
			$error=UPDATESUCCESS;
			redirect("addpurchasepayments_proc.php?id=".$purchasepayments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$purchasepayments=new Purchasepayments();
	$where=" where id=$id ";
	$fields="inv_purchasepayments.id, inv_purchasepayments.supplierid, inv_purchasepayments.amount, inv_purchasepayments.paymentmodeid, inv_purchasepayments.bank, inv_purchasepayments.chequeno, inv_purchasepayments.paymentdate, inv_purchasepayments.offsetid, inv_purchasepayments.createdby, inv_purchasepayments.createdon, inv_purchasepayments.lasteditedby, inv_purchasepayments.lasteditedon, inv_purchasepayments.documentno, inv_purchasepayments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchasepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$purchasepayments->fetchObject;

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
	
	
$page_title="Purchasepayments ";
include "addpurchasepayments.php";
?>