<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/acctypes/Acctypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9008";//Edit
}
else{
	$auth->roleid="9006";//Add
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
	$payments=new Payments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$payments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payments=$payments->setObject($obj);
		if($payments->add($payments)){
			$error=SUCCESS;
			redirect("addpayments_proc.php?id=".$payments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$payments=new Payments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$payments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payments=$payments->setObject($obj);
		if($payments->edit($payments)){
			$error=UPDATESUCCESS;
			redirect("addpayments_proc.php?id=".$payments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$acctypes= new Acctypes();
	$fields="sys_acctypes.id, sys_acctypes.name, sys_acctypes.balance";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$payments=new Payments();
	$where=" where id=$id ";
	$fields="fn_payments.id, fn_payments.name, fn_payments.remarks, fn_payments.acctypeid, fn_payments.ipaddress, fn_payments.createdby, fn_payments.createdon, fn_payments.lasteditedby, fn_payments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$payments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$payments->fetchObject;

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
	
	
$page_title="Payments ";
include "addpayments.php";
?>