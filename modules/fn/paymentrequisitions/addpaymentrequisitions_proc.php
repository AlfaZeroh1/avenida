<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentrequisitions_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../pm/notifications/Notifications_class.php");
require_once("../../pm/notificationrecipients/Notificationrecipients_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../wf/routedetails/Routedetails_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../proc/suppliers/Suppliers_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7608";//Edit
}
else{
	$auth->roleid="7606";//Add
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
	$paymentrequisitions=new Paymentrequisitions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$paymentrequisitions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentrequisitions=$paymentrequisitions->setObject($obj);
		if($paymentrequisitions->add($paymentrequisitions)){
			$error=SUCCESS;
			redirect("addpaymentrequisitions_proc.php?id=".$paymentrequisitions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$paymentrequisitions=new Paymentrequisitions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$paymentrequisitions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentrequisitions=$paymentrequisitions->setObject($obj);
		if($paymentrequisitions->edit($paymentrequisitions)){
			$error=UPDATESUCCESS;
			redirect("addpaymentrequisitions_proc.php?id=".$paymentrequisitions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$paymentrequisitions=new Paymentrequisitions();
	$where=" where id=$id ";
	$fields="fn_paymentrequisitions.id, fn_paymentrequisitions.documentno, fn_paymentrequisitions.supplierid, fn_paymentrequisitions.invoicenos, fn_paymentrequisitions.amount, fn_paymentrequisitions.requisitiondate, fn_paymentrequisitions.remarks, fn_paymentrequisitions.status, fn_paymentrequisitions.ipaddress, fn_paymentrequisitions.createdby, fn_paymentrequisitions.createdon, fn_paymentrequisitions.lasteditedby, fn_paymentrequisitions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentrequisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$paymentrequisitions->fetchObject;

	//for autocompletes
	$suppliers = new Suppliers();
	$fields=" * ";
	$where=" where id='$obj->supplierid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$suppliers->fetchObject;

	$obj->suppliername=$auto->name;
	$suppliers = new Suppliers();
	$fields=" * ";
	$where=" where id='$obj->supplierid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$suppliers->fetchObject;

	$obj->suppliername=$auto->name;
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
	
	
$page_title="Paymentrequisitions ";
include "addpaymentrequisitions.php";
?>