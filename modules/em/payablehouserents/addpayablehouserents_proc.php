<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payablehouserents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/houses/Houses_class.php");
require_once("../../em/tenants/Tenants_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4251";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4249";//Add
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
	
	
if($obj->action=="Save"){
	$payablehouserents=new Payablehouserents();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$payablehouserents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payablehouserents=$payablehouserents->setObject($obj);
		if($payablehouserents->add($payablehouserents)){
			$error=SUCCESS;
			redirect("addpayablehouserents_proc.php?id=".$payablehouserents->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$payablehouserents=new Payablehouserents();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$payablehouserents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payablehouserents=$payablehouserents->setObject($obj);
		if($payablehouserents->edit($payablehouserents)){
			$error=UPDATESUCCESS;
			redirect("addpayablehouserents_proc.php?id=".$payablehouserents->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$tenants= new Tenants();
	$fields="em_tenants.id, em_tenants.code, em_tenants.firstname, em_tenants.middlename, em_tenants.lastname, em_tenants.postaladdress, em_tenants.address, em_tenants.registeredon, em_tenants.nationalityid, em_tenants.tel, em_tenants.mobile, em_tenants.fax, em_tenants.idno, em_tenants.passportno, em_tenants.dlno, em_tenants.occupation, em_tenants.email, em_tenants.dob";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$payablehouserents=new Payablehouserents();
	$where=" where id=$id ";
	$fields="em_payablehouserents.id, em_payablehouserents.documentno, em_payablehouserents.houseid, em_payablehouserents.tenantid, em_payablehouserents.month, em_payablehouserents.year, em_payablehouserents.invoicedon, em_payablehouserents.amount, em_payablehouserents.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$payablehouserents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$payablehouserents->fetchObject;

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
	
	
$page_title="Payablehouserents ";
include "addpayablehouserents.php";
?>