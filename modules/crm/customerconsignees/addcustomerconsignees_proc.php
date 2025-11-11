<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerconsignees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9364";//Edit
}
else{
	$auth->roleid="9364";//Add
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
	$customerconsignees=new Customerconsignees();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$customerconsignees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerconsignees=$customerconsignees->setObject($obj);
		if($customerconsignees->add($customerconsignees)){
			$error=SUCCESS;
			redirect("addcustomerconsignees_proc.php?id=".$customerconsignees->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$customerconsignees=new Customerconsignees();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$customerconsignees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerconsignees=$customerconsignees->setObject($obj);
		if($customerconsignees->edit($customerconsignees)){
			$error=UPDATESUCCESS;
			redirect("addcustomerconsignees_proc.php?id=".$customerconsignees->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.acctypeid, crm_customers.refid, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$customerconsignees=new Customerconsignees();
	$where=" where id=$id ";
	$fields="crm_customerconsignees.id, crm_customerconsignees.customerid, crm_customerconsignees.name, crm_customerconsignees.address, crm_customerconsignees.remarks, crm_customerconsignees.ipaddress, crm_customerconsignees.createdby, crm_customerconsignees.createdon, crm_customerconsignees.lasteditedby, crm_customerconsignees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customerconsignees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$customerconsignees->fetchObject;

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
	
	
$page_title="Customerconsignees ";
include "addcustomerconsignees.php";
?>