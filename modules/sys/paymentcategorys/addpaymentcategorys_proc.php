<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9498";//Edit
}
else{
	$auth->roleid="9498";//Add
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
	$paymentcategorys=new Paymentcategorys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$paymentcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentcategorys=$paymentcategorys->setObject($obj);
		if($paymentcategorys->add($paymentcategorys)){
			$error=SUCCESS;
			redirect("addpaymentcategorys_proc.php?id=".$paymentcategorys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$paymentcategorys=new Paymentcategorys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$paymentcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentcategorys=$paymentcategorys->setObject($obj);
		if($paymentcategorys->edit($paymentcategorys)){
			$error=UPDATESUCCESS;
			redirect("addpaymentcategorys_proc.php?id=".$paymentcategorys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$paymentmodes= new Paymentmodes();
	$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.acctypeid, sys_paymentmodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$paymentcategorys=new Paymentcategorys();
	$where=" where id=$id ";
	$fields="sys_paymentcategorys.id, sys_paymentcategorys.paymentmodeid, sys_paymentcategorys.name, sys_paymentcategorys.remarks, sys_paymentcategorys.ipaddress, sys_paymentcategorys.createdby, sys_paymentcategorys.createdon, sys_paymentcategorys.lasteditedby, sys_paymentcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$paymentcategorys->fetchObject;

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
	
	
$page_title="Paymentcategorys ";
include "addpaymentcategorys.php";
?>