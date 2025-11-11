<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projects_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projecttypes/Projecttypes_class.php");
require_once("../../crm/customers/Customers_class.php");
require_once("../../sys/regions/Regions_class.php");
require_once("../../sys/subregions/Subregions_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../con/statuss/Statuss_class.php");
require_once("../../tender/tenders/Tenders_class.php");
require_once("../../tender/billofquantities/Billofquantities_class.php");
require_once("../../con/materialcategorys/Materialcategorys_class.php");
require_once("../../con/materialsubcategorys/Materialsubcategorys_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");
require_once("../../pm/taskstatuss/Taskstatuss_class.php");
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../con/equipments/Equipments_class.php");
require_once("../../con/projectequipments/Projectequipments_class.php");
require_once("../../con/projectboqs/Projectboqs_class.php");
require_once("../../con/projectboqdetails/Projectboqdetails_class.php");
require_once("../../con/projectworkschedules/Projectworkschedules_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7580";//Edit
}
else{
	$auth->roleid="7578";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../con/projectquantities/Projectquantities_class.php");
require_once("../../con/projectdocuments/Projectdocuments_class.php");
//for merged foreign keys
require_once("../../inv/items/Items_class.php");
require_once("../../con/projectusage/Projectusage_class.php");
//for merged foreign keys
require_once("../../inv/items/Items_class.php");
require_once("../../con/projectreviews/Projectreviews_class.php");
//for merged foreign keys
require_once("../../hrm/employees/Employees_class.php");

require_once("../../con/projectsubcontractors/Projectsubcontractors_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");

//Process delete of projectsubcontractors
if(!empty($_GET['projectsubcontractors'])){
	$projectsubcontractors = new Projectsubcontractors();
	$projectsubcontractors->id=$_GET['projectsubcontractors'];
	$projectsubcontractors->delete($projectsubcontractors);
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

if(!empty($ob->tender)){

  $prj = new Projects();
  $fields="*";
  $join="";
  $where=" where tenderid='$ob->tender' ";
  $having="";
  $orderby="";
  $groupby="";
  $prj->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $prj=$prj->fetchObject;
  
  $id=$prj->id;

}
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
if(!empty($ob->tenderid)){
	$obj=$ob;
}

	
if($obj->action=="Save"){
	$projects=new Projects();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projects->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projects=$projects->setObject($obj);
		if($projects->add($projects)){
			
			//update status of tender
			$tenders = new Tenders();
			$fields="*";
			$where=" where id='$projects->tenderid'";
			$having="";
			$groupby="";
			$orderby="";
			$join="";
			$tenders->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$tenders=$tenders->fetchObject;
			
			$tenders->statusid=5;
			
			$tend = new Tenders();
			$tenders = $tend->setObject($tenders);
			$tend->edit($tenders);
			
			
			$error=SUCCESS;
			redirect("addprojects_proc.php?id=".$projects->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projects=new Projects();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projects->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projects=$projects->setObject($obj);
		if($projects->edit($projects)){
			$error=UPDATESUCCESS;
			redirect("addprojects_proc.php?id=".$projects->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

//Process adding of projectquantities
if($obj->actionprojectquantitie=="Add Projectquantitie"){
	$projectquantities = new Projectquantities();

	$projectquantities->projectid=$obj->id;
	$projectquantities->createdby=$_SESSION['userid'];
	$projectquantities->createdon=date("Y-m-d H:i:s");
	$projectquantities->lasteditedby=$_SESSION['userid'];
	$projectquantities->lasteditedon=date("Y-m-d H:i:s");
	$projectquantities->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$projectquantities->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectquantities=$projectquantities->setObject($obj);
		if($projectquantities->add($projectquantities)){
			$error=SUCCESS;
			redirect("addprojects_proc.php?id=".$obj->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process adding of work schedules
if($obj->actiontask=="Add Task"){
	$tasks = new Tasks();

	$tasks->projectid=$obj->id;
	$tasks->createdby=$_SESSION['userid'];
	$tasks->createdon=date("Y-m-d H:i:s");
	$tasks->lasteditedby=$_SESSION['userid'];
	$tasks->lasteditedon=date("Y-m-d H:i:s");
	$tasks->ipaddress=$_SERVER['REMOTE_ADDR'];

	$error=$tasks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tasks=$tasks->setObject($obj);
		if($tasks->add($tasks)){
			$error=SUCCESS;
			redirect("addprojects_proc.php?id=".$obj->id."&error=".$error."#tabs-7");
		}
		else{
			$error=FAILURE;
		}
	}
}

//Process adding of projectsubcontractors
if($obj->action=="Add Projectsubcontractor"){
	$projectsubcontractors = new Projectsubcontractors();

	$ob->projectid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$ob->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->projectid=$obj->projectid;
	$ob->supplierid=$obj->projectsubcontractorssupplierid;
	$ob->liabilityperiod=$obj->projectsubcontractorsliabilityperiod;
	$ob->liabilityperiodtype=$obj->projectsubcontractorsliabilityperiodtype;
	$ob->actualenddate=$obj->projectsubcontractorsactualenddate;
	$ob->expectedenddate=$obj->projectsubcontractorsexpectedenddate;
	$ob->startdate=$obj->projectsubcontractorsstartdate;
	$ob->orderdatetocommence=$obj->projectsubcontractorsorderdatetocommence;
	$ob->contractsignedon=$obj->projectsubcontractorscontractsignedon;
	$ob->acceptanceletterdate=$obj->projectsubcontractorsacceptanceletterdate;
	$ob->dateawarded=$obj->projectsubcontractorsdateawarded;
	$ob->value=$obj->projectsubcontractorsvalue;
	$ob->scope=$obj->projectsubcontractorsscope;
	$ob->physicaladdress=$obj->projectsubcontractorsphysicaladdress;
	$ob->contractno=$obj->projectsubcontractorscontractno;
	$ob->remarks=$obj->projectsubcontractorsremarks;
	$ob->statusid=1;

	$error=$projectsubcontractors->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectsubcontractors->setObject($ob);

		if($projectsubcontractors->add($projectsubcontractors)){
			$obj->projectsubcontractorssupplierid="";
			$obj->projectsubcontractorsliabilityperiod="";
			$obj->projectsubcontractorsliabilityperiodtype="";
			$obj->projectsubcontractorsactualenddate="";
			$obj->projectsubcontractorsexpectedenddate="";
			$obj->projectsubcontractorsstartdate="";
			$obj->projectsubcontractorsorderdatetocommence="";
			$obj->projectsubcontractorscontractsignedon="";
			$obj->projectsubcontractorsacceptanceletterdate="";
			$obj->projectsubcontractorsdateawarded="";
			$obj->projectsubcontractorsvalue="";
			$obj->projectsubcontractorsscope="";
			$obj->projectsubcontractorsphysicaladdress="";
			$obj->projectsubcontractorscontractno="";
			$obj->projectsubcontractorsprojectid="";
			$obj->projectsubcontractorsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addprojects_proc.php?id=".$obj->projectid."&error=".$error);
}

//Process adding of projectquantities
if($obj->action=="Add Projectquantitie"){
	$projectquantities = new Projectquantities();

	$ob->projectid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->billofquantitieid=$obj->projectquantitiesbillofquantitieid;
	$ob->itemid=$obj->projectquantitiesitemid;
	$ob->categoryid=$obj->projectquantitiescategoryid;
	$ob->subcategoryid=$obj->projectquantitiessubcategoryid;
	$ob->quantity=$obj->projectquantitiesquantity;
	$ob->remarks=$obj->projectquantitiesremarks;
	$ob->rate=$obj->projectquantitiesrate;
	$ob->month=$obj->projectquantitiesmonth;
	$ob->year=$obj->projectquantitiesyear;

	$error=$projectquantities->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectquantities->setObject($ob);

		if($projectquantities->add($projectquantities)){
			$obj->projectquantitiesbillofquantitieid="";
			$obj->projectquantitiesitemid="";
			$obj->projectquantitiescategoryid="";
			$obj->projectquantitiessubcategoryid="";
			$obj->projectquantitiesquantity="";
			$obj->projectquantitiesremarks="";
			$obj->projectquantitiesrate="";
			$obj->projectquantitiesmonth="";
			$obj->projectquantitiesyear="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addprojects_proc.php?id=".$obj->id."&error=".$error);
}


//Process adding of projectusage
if($obj->action=="Add Projectusag"){
	$projectusage = new Projectusage();

	$ob->projectid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->itemid=$obj->projectusageitemid;
	$ob->quantity=$obj->projectusagequantity;
	$ob->usedon=$obj->projectusageusedon;
	$ob->remarks=$obj->projectusageremarks;

	$error=$projectusage->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectusage->setObject($ob);

		if($projectusage->add($projectusage)){
			$obj->projectusageitemid="";
			$obj->projectusagequantity="";
			$obj->projectusageusedon="";
			$obj->projectusageremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addprojects_proc.php?id=".$obj->id."&error=".$error);
}


//Process adding of projectreviews
if($obj->action=="Add Projectreview"){
	$projectreviews = new Projectreviews();

	$ob->projectid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->employeeid=$obj->projectreviewsemployeeid;
	$ob->findings=$obj->projectreviewsfindings;
	$ob->recommendations=$obj->projectreviewsrecommendations;
	$ob->reviewedon=$obj->projectreviewsreviewedon;
	$ob->remarks=$obj->projectreviewsremarks;

	$error=$projectreviews->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectreviews->setObject($ob);

		if($projectreviews->add($projectreviews)){
			$obj->projectreviewsemployeeid="";
			$obj->projectreviewsfindings="";
			$obj->projectreviewsrecommendations="";
			$obj->projectreviewsreviewedon="";
			$obj->projectreviewsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addprojects_proc.php?id=".$obj->id."&error=".$error);
}

if(empty($obj->action)){

	$projecttypes= new Projecttypes();
	$fields="con_projecttypes.id, con_projecttypes.name, con_projecttypes.remarks, con_projecttypes.ipaddress, con_projecttypes.createdby, con_projecttypes.createdon, con_projecttypes.lasteditedby, con_projecttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$projecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$statuss= new Statuss();
	$fields="con_statuss.id, con_statuss.name, con_statuss.remarks, con_statuss.ipaddress, con_statuss.createdby, con_statuss.createdon, con_statuss.lasteditedby, con_statuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$regions= new Regions();
	$fields="sys_regions.id, sys_regions.name, sys_regions.remarks, sys_regions.ipaddress, sys_regions.createdby, sys_regions.createdon, sys_regions.lasteditedby, sys_regions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$regions->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$subregions= new Subregions();
	$fields="sys_subregions.id, sys_subregions.name, sys_subregions.regionid, sys_subregions.remarks, sys_subregions.ipaddress, sys_subregions.createdby, sys_subregions.createdon, sys_subregions.lasteditedby, sys_subregions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$subregions->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$tenders= new Tenders();
	$fields="tender_tenders.id, tender_tenders.proposalno, tender_tenders.name, tender_tenders.tendertypeid, tender_tenders.datereceived, tender_tenders.actionplandate, tender_tenders.dateofreview, tender_tenders.dateofsubmission, tender_tenders.employeeid, tender_tenders.Statusid, tender_tenders.remarks, tender_tenders.ipaddress, tender_tenders.createdby, tender_tenders.createdon, tender_tenders.lasteditedby, tender_tenders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$where="";
	$orderby="";
	$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projects=new Projects();
	$where=" where id=$id ";
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projects->fetchObject;
	
	$obj->projectid=$obj->id;

	//for autocompletes
	$customers = new Customers();
	$fields=" * ";
	$where=" where id='$obj->customerid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$customers->fetchObject;

	$obj->customername=$auto->name;
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
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Projects ";
include "addprojects.php";
?>