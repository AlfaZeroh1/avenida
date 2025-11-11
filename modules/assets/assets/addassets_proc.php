<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Assets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/categorys/Categorys_class.php");
require_once("../../assets/fleets/Fleets_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/departments/Departments_class.php");
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../assets/assetconsumables/Assetconsumables_class.php");
require_once("../../assets/consumables/Consumables_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7612";//Edit
}
else{
	$auth->roleid="7610";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../assets/insurances/Insurances_class.php");
//for merged foreign keys
require_once("../../assets/insurers/Insurers_class.php");
require_once("../../assets/inspections/Inspections_class.php");
//for merged foreign keys
require_once("../../assets/inspectionitems/Inspectionitems_class.php");

require_once("../breakdowns/Breakdowns_class.php");
require_once("../maintenanceschedules/Maintenanceschedules_class.php");
require_once("../maintenancetypes/Maintenancetypes_class.php");
require_once("../assets/Assets_class.php");

//Process delete of maintenanceschedules
if(!empty($_GET['maintenanceschedules'])){
	$maintenanceschedules = new Maintenanceschedules();
	$maintenanceschedules->id=$_GET['maintenanceschedules'];
	$maintenanceschedules->delete($maintenanceschedules);
}
require_once("../../assets/maintenances/Maintenances_class.php");
require_once("../../assets/maintenancetypes/Maintenancetypes_class.php");
require_once("../../assets/assets/Assets_class.php");

//Process delete of maintenances
if(!empty($_GET['maintenances'])){
	$maintenances = new Maintenances();
	$maintenances->id=$_GET['maintenances'];
	$maintenances->delete($maintenances);
}
//Process delete of maintenances
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

if(!empty($ob->equip))
  $obj->equip=$ob->equip;
  
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$assets=new Assets();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$assets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assets=$assets->setObject($obj);
		if($assets->add($assets)){

		
		      //adding fleet
		      if($obj->categoryid==1){
			$fleets = new Fleets();
			$fleets->assetid=$assets->id;
			$fleets->plateno=$obj->name;
			$fleets->vin=$obj->name;
			$fleets->employeeid=$obj->employeeid;
			$fleets->departmentid=$obj->departmentid;
			$fleets->setObject($fleets);
			$fleets->add($fleets);
		      }
		      
			$error=SUCCESS;
			redirect("addassets_proc.php?id=".$assets->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$assets=new Assets();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$assets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assets=$assets->setObject($obj);
		if($assets->edit($assets)){

			//updating corresponding general journal account
			$name=$obj->name;
			$obj->name=$name." Fixed Asset ";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$assets->id;
			$obj->acctypeid=7;
			$generaljournalaccounts->setObject($obj);
			$upwhere=" refid='$assets->id' and acctypeid='7' ";
			$generaljournalaccounts->edit($generaljournalaccounts,$upwhere);


			//Make a journal entry

			//retrieve account to debit
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->supplierid' and acctypeid='30'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;

			//retrieve account to credit
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='1' and acctypeid='26'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
			$error=UPDATESUCCESS;
			redirect("addassets_proc.php?id=".$assets->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

//Process adding of maintenanceschedules
if($obj->action=="Add Maintenanceschedule"){
	$maintenanceschedules = new Maintenanceschedules();

	$ob->assetid=$obj->assetid;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->maintenancetypeid=$obj->maintenanceschedulesmaintenancetypeid;
	$ob->assetid=$obj->id;
	$ob->nextinspection=$obj->maintenanceschedulesnextinspection;
	$ob->remarks=$obj->maintenanceschedulesremarks;

	$error=$maintenanceschedules->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$maintenanceschedules->setObject($ob);

		if($maintenanceschedules->add($maintenanceschedules)){
			$obj->maintenanceschedulesmaintenancetypeid="";
			$obj->maintenanceschedulesassetid="";
			$obj->maintenanceschedulesnextinspection="";
			$obj->maintenanceschedulesremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
}


//Process adding of maintenances
if($obj->action=="Add Maintenance"){
	$maintenances = new Maintenances();

	$ob->assetid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->maintenancetypeid=$obj->maintenancesmaintenancetypeid;
	$ob->assetid=$obj->id;
	$ob->maintainedon=$obj->maintenancesmaintainedon;
	$ob->doneby=$obj->maintenancesdoneby;
	$ob->remarks=$obj->maintenancesremarks;

	$error=$maintenances->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$maintenances->setObject($ob);

		if($maintenances->add($maintenances)){
			$obj->maintenancesmaintenancetypeid="";
			$obj->maintenancesassetid="";
			$obj->maintenancesmaintainedon="";
			$obj->maintenancesdoneby="";
			$obj->maintenancesremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
}

// adding breakdowns

// if($obj->action=="Add Breakdown"){
// 	$breakdowns=new Breakdowns();
// 	
// 	$breakdowns->assetid=$obj->id;
// 	$obj->createdby=$_SESSION['userid'];
// 	$obj->createdon=date("Y-m-d H:i:s");
// 	$obj->lasteditedby=$_SESSION['userid'];
// 	$obj->lasteditedon=date("Y-m-d H:i:s");
// 	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
// 	$error=$breakdowns->validate($obj);
// 	if(!empty($error)){
// 		$error=$error;
// 	}
// 	else{
// 		$breakdowns=$breakdowns->setObject($obj);
// 		if($breakdowns->add($breakdowns)){
// 			$error=SUCCESS;
// 			redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
// 		}
// 		else{
// 			$error=FAILURE;
// 		}
// 	}
// }

if($obj->action=="Add Breakdown"){
	$breakdowns = new Breakdowns();

	$ob->assetid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	
	$ob->assetid=$obj->id;
	$ob->description=$obj->description;
	$ob->brokedownon=$obj->brokedownon;
	$ob->reactivatedon=$obj->reactivatedon;
	$ob->cost=$obj->cost;
	$ob->refno=$obj->refno;
	$ob->remarks=$obj->remarks;
	
	$error=$breakdowns->validate($ob);
	
	if(!empty($error)){
		$error=$error;
	}
	else{
		$breakdowns->setObject($ob);

		if($breakdowns->add($breakdowns)){
			$obj->assetid="";
			$obj->description="";
			$obj->brokedownon="";
			$obj->reactivatedon="";
			$obj->cost="";
			$obj->refno="";
			$obj->remarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
}


//Process adding of insurances
if($obj->actioninsurance=="Add Insurance"){
	$insurances = new Insurances();

	$insurances->assetid=$obj->id;
	$insurances->createdby=$_SESSION['userid'];
	$insurances->createdon=date("Y-m-d H:i:s");
	$insurances->lasteditedby=$_SESSION['userid'];
	$insurances->lasteditedon=date("Y-m-d H:i:s");
	$insurances->ipaddress=$_SERVER['REMOTE_ADDR'];

	
	$ob->insurerid=$obj->insurerid;
	$ob->insurcompany=$obj->insurcompany;
	$ob->assetid=$obj->id;
	$ob->insuredon=$obj->insuredon;
	$ob->file=$obj->file;
	$ob->expireson=$obj->expireson;
	$ob->remarks=$obj->remarks;
	
	
	$error=$insurances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}else{
		$insurances->setObject($ob);

		if($insurances->add($insurances)){
			$obj->insurerid="";
			$obj->insurcompany="";
			$obj->assetid="";
			$obj->insuredon="";
			$obj->file="";
			$obj->expireson="";
			$obj->remarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
	}
}




//Process adding of insurances
if($obj->actioninsurance=="Add Insurance"){
	$insurances = new Insurances();

	$insurances->assetid=$obj->id;
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
			redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of insurances
if($obj->actioninsurance=="Update Insurance"){
	$insurances = new Insurances();

	$insurances->assetid=$obj->assetid;
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
			redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}


//Process adding of assetconsumables
if($obj->action=="Add Assetconsumable"){
	$assetconsumables = new Assetconsumables();

	$ob->assetid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->assetid=$obj->assetconsumablesassetid;
	$ob->consumableid=$obj->assetconsumablesconsumableid;
	$ob->serialno=$obj->assetconsumablesserialno;
	$ob->fittedon=$obj->assetconsumablesfittedon;
	$ob->startmileage=$obj->assetconsumablesstartmileage;
	$ob->currentmileage=$obj->assetconsumablescurrentmileage;
	$ob->remarks=$obj->assetconsumablesremarks;

	$error=$assetconsumables->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assetconsumables->setObject($ob);

		if($assetconsumables->add($assetconsumables)){
			$obj->assetconsumablesassetid="";
			$obj->assetconsumablesconsumableid="";
			$obj->assetconsumablesserialno="";
			$obj->assetconsumablesfittedon="";
			$obj->assetconsumablesstartmileage="";
			$obj->assetconsumablescurrentmileage="";
			$obj->assetconsumablesremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
}

//Process adding of inspections
if($obj->actioninspection=="Add Inspection"){
	$inspections = new Inspections();

	$inspections->assetid=$obj->assetid;
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
		if($inspections->add($inspections)){
			$error=SUCCESS;
			redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process updating of inspections
if($obj->actioninspection=="Update Inspection"){
	$inspections = new Inspections();

	$inspections->assetid=$obj->assetid;
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
			redirect("addassets_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
if(empty($obj->action)){

	$categorys= new Categorys();
	$fields="assets_categorys.id, assets_categorys.name, assets_categorys.timemethod, assets_categorys.noofdepr, assets_categorys.endingdate, assets_categorys.periodlength, assets_categorys.computationmethod, assets_categorys.degressivefactor, assets_categorys.firstentry, assets_categorys.ipaddress, assets_categorys.createdby, assets_categorys.createdon, assets_categorys.lasteditedby, assets_categorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$assets=new Assets();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$assets->fetchObject;
	
	
	if($obj->categoryid==1){
	  $fleets=new Fleets();
	  $where=" where assetid=$obj->id ";
	  $fields="*";
	  $join="";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  $fleets = $fleets->fetchObject;
	  
	  redirect("../fleets/addfleets_proc.php?id=".$fleets->id);
	}
	
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

	//for merged tables
// 	$insurances = new Insurances();
// 	$fields=" * ";
// 	$where=" where assetid=$id";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$insurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	if(mysql_affected_rows()>0){
// 		$obj->actioninsurance="Update Insurance";
// 	}
// 	else{
 		$obj->actioninsurance="Add Insurance";
// 	}
// 	$merge=$insurances->fetchObject;
// 
// 	$obj = (object) array_merge((array) $obj, (array) $merge);
// 	//for merged tables
// 	$inspections = new Inspections();
// 	$fields=" * ";
// 	$where=" where assetid=$id";
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
 		$obj->actionbreakdown="Add Breakdown";
// 	}
// 	$merge=$inspections->fetchObject;
// 
// 	$obj = (object) array_merge((array) $obj, (array) $merge);
// 	$obj->assetid=$id;
// 	$obj->id=$id;
// 	//for autocompletes
// 	$suppliers = new Suppliers();
// 	$fields=" * ";
// 	$where=" where id='$obj->supplierid'";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	$auto=$suppliers->fetchObject;
// 
// 	$obj->suppliername=$auto->name;


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
	
	
$page_title="Assets ";
include "addassets.php";
?>