<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchasepayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/suppliers/Suppliers_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../fn/banks/Banks_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2182";//Edit
}
else{
	$auth->roleid="2180";//Add
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

	$suppliers= new Suppliers();
	$fields="pos_suppliers.id, pos_suppliers.code, pos_suppliers.name, pos_suppliers.contact, pos_suppliers.address, pos_suppliers.telephone, pos_suppliers.fax, pos_suppliers.email, pos_suppliers.mobile, pos_suppliers.status, pos_suppliers.createdby, pos_suppliers.createdon, pos_suppliers.lasteditedby, pos_suppliers.lasteditedon, pos_suppliers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentmodes= new Paymentmodes();
	$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.acctypeid, sys_paymentmodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$banks= new Banks();
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$purchasepayments=new Purchasepayments();
	$where=" where id=$id ";
	$fields="pos_purchasepayments.id, pos_purchasepayments.documentno, pos_purchasepayments.invoiceno, pos_purchasepayments.supplierid, pos_purchasepayments.amount, pos_purchasepayments.paymentmodeid, pos_purchasepayments.bankid, pos_purchasepayments.chequeno, pos_purchasepayments.paidon, pos_purchasepayments.offsetid, pos_purchasepayments.createdby, pos_purchasepayments.createdon, pos_purchasepayments.lasteditedby, pos_purchasepayments.lasteditedon, pos_purchasepayments.ipaddress";
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