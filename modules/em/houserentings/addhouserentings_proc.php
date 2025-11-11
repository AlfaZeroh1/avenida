<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houserentings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/tenants/Tenants_class.php");
require_once("../../em/houses/Houses_class.php");
require_once("../../em/rentaltypes/Rentaltypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4101";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4099";//Add
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
	$houserentings=new Houserentings();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$houserentings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houserentings=$houserentings->setObject($obj);
		if($houserentings->add($houserentings)){
			$error=SUCCESS;
			redirect("addhouserentings_proc.php?id=".$houserentings->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$houserentings=new Houserentings();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$houserentings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houserentings=$houserentings->setObject($obj);
		if($houserentings->edit($houserentings)){
			$error=UPDATESUCCESS;
			redirect("addhouserentings_proc.php?id=".$houserentings->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$tenants= new Tenants();
	$fields="em_tenants.id, em_tenants.code, em_tenants.firstname, em_tenants.middlename, em_tenants.lastname, em_tenants.postaladdress, em_tenants.address, em_tenants.registeredon, em_tenants.nationalityid, em_tenants.tel, em_tenants.mobile, em_tenants.fax, em_tenants.idno, em_tenants.passportno, em_tenants.dlno, em_tenants.occupation, em_tenants.email, em_tenants.dob";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$rentaltypes= new Rentaltypes();
	$fields="em_rentaltypes.id, em_rentaltypes.name, em_rentaltypes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rentaltypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$houserentings=new Houserentings();
	$where=" where id=$id ";
	$fields="em_houserentings.id, em_houserentings.houseid, em_houserentings.tenantid, em_houserentings.rentaltypeid, em_houserentings.occupiedon, em_houserentings.vacatedon, em_houserentings.leasestarts, em_houserentings.renewevery, em_houserentings.leaseends, em_houserentings.increasetype, em_houserentings.increaseby, em_houserentings.increaseevery, em_houserentings.rentduedate";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houserentings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$houserentings->fetchObject;

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
	
	
$page_title="Houserentings ";
include "addhouserentings.php";
?>