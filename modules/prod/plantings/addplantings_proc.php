<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plantings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/breeders/Breeders_class.php");
require_once("../../prod/plantingdetails/Plantingdetails_class.php");
require_once("../../prod/varietys/Varietys_class.php");
require_once("../../prod/areas/Areas_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../prod/breederdeliverys/Breederdeliverys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8589";//Edit
}
else{
	$auth->roleid="8587";//Add
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
	
if(empty($obj->action)){
	$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from prod_plantings"));
	if($defs->documentno == null){
		$defs->documentno=1;
	}
	$obj->documentno=$defs->documentno;

	$obj->plantedon=date('Y-m-d');

}
	
if($obj->action=="Save"){
	$plantings=new Plantings();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpplantings=$_SESSION['shpplantings'];
	$error=$plantings->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpplantings)){
		$error="No items in the sale list!";
	}
	else{
		$plantings=$plantings->setObject($obj);
		if($plantings->add($plantings,$shpplantings)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$plantings=new Plantings();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$plantings->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plantings=$plantings->setObject($obj);
		$shpplantings=$_SESSION['shpplantings'];
		if($plantings->edit($plantings,$shpplantings)){
			$error=UPDATESUCCESS;
			redirect("addplantings_proc.php?id=".$plantings->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->varietyid)){
		$error=" must be provided";
	}
	elseif(empty($obj->areaid)){
		$error=" must be provided";
	}
	elseif(empty($obj->quantity)){
		$error=" must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpplantings=$_SESSION['shpplantings'];

	$varietys = new Varietys();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->varietyid'";
	$varietys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$varietys=$varietys->fetchObject;
	$areas = new Areas();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->areaid'";
	$areas->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$areas=$areas->fetchObject;
	$shpplantings[$it]=array('varietyid'=>"$obj->varietyid", 'varietyname'=>"$varietys->name", 'areaid'=>"$obj->areaid", 'areaname'=>"$areas->name", 'quantity'=>"$obj->quantity", 'memo'=>"$obj->memo");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpplantings']=$shpplantings;

	$obj->varietyid="";
 	$obj->areaid="";
 	$obj->quantity="";
 	$obj->memo="";
 }
}

if(empty($obj->action)){

	$breeders= new Breeders();
	$fields="prod_breeders.id, prod_breeders.code, prod_breeders.name, prod_breeders.contact, prod_breeders.physicaladdress, prod_breeders.tel, prod_breeders.fax, prod_breeders.email, prod_breeders.cellphone, prod_breeders.status, prod_breeders.createdby, prod_breeders.createdon, prod_breeders.lasteditedby, prod_breeders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breeders->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$breederdeliverys= new Breederdeliverys();
	$fields="prod_breederdeliverys.id, prod_breederdeliverys.documentno, prod_breederdeliverys.breederid, prod_breederdeliverys.deliveredon, prod_breederdeliverys.week, prod_breederdeliverys.remarks, prod_breederdeliverys.ipaddress, prod_breederdeliverys.createdby, prod_breederdeliverys.createdon, prod_breederdeliverys.lasteditedby, prod_breederdeliverys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breederdeliverys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$plantings=new Plantings();
	$where=" where id=$id ";
	$fields="prod_plantings.id, prod_plantings.documentno, prod_plantings.breederdeliveryid, prod_plantings.breederid, prod_plantings.plantedon, prod_plantings.week, prod_plantings.employeeid, prod_plantings.remarks, prod_plantings.ipaddress, prod_plantings.createdby, prod_plantings.createdon, prod_plantings.lasteditedby, prod_plantings.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plantings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$plantings->fetchObject;

	//for autocompletes
	$breeders = new Breeders();
	$fields=" * ";
	$where=" where id='$obj->breederid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breeders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$breeders->fetchObject;

	$obj->breedername=$auto->name;
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
	
	
$page_title="Plantings ";
include "addplantings.php";
?>