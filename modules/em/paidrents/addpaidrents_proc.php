<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paidrents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/houses/Houses_class.php");
require_once("../../em/tenants/Tenants_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4223";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4221";//Add
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
	$paidrents=new Paidrents();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$paidrents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paidrents=$paidrents->setObject($obj);
		if($paidrents->add($paidrents)){
			$error=SUCCESS;
			redirect("addpaidrents_proc.php?id=".$paidrents->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$paidrents=new Paidrents();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$paidrents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paidrents=$paidrents->setObject($obj);
		if($paidrents->edit($paidrents)){
			$error=UPDATESUCCESS;
			redirect("addpaidrents_proc.php?id=".$paidrents->id."&error=".$error);
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
	$paidrents=new Paidrents();
	$where=" where id=$id ";
	$fields="em_paidrents.id, em_paidrents.houseid, em_paidrents.tenantid, em_paidrents.month, em_paidrents.year, em_paidrents.amount, em_paidrents.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paidrents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$paidrents->fetchObject;

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
	
	
$page_title="Paidrents ";
include "addpaidrents.php";
?>