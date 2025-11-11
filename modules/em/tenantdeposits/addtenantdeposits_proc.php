<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenantdeposits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/tenants/Tenants_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");
require_once("../../em/houses/Houses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9062";//Edit
}
else{
	$auth->roleid="9060";//Add
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
	$tenantdeposits=new Tenantdeposits();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tenantdeposits->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tenantdeposits=$tenantdeposits->setObject($obj);
		if($tenantdeposits->add($tenantdeposits)){
			$error=SUCCESS;
			redirect("addtenantdeposits_proc.php?id=".$tenantdeposits->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tenantdeposits=new Tenantdeposits();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tenantdeposits->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tenantdeposits=$tenantdeposits->setObject($obj);
		if($tenantdeposits->edit($tenantdeposits)){
			$error=UPDATESUCCESS;
			redirect("addtenantdeposits_proc.php?id=".$tenantdeposits->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$tenants= new Tenants();
	$fields="em_tenants.id, em_tenants.code, em_tenants.firstname, em_tenants.middlename, em_tenants.lastname, em_tenants.postaladdress, em_tenants.address, em_tenants.registeredon, em_tenants.nationalityid, em_tenants.tel, em_tenants.mobile, em_tenants.fax, em_tenants.idno, em_tenants.passportno, em_tenants.dlno, em_tenants.occupation, em_tenants.email, em_tenants.dob, em_tenants.ipaddress, em_tenants.createdby, em_tenants.createdon, em_tenants.lasteditedby, em_tenants.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentterms= new Paymentterms();
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.generaljournalaccountid, em_paymentterms.chargemgtfee, em_paymentterms.remarks, em_paymentterms.ipaddress, em_paymentterms.createdby, em_paymentterms.createdon, em_paymentterms.lasteditedby, em_paymentterms.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.depositmgtfee, em_houses.depositmgtfeevatable, em_houses.depositmgtfeevatclasseid, em_houses.depositmgtfeeperc, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.chargeable, em_houses.penalty, em_houses.remarks, em_houses.ipaddress, em_houses.createdby, em_houses.createdon, em_houses.lasteditedby, em_houses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$tenantdeposits=new Tenantdeposits();
	$where=" where id=$id ";
	$fields="em_tenantdeposits.id, em_tenantdeposits.tenantid, em_tenantdeposits.houseid, em_tenantdeposits.houserentingid, em_tenantdeposits.tenantpaymentid, em_tenantdeposits.paymenttermid, em_tenantdeposits.amount, em_tenantdeposits.paidon, em_tenantdeposits.remarks, em_tenantdeposits.status, em_tenantdeposits.ipaddress, em_tenantdeposits.createdby, em_tenantdeposits.createdon, em_tenantdeposits.lasteditedby, em_tenantdeposits.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenantdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tenantdeposits->fetchObject;

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
	
	
$page_title="Tenantdeposits ";
include "addtenantdeposits.php";
?>