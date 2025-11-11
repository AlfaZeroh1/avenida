<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerseasons_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/seasons/Seasons_class.php");
require_once("../../crm/customers/Customers_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8825";//Edit
}
else{
	$auth->roleid="8825";//Add
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
	$customerseasons=new Customerseasons();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$customerseasons->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerseasons=$customerseasons->setObject($obj);
		if($customerseasons->add($customerseasons)){
			$error=SUCCESS;
			redirect("addcustomerseasons_proc.php?id=".$customerseasons->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$customerseasons=new Customerseasons();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$customerseasons->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerseasons=$customerseasons->setObject($obj);
		if($customerseasons->edit($customerseasons)){
			$error=UPDATESUCCESS;
			redirect("addcustomerseasons_proc.php?id=".$customerseasons->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$seasons= new Seasons();
	$fields="pos_seasons.id, pos_seasons.name, pos_seasons.start, pos_seasons.end, pos_seasons.remarks, pos_seasons.ipaddress, pos_seasons.createdby, pos_seasons.createdon, pos_seasons.lasteditedby, pos_seasons.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$seasons->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$customerseasons=new Customerseasons();
	$where=" where id=$id ";
	$fields="crm_customerseasons.id, crm_customerseasons.customerid, crm_customerseasons.seasonid, crm_customerseasons.startdate, crm_customerseasons.enddate, crm_customerseasons.remarks, crm_customerseasons.ipaddress, crm_customerseasons.createdby, crm_customerseasons.createdon, crm_customerseasons.lasteditedby, crm_customerseasons.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customerseasons->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$customerseasons->fetchObject;

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
	
	
$page_title="Customerseasons ";
include "addcustomerseasons.php";
?>