<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Housetenants_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/houses/Houses_class.php");
require_once("../../em/tenants/Tenants_class.php");
require_once("../../em/rentaltypes/Rentaltypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4247";//Edit
}
else{
	$auth->roleid="4245";//Add
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
	$housetenants=new Housetenants();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$housetenants->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housetenants=$housetenants->setObject($obj);
		if($housetenants->add($housetenants)){
			$error=SUCCESS;
			redirect("addhousetenants_proc.php?id=".$housetenants->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$housetenants=new Housetenants();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$housetenants->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$housetenants=$housetenants->setObject($obj);
		if($housetenants->edit($housetenants)){
			$error=UPDATESUCCESS;
			redirect("addhousetenants_proc.php?id=".$housetenants->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.depositmgtfee, em_houses.depositmgtfeevatable, em_houses.depositmgtfeevatclasseid, em_houses.depositmgtfeeperc, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.chargeable, em_houses.penalty, em_houses.remarks";
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


	$rentaltypes= new Rentaltypes();
	$fields="em_rentaltypes.id, em_rentaltypes.name, em_rentaltypes.months, em_rentaltypes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rentaltypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$housetenants=new Housetenants();
	$where=" where id=$id ";
	$fields="em_housetenants.id, em_housetenants.houseid, em_housetenants.tenantid, em_housetenants.rentaltypeid, em_housetenants.occupiedon, em_housetenants.leasestarts, em_housetenants.renewevery, em_housetenants.leaseends, em_housetenants.increasetype, em_housetenants.increaseby, em_housetenants.increaseevery, em_housetenants.rentduedate, em_housetenants.lastmonthinvoiced, em_housetenants.lastyearinvoiced";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$housetenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$housetenants->fetchObject;

	//for autocompletes
	$tenants = new Tenants();
	$fields=" * ";
	$where=" where id='$obj->tenantid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$tenants->fetchObject;

	$obj->tenantname=$auto->name;
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
	
	
$page_title="Housetenants ";
include "addhousetenants.php";
?>