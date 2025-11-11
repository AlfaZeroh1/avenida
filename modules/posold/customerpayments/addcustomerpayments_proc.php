<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerpayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../crm/customers/Customers_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4860";//Edit
}
else{
	$auth->roleid="4858";//Add
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
	$customerpayments=new Customerpayments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$customerpayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerpayments=$customerpayments->setObject($obj);
		if($customerpayments->add($customerpayments)){
			$error=SUCCESS;
			redirect("addcustomerpayments_proc.php?id=".$customerpayments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$customerpayments=new Customerpayments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$customerpayments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerpayments=$customerpayments->setObject($obj);
		if($customerpayments->edit($customerpayments)){
			$error=UPDATESUCCESS;
			redirect("addcustomerpayments_proc.php?id=".$customerpayments->id."&error=".$error);
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


	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$customerpayments=new Customerpayments();
	$where=" where id=$id ";
	$fields="pos_customerpayments.id, pos_customerpayments.documentno, pos_customerpayments.invoiceno, pos_customerpayments.customerid, pos_customerpayments.amount, pos_customerpayments.paymentmodeid, pos_customerpayments.bankid, pos_customerpayments.chequeno, pos_customerpayments.paidon, pos_customerpayments.offsetid, pos_customerpayments.createdby, pos_customerpayments.createdon, pos_customerpayments.lasteditedby, pos_customerpayments.lasteditedon, pos_customerpayments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customerpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$customerpayments->fetchObject;

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
	
	
$page_title="Customerpayments ";
include "addcustomerpayments.php";
?>