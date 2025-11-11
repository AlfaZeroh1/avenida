<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Harvests_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/varietys/Varietys_class.php");
require_once("../../prod/varietystocks/Varietystocks_class.php");
require_once("../../prod/plantingdetails/Plantingdetails_class.php");
require_once("../../prod/areas/Areas_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");
require_once("../../prod/sizes/Sizes_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../sys/ipaddress/Ipaddress_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8581";//Edit
}
else{
	$auth->roleid="8579";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(empty($obj->action)){
  $obj->harvestedon=date("Y-m-d");
}

if(!empty($ob->status)){
  $obj->status=$ob->status;
}

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
	$harvests=new Harvests();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$shpharvests=$_SESSION['shpharvests'];
	$error=$harvests->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpharvests)){
		$error="No items in the sale list!";
	}
	else{
		$harvests=$harvests->setObject($obj);
		if($harvests->add($harvests,$shpharvests)){
			$error=SUCCESS;
			$saved="Yes";
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$harvests=new Harvests();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$harvests->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$harvests=$harvests->setObject($obj);
		$shpharvests=$_SESSION['shpharvests'];
		if($harvests->edit($harvests,$shpharvests)){
			$error=UPDATESUCCESS;
			redirect("addharvests_proc.php?id=".$harvests->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->varietyid)){
		$error="Variety must be provided";
	}
	/*elseif(empty($obj->sizeid)){
		$error="Sizes must be provided";
	}*//*
	elseif(empty($obj->plantingdetailid)){
		$error="Planting Detail must be provided";
	}*/
	elseif(empty($obj->greenhouseid)){
		$error="Area must be provided";
	}
	elseif(empty($obj->quantity)){
		$error="Quantity must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpharvests=$_SESSION['shpharvests'];

	$varietys = new Varietys();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->varietyid'";
	$varietys->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$varietys=$varietys->fetchObject;
	
	$sizes = new Sizes();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->sizeid'";
	$sizes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$sizes=$sizes->fetchObject;
	
	$plantingdetails = new Plantingdetails();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->plantingdetailid'";
	$plantingdetails->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$plantingdetails=$plantingdetails->fetchObject;
	
	$greenhouses = new Greenhouses();
	$fields=" * ";
	$join="";
	$groupby="";
	$having="";
	$where=" where id='$obj->greenhouseid'";
	$greenhouses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$greenhouses=$greenhouses->fetchObject;
	
	$shpharvests[$it]=array('varietyid'=>"$obj->varietyid", 'varietyname'=>"$varietys->name", 'sizeid'=>"$obj->sizeid", 'sizename'=>"$sizes->name", 'plantingdetailid'=>"$obj->plantingdetailid", 'plantingdetailname'=>"$plantingdetails->name", 'greenhouseid'=>"$obj->greenhouseid", 'greenhousename'=>"$greenhouses->name", 'quantity'=>"$obj->quantity");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpharvests']=$shpharvests;

	$obj->varietyname="";
 	$obj->varietyid="";
 	$obj->sizename="";
 	$obj->sizeid="";
 	$obj->plantingdetailname="";
 	$obj->plantingdetailid="";
 	$obj->areaname="";
 	$obj->greenhouseid="";
 	$obj->quantity="";
 }
}

if(empty($obj->action)){

	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$plantingdetails= new Plantingdetails();
	$fields="prod_plantingdetails.id, prod_plantingdetails.plantingid, prod_plantingdetails.varietyid, prod_plantingdetails.greenhouseid, prod_plantingdetails.quantity, prod_plantingdetails.memo, prod_plantingdetails.ipaddress, prod_plantingdetails.createdby, prod_plantingdetails.createdon, prod_plantingdetails.lasteditedby, prod_plantingdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plantingdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$areas= new Areas();
	$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.blockid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$sizes= new Sizes();
	$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$harvests=new Harvests();
	$where=" where id=$id ";
	$fields="prod_harvests.id, prod_harvests.varietyid, prod_harvests.sizeid, prod_harvests.plantingdetailid, prod_harvests.greenhouseid, prod_harvests.quantity, prod_harvests.harvestedon, prod_harvests.employeeid, prod_harvests.barcode, prod_harvests.remarks, prod_harvests.status, prod_harvests.ipaddress, prod_harvests.createdby, prod_harvests.createdon, prod_harvests.lasteditedby, prod_harvests.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$harvests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$harvests->fetchObject;

	//for autocompletes
	$employees = new Employees();
	$fields=" * ";
	$where=" where id='$obj->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$obj->employeename=$auto->name;
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	if(empty($obj->action2))
		$_SESSION['shpharvests']="";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Harvests ";
include "addharvests.php";
?>
