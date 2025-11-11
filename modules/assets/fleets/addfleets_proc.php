<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/fleetmodels/Fleetmodels_class.php");
require_once("../../assets/fleetfueltypes/Fleetfueltypes_class.php");
require_once("../../assets/fleettypes/Fleettypes_class.php");
require_once("../../assets/fleetodometertypes/Fleetodometertypes_class.php");
require_once("../../assets/fleetserviceitems/Fleetserviceitems_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/departments/Departments_class.php");

require_once("../../assets/assetconsumables/Assetconsumables_class.php");
require_once("../../assets/consumables/Consumables_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7648";//Edit
}
else{
	$auth->roleid="7646";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../assets/inspections/Inspections_class.php");
//for merged foreign keys
require_once("../../assets/assets/Assets_class.php");
require_once("../../assets/inspectionitems/Inspectionitems_class.php");
require_once("../../assets/fleetmaintenances/Fleetmaintenances_class.php");
//for merged foreign keys
require_once("../../assets/assets/Assets_class.php");
require_once("../../assets/breakdowns/Breakdowns_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../sys/purchasemodes/Purchasemodes_class.php");
require_once("../../assets/fleetfueling/Fleetfueling_class.php");
//for merged foreign keys
require_once("../../hrm/employees/Employees_class.php");
require_once("../../assets/fleetservices/Fleetservices_class.php");
require_once("../../assets/fleetservicedetails/Fleetservicedetails_class.php");
//for merged foreign keys
require_once("../../assets/fleetschedules/Fleetschedules_class.php");
//for merged foreign keys
require_once("../../assets/assets/Assets_class.php");
require_once("../../con/projects/Projects_class.php");
require_once("../../con/reviews/Reviews_class.php");
require_once("../../con/projectreviewdetails/Projectreviewdetails_class.php");
require_once("../../crm/customers/Customers_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../assets/breakdowns/Breakdowns_class.php");
require_once("../../assets/fleetcolors/Fleetcolors_class.php");
require_once("../../assets/insurances/Insurances_class.php");
//for merged foreign keys
require_once("../../assets/insurers/Insurers_class.php");
//for merged foreign keys
if(!empty($_GET['breakdowns'])){
	$breakdowns = new Breakdowns();
	$breakdowns->id=$_GET['breakdowns'];
}

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
	$fleets=new Fleets();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleets=$fleets->setObject($obj);
		if($fleets->add($fleets)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$fleets->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleets=new Fleets();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleets=$fleets->setObject($obj);
		if($fleets->edit($fleets)){
			$error=UPDATESUCCESS;
			redirect("addfleets_proc.php?id=".$fleets->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

//Process adding of inspections
if($obj->actioninspection=="Add Inspection"){
	$inspections = new Inspections();

	$obj->fleetid=$obj->id;
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	
	

	$error=$inspections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$inspections=$inspections->setObject($obj);
		$inspections->id="";
		if($inspections->add($inspections)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of inspections
if($obj->actioninspection=="Update Inspection"){
	$inspections = new Inspections();

	$inspections->fleetid=$obj->id;
	$inspections->createdby=$_SESSION['userid'];
	$inspections->createdon=date("Y-m-d H:i:s");
	$inspections->lasteditedby=$_SESSION['userid'];
	$inspections->lasteditedon=date("Y-m-d H:i:s");
	$inspections->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$inspections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$inspections=$inspections->setObject($obj);
		if($inspections->edit($inspections)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process adding of fleetmaintenances
if($obj->actionfleetmaintenance=="Add Fleetmaintenance"){
	$fleetmaintenances = new Fleetmaintenances();

	$obj->fleetid=$obj->id;
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$fleetmaintenances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetmaintenances=$fleetmaintenances->setObject($obj);
		$fleetmaintenances->id="";
		if($fleetmaintenances->add($fleetmaintenances)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of fleetmaintenances
if($obj->actionfleetmaintenance=="Update Fleetmaintenance"){
	$fleetmaintenances = new Fleetmaintenances();

	$fleetmaintenances->fleetid=$obj->id;
	$fleetmaintenances->createdby=$_SESSION['userid'];
	$fleetmaintenances->createdon=date("Y-m-d H:i:s");
	$fleetmaintenances->lasteditedby=$_SESSION['userid'];
	$fleetmaintenances->lasteditedon=date("Y-m-d H:i:s");
	$fleetmaintenances->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetmaintenances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetmaintenances=$fleetmaintenances->setObject($obj);
		if($fleetmaintenances->edit($fleetmaintenances)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process adding of fleetfueling
if($obj->actionfleetfuelin=="Add Fleetfuelin"){
	$fleetfueling = new Fleetfueling();

	//$obj->fleetid=$obj->id;
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$fleetfueling->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetfueling=$fleetfueling->setObject($obj);
		$fleetfueling->id="";
		if($fleetfueling->add($fleetfueling)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of fleetfueling
if($obj->actionfleetfuelin=="Update Fleetfuelin"){
	$fleetfueling = new Fleetfueling();

	$fleetfueling->fleetid=$obj->id;
	$fleetfueling->createdby=$_SESSION['userid'];
	$fleetfueling->createdon=date("Y-m-d H:i:s");
	$fleetfueling->lasteditedby=$_SESSION['userid'];
	$fleetfueling->lasteditedon=date("Y-m-d H:i:s");
	$fleetfueling->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetfueling->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetfueling=$fleetfueling->setObject($obj);
		if($fleetfueling->edit($fleetfueling)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process adding of fleetservices
if($obj->actionfleetservice=="Add Fleetservice"){
	$fleetservices = new Fleetservices();

	$fleetservices->fleetid=$obj->id;
	$fleetservices->createdby=$_SESSION['userid'];
	$fleetservices->createdon=date("Y-m-d H:i:s");
	$fleetservices->lasteditedby=$_SESSION['userid'];
	$fleetservices->lasteditedon=date("Y-m-d H:i:s");
	$fleetservices->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$fleetservices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetservices=$fleetservices->setObject($obj);
		if($fleetservices->add($fleetservices)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of fleetservices
if($obj->actionfleetservice=="Update Fleetservice"){
	$fleetservices = new Fleetservices();

	$fleetservices->fleetid=$obj->id;
	$fleetservices->createdby=$_SESSION['userid'];
	$fleetservices->createdon=date("Y-m-d H:i:s");
	$fleetservices->lasteditedby=$_SESSION['userid'];
	$fleetservices->lasteditedon=date("Y-m-d H:i:s");
	$fleetservices->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetservices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetservices=$fleetservices->setObject($obj);
		if($fleetservices->edit($fleetservices)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}


////////service details


//Process adding of fleetservices
if($obj->actionfleetservicedetail=="Add Fleetservicedetail"){
	$fleetservicedetails = new Fleetservicedetails();

	$fleetservicedetails->fleetserviceid=$obj->id;
	$fleetservicedetails->createdby=$_SESSION['userid'];
	$fleetservicedetails->createdon=date("Y-m-d H:i:s");
	$fleetservicedetails->lasteditedby=$_SESSION['userid'];
	$fleetservicedetails->lasteditedon=date("Y-m-d H:i:s");
	$fleetservicedetails->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$fleetservicedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetservicedetails=$fleetservicedetails->setObject($obj);
		if($fleetservicedetails->add($fleetservicedetails)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of fleetservices
if($obj->actionfleetservicedetail=="Update Fleetservicedetail"){
	$fleetservicedetails = new Fleetservicedetails();

	$fleetservicedetails->fleetserviceid=$obj->id;
	$fleetservicedetails->createdby=$_SESSION['userid'];
	$fleetservicedetails->createdon=date("Y-m-d H:i:s");
	$fleetservicedetails->lasteditedby=$_SESSION['userid'];
	$fleetservicedetails->lasteditedon=date("Y-m-d H:i:s");
	$fleetservicedetails->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetservicedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetservicedetails=$fleetservicedetails->setObject($obj);
		if($fleetservicedetails->edit($fleetservicedetails)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}





//Process adding of fleetschedules
if($obj->actionfleetschedule=="Add Fleetschedule"){
	$fleetschedules = new Fleetschedules();

	$fleetschedules->fleetid=$obj->id;
	$fleetschedules->createdby=$_SESSION['userid'];
	$fleetschedules->createdon=date("Y-m-d H:i:s");
	$fleetschedules->lasteditedby=$_SESSION['userid'];
	$fleetschedules->lasteditedon=date("Y-m-d H:i:s");
	$fleetschedules->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$fleetschedules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetschedules=$fleetschedules->setObject($obj);
		if($fleetschedules->add($fleetschedules)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of fleetschedules
if($obj->actionfleetschedule=="Update Fleetschedule"){
	$fleetschedules = new Fleetschedules();

	$fleetschedules->fleetid=$obj->id;
	$fleetschedules->createdby=$_SESSION['userid'];
	$fleetschedules->createdon=date("Y-m-d H:i:s");
	$fleetschedules->lasteditedby=$_SESSION['userid'];
	$fleetschedules->lasteditedon=date("Y-m-d H:i:s");
	$fleetschedules->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetschedules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetschedules=$fleetschedules->setObject($obj);
		if($fleetschedules->edit($fleetschedules)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process adding of breakdowns
if($obj->action=="Add Breakdown"){
	$breakdowns = new Breakdowns();

	$breakdowns->fleetid=$obj->id;
	$breakdowns->assetid=$obj->assetid;
	$breakdowns->createdby=$_SESSION['userid'];
	$breakdowns->createdon=date("Y-m-d H:i:s");
	$breakdowns->lasteditedby=$_SESSION['userid'];
	$breakdowns->lasteditedon=date("Y-m-d H:i:s");
	$breakdowns->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$breakdowns->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$breakdowns=$breakdowns->setObject($obj);
		if($breakdowns->add($breakdowns)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of breakdowns

//////addd insurances

//Process adding of insurances
if($obj->actioninsurance=="Add Insurances"){
	$insurances = new Insurances();

	$insurances->fleetid=$obj->id;
	$insurances->createdby=$_SESSION['userid'];
	$insurances->createdon=date("Y-m-d H:i:s");
	$insurances->lasteditedby=$_SESSION['userid'];
	$insurances->lasteditedon=date("Y-m-d H:i:s");
	$insurances->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$insurances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$insurances=$insurances->setObject($obj);
		if($insurances->add($insurances)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of insurances
if($obj->actioninsurance=="Update Insurances"){
	$insurances =  new Insurances();

	$insurances->fleetid=$obj->id;
	$insurances->createdby=$_SESSION['userid'];
	$insurances->createdon=date("Y-m-d H:i:s");
	$insurances->lasteditedby=$_SESSION['userid'];
	$insurances->lasteditedon=date("Y-m-d H:i:s");
	$insurances->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$insurances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$insurances=$insurances->setObject($obj);
		if($insurances->edit($insurances)){
			$error=SUCCESS;
			redirect("addfleets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

if(empty($obj->action)){

	$fleetmodels= new Fleetmodels();
	$fields="assets_fleetmodels.id, assets_fleetmodels.name, assets_fleetmodels.fleetmakeid, assets_fleetmodels.remarks, assets_fleetmodels.ipaddress, assets_fleetmodels.createdby, assets_fleetmodels.createdon, assets_fleetmodels.lasteditedby, assets_fleetmodels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetmodels->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$fleetfueltypes= new Fleetfueltypes();
	$fields="assets_fleetfueltypes.id, assets_fleetfueltypes.name, assets_fleetfueltypes.remarks, assets_fleetfueltypes.ipaddress, assets_fleetfueltypes.createdby, assets_fleetfueltypes.createdon, assets_fleetfueltypes.lasteditedby, assets_fleetfueltypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetfueltypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$fleettypes= new Fleettypes();
	$fields="assets_fleettypes.id, assets_fleettypes.name, assets_fleettypes.remarks, assets_fleettypes.ipaddress, assets_fleettypes.createdby, assets_fleettypes.createdon, assets_fleettypes.lasteditedby, assets_fleettypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleettypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$fleetodometertypes= new Fleetodometertypes();
	$fields="assets_fleetodometertypes.id, assets_fleetodometertypes.name, assets_fleetodometertypes.remarks, assets_fleetodometertypes.ipaddress, assets_fleetodometertypes.createdby, assets_fleetodometertypes.createdon, assets_fleetodometertypes.lasteditedby, assets_fleetodometertypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetodometertypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$departments= new Departments();
	$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$fleets=new Fleets();
	$where=" where id=$id ";
	$fields="assets_fleets.id, assets_fleets.assetid, assets_fleets.fleetmodelid, assets_fleets.year, assets_fleets.fleetcolorid, assets_fleets.vin, assets_fleets.fleettypeid, assets_fleets.plateno, assets_fleets.engine, assets_fleets.fleetfueltypeid, assets_fleets.fleetodometertypeid, assets_fleets.mileage, assets_fleets.lastservicemileage, assets_fleets.employeeid, assets_fleets.departmentid, assets_fleets.ipaddress, assets_fleets.createdby, assets_fleets.createdon, assets_fleets.lasteditedby, assets_fleets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleets->fetchObject;

// 	//for merged tables
// 	$inspections = new Inspections();
// 	$fields=" * ";
// 	$where=" where fleetid=$id";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$inspections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	if(mysql_affected_rows()>0){
// 		$obj->actioninspection="Update Inspection";
// 	}
// 	else{
 		$obj->actioninspection="Add Inspection";
// 	}
// 	$merge=$inspections->fetchObject;
// 
// 	$obj = (object) array_merge((array) $obj, (array) $merge);
// 	//for merged tables
// 	$fleetmaintenances = new Fleetmaintenances();
// 	$fields=" * ";
// 	$where=" where fleetid=$id";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$fleetmaintenances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	if(mysql_affected_rows()>0){
// 		$obj->actionfleetmaintenance="Update Fleetmaintenance";
// 	}
// 	else{
 		$obj->actionfleetmaintenance="Add Fleetmaintenance";
// 	}
// 	$merge=$fleetmaintenances->fetchObject;
// 
// 	$obj = (object) array_merge((array) $obj, (array) $merge);
// 	//for merged tables
// 	$fleetfueling = new Fleetfueling();
// 	$fields=" * ";
// 	$where=" where fleetid=$id";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$fleetfueling->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	if(mysql_affected_rows()>0){
// 		$obj->actionfleetfuelin="Update Fleetfuelin";
// 	}
// 	else{
 		$obj->actionfleetfuelin="Add Fleetfuelin";
// 	}
// 	$merge=$fleetfueling->fetchObject;
// 
// 	$obj = (object) array_merge((array) $obj, (array) $merge);
// 	//for merged tables
// 	$fleetservices = new Fleetservices();
// 	$fields=" * ";
// 	$where=" where fleetid=$id";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$fleetservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	if(mysql_affected_rows()>0){
// 		$obj->actionfleetservice="Update Fleetservice";
// 	}
// 	else{
 		$obj->actionfleetservice="Add Fleetservice";
// 	}
// 	$merge=$fleetservices->fetchObject;
// 
// 	$obj = (object) array_merge((array) $obj, (array) $merge);
// 	//for merged tables
// 	$fleetschedules = new Fleetschedules();
// 	$fields=" * ";
// 	$where=" where fleetid=$id";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$fleetschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	if(mysql_affected_rows()>0){
// 		$obj->actionfleetschedule="Update Fleetschedule";
// 	}
// 	else{
 		$obj->actionfleetschedule="Add Fleetschedule";
// 	}
// 	$merge=$fleetschedules->fetchObject;
// 
// 	$obj = (object) array_merge((array) $obj, (array) $merge);
// 	//for merged tables
// 	$breakdowns = new Breakdowns();
// 	$fields=" * ";
// 	$where=" where fleetid=$id";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$breakdowns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	if(mysql_affected_rows()>0){
// 		$obj->actionbreakdown="Update Breakdown";
// 	}
// 	else{
 		//$obj->actionbreakdown="Add Breakdown";
 		$obj->actioninsurance="Add Insurances";
 		
// 	}
// 	$merge=$breakdowns->fetchObject;

	$employees = new Employees();
	$fields=" concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name ";
	$where=" where id='$obj->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$obj->employeename=$auto->name;
	$obj->scheduleemployeename=$auto->name;
	$obj->fuelemployeename=$auto->name;
	$obj->scheduleemployeeid=$obj->employeeid;
	$obj->fuelemployeeid=$obj->employeeid;
	
	

// 	$obj = (object) array_merge((array) $obj, (array) $merge);
// 	$obj->fleetid=$id;
// 	$obj->id=$id;
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

$obj->inspectedon=date("Y-m-d");
$obj->maintenanceon=date("Y-m-d");
$obj->fueledon=date("Y-m-d");
	
$page_title="Fleets ";
include "addfleets.php";
?>