<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentvoucherdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/paymentvouchers/Paymentvouchers_class.php");
require_once("../../fn/cashrequisitions/Cashrequisitions_class.php");
require_once("../../fn/paymentrequisitions/Paymentrequisitions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8145";//Edit
}
else{
	$auth->roleid="8143";//Add
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
	$paymentvoucherdetails=new Paymentvoucherdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$paymentvoucherdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentvoucherdetails=$paymentvoucherdetails->setObject($obj);
		if($paymentvoucherdetails->add($paymentvoucherdetails)){
			$error=SUCCESS;
			redirect("addpaymentvoucherdetails_proc.php?id=".$paymentvoucherdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$paymentvoucherdetails=new Paymentvoucherdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$paymentvoucherdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentvoucherdetails=$paymentvoucherdetails->setObject($obj);
		if($paymentvoucherdetails->edit($paymentvoucherdetails)){
			$error=UPDATESUCCESS;
			redirect("addpaymentvoucherdetails_proc.php?id=".$paymentvoucherdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$paymentvouchers= new Paymentvouchers();
	$fields="fn_paymentvouchers.id, fn_paymentvouchers.documentno, fn_paymentvouchers.voucherno, fn_paymentvouchers.voucherdate, fn_paymentvouchers.payee, fn_paymentvouchers.paymentmodeid, fn_paymentvouchers.bankid, fn_paymentvouchers.chequeno, fn_paymentvouchers.chequedate, fn_paymentvouchers.remarks, fn_paymentvouchers.status, fn_paymentvouchers.ipaddress, fn_paymentvouchers.createdby, fn_paymentvouchers.createdon, fn_paymentvouchers.lasteditedby, fn_paymentvouchers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentvouchers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$cashrequisitions= new Cashrequisitions();
	$fields="fn_cashrequisitions.id, fn_cashrequisitions.documentno, fn_cashrequisitions.projectid, fn_cashrequisitions.employeeid, fn_cashrequisitions.description, fn_cashrequisitions.amount, fn_cashrequisitions.status, fn_cashrequisitions.remarks, fn_cashrequisitions.ipaddress, fn_cashrequisitions.createdby, fn_cashrequisitions.createdon, fn_cashrequisitions.lasteditedby, fn_cashrequisitions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$cashrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentrequisitions= new Paymentrequisitions();
	$fields="fn_paymentrequisitions.id, fn_paymentrequisitions.documentno, fn_paymentrequisitions.supplierid, fn_paymentrequisitions.invoicenos, fn_paymentrequisitions.amount, fn_paymentrequisitions.requisitiondate, fn_paymentrequisitions.remarks, fn_paymentrequisitions.status, fn_paymentrequisitions.ipaddress, fn_paymentrequisitions.createdby, fn_paymentrequisitions.createdon, fn_paymentrequisitions.lasteditedby, fn_paymentrequisitions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$paymentvoucherdetails=new Paymentvoucherdetails();
	$where=" where id=$id ";
	$fields="fn_paymentvoucherdetails.id, fn_paymentvoucherdetails.paymentvoucherid, fn_paymentvoucherdetails.cashrequisitionid, fn_paymentvoucherdetails.paymentrequisitionid, fn_paymentvoucherdetails.amount, fn_paymentvoucherdetails.remarks, fn_paymentvoucherdetails.ipaddress, fn_paymentvoucherdetails.createdby, fn_paymentvoucherdetails.createdon, fn_paymentvoucherdetails.lasteditedby, fn_paymentvoucherdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentvoucherdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$paymentvoucherdetails->fetchObject;

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
	
	
$page_title="Paymentvoucherdetails ";
include "addpaymentvoucherdetails.php";
?>