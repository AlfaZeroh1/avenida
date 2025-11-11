<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerprices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
require_once("../../pos/seasons/Seasons_class.php");
require_once("../../pos/categorys/Categorys_class.php");
require_once("../../pos/sizes/Sizes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8681";//Edit
}
else{
	$auth->roleid="8679";//Add
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
	$customerprices=new Customerprices();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$customerprices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerprices=$customerprices->setObject($obj);
		if($customerprices->add($customerprices)){
			$error=SUCCESS;
			redirect("addcustomerprices_proc.php?id=".$customerprices->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$customerprices=new Customerprices();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$customerprices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$customerprices=$customerprices->setObject($obj);
		if($customerprices->edit($customerprices)){
			$error=UPDATESUCCESS;
			redirect("addcustomerprices_proc.php?id=".$customerprices->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$seasons= new Seasons();
	$fields="pos_seasons.id, pos_seasons.name, pos_seasons.start, pos_seasons.end, pos_seasons.remarks, pos_seasons.ipaddress, pos_seasons.createdby, pos_seasons.createdon, pos_seasons.lasteditedby, pos_seasons.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$seasons->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$categorys= new Categorys();
	$fields="pos_categorys.id, pos_categorys.name, pos_categorys.remarks, pos_categorys.ipaddress, pos_categorys.createdby, pos_categorys.createdon, pos_categorys.lasteditedby, pos_categorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$sizes= new Sizes();
	$fields="pos_sizes.id, pos_sizes.name, pos_sizes.remarks, pos_sizes.ipaddress, pos_sizes.createdby, pos_sizes.createdon, pos_sizes.lasteditedby, pos_sizes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$customerprices=new Customerprices();
	$where=" where id=$id ";
	$fields="crm_customerprices.id, crm_customerprices.customerid, crm_customerprices.seasonid, crm_customerprices.categoryid, crm_customerprices.sizeid, crm_customerprices.price, crm_customerprices.remarks, crm_customerprices.ipaddress, crm_customerprices.createdby, crm_customerprices.createdon, crm_customerprices.lasteditedby, crm_customerprices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customerprices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$customerprices->fetchObject;

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
	
	
$page_title="Customerprices ";
include "addcustomerprices.php";
?>