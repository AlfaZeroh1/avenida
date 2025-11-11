<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tenders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../tender/tendertypes/Tendertypes_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../tender/statuss/Statuss_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7745";//Edit
}
else{
	$auth->roleid="7743";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../tender/documents/Documents_class.php");
require_once("../../dms/documentss/Documentss_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");
require_once("../../tender/checklistdocuments/Checklistdocuments_class.php");
require_once("../../sys/config/Config_class.php");
require_once("../../tender/configs/Configs_class.php");
require_once("../../sys/modules/Modules_class.php");
require_once("../../dms/categorys/Categorys_class.php");
require_once("../../dms/departmentcategorys/Departmentcategorys_class.php");
require_once("../../dms/departments/Departments_class.php");

//Process delete of documents
if(!empty($_GET['documents'])){
	$documents = new Documents();
	$documents->id=$_GET['documents'];
	$documents->delete($documents);
}
require_once("../../tender/checklists/Checklists_class.php");
require_once("../../tender/checklistemployees/Checklistemployees_class.php");
require_once("../../tender/checklistcategorys/Checklistcategorys_class.php");

//Process delete of checklists
if(!empty($_GET['checklists'])){
	$checklists = new Checklists();
	$checklists->id=$_GET['checklists'];
	$checklists->delete($checklists);
}

require_once("../../tender/billofquantities/Billofquantities_class.php");
require_once("../../tender/bqitems/Bqitems_class.php");
require_once "../../tender/unitofmeasures/Unitofmeasures_class.php";
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../pm/notifications/Notifications_class.php");
require_once("../../pm/notificationrecipients/Notificationrecipients_class.php");

//Process delete of billofquantities
if(!empty($_GET['billofquantities'])){
	$billofquantities = new Billofquantities();
	$billofquantities->id=$_GET['billofquantities'];
	$billofquantities->delete($billofquantities);
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
	

if($obj->action2=="Awarded"){
	redirect("../../con/projects/addprojects_proc.php?name=".$obj->name."&tenderid=".$obj->id);
}
	
if($obj->action2=="Completed"){
	//update status of tender
	$tenders = new Tenders();
	$fields="*";
	$where=" where id='$obj->id'";
	$having="";
	$groupby="";
	$orderby="";
	$join="";
	$tenders->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo $tenders->sql;
	$tenders=$tenders->fetchObject;
	
	$tenders->statusid=2;
	
	$tend = new Tenders();
	$tend->setObject($tenders);
	$tend->edit($tend);
	
	redirect("addtenders_proc.php?id=".$tenders->id."&error=".$error);
	
}

if($obj->action=="Save"){
	$tenders=new Tenders();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tenders->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tenders=$tenders->setObject($obj);
		if($tenders->add($tenders)){
			$error=SUCCESS;
			
					
			//add configured documents
			$configs = new Configs();
			$fields="tender_configs.name, dms_documentss.*";
			$join=" left join dms_documentss on dms_documentss.id=tender_configs.documentsid ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" ";
			$configs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$configs->result;
			while($rw=mysql_fetch_object($res)){
			
			  $obj=$rw;
			  $obj->id=0;
			  $obj->tenderid=$tenders->id;
			  $obj->file=$obj->document;
			  
			  $documents = new Documents();
			  $documents->setObject($obj);
			  $documents->document=$rw->link."".$rw->document;
			  $documents->add($documents);
			  
			}
			
			redirect("addtenders_proc.php?id=".$tenders->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tenders=new Tenders();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tenders->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tenders=$tenders->setObject($obj);
		if($tenders->edit($tenders)){
			$error=UPDATESUCCESS;
			redirect("addtenders_proc.php?id=".$tenders->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}

//Process adding of documents
if($obj->action=="Add Document"){
	$documents = new Documents();

	$ob->tenderid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$ob->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->documenttypeid=$obj->documentsdocumenttypeid;
	$ob->title=$obj->documentstitle;

		$file=$_FILES['documentsfile']['tmp_name'];
		$filename=$_FILES['documentsfile']['name'];
		

	$ob->remarks=$obj->documentsremarks;

	$error=$documents->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{

		//create a resource folder
			$config = new Config();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where name='DMS_RESOURCE'";
			$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$config=$config->fetchObject;
			
			//get module name
			$module = new Modules();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id=24 ";
			$module->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$module=$module->fetchObject;
			
			$tenders = new Tenders();
			$fields=" tender_tendertypes.name, tender_tenders.proposalno ";
			$join=" left join tender_tendertypes on tender_tendertypes.id=tender_tenders.tendertypeid left join tender_checklists on tender_checklists.tenderid=tender_tenders.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where tender_tenders.id='$obj->id' ";
			$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$tenders=$tenders->fetchObject;
			
			$documenttypes=new Documenttypes();
			$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where dms_documenttypes.id ='$obj->documentsdocumenttypeid' ";
			$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$documenttypes=$documenttypes->fetchObject;
			
			$ext = explode(".",$filename);
			
			$nm=count($ext);
			
			$ob->document=$ob->title.".".$ext[$nm-1];
			
			$ob->file=$file;
			
			$ob->link=$module->name."/documents/".$tenders->name."/".$tenders->proposalno."/".$documenttypes->name;
					
			
			$docs = new Documentss();
			if(empty($ob->routeid))
			  $ob->routeid='NULL';
			if($docs->add($ob)){
			
			$ob->file=$ob->document;
			$documents->setObject($ob);
		if($documents->add($documents)){
			
			$obj->documentsdocumenttypeid="";
			$obj->documentstitle="";
			$obj->documentsfile="";
			$obj->documentsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
		}
		else{
			$error=FAILURE;
		}
	}
	redirect("addtenders_proc.php?id=".$obj->id."&error=".$error."#tabs-2");
}


//Process adding of checklists
if($obj->action=="Add Checklist"){
	$checklists = new Checklists();

	$ob->tenderid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->checklistcategoryid=$obj->checklistschecklistcategoryid;
	$ob->name=$obj->checklistsname;
	$ob->description=$obj->checklistsdescription;
	$ob->deadline=$obj->checklistsdeadline;
	$ob->status=$obj->checklistsstatus;

	$error=$checklists->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checklists->setObject($ob);

		if($checklists->add($checklists)){
			$obj->checklistschecklistcategoryid="";
			$obj->checklistsname="";
			$obj->checklistsdescription="";
			$obj->checklistsdeadline="";
			$obj->checklistsstatus="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addtenders_proc.php?id=".$obj->id."&error=".$error);
}

//Process adding of billofquantities
if($obj->action=="Add Billofquantitie"){
	$billofquantities = new Billofquantities();

	$ob->tenderid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->bqitem=$obj->billofquantitiesbqitem;
	$ob->unitofmeasureid=$obj->billofquantitiesunitofmeasureid;
	$ob->quantity=$obj->billofquantitiesquantity;
	$ob->bqrate=$obj->billofquantitiesbqrate;
	$ob->remarks=$obj->billofquantitiesremarks;

	$error=$billofquantities->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$billofquantities->setObject($ob);

		if($billofquantities->add($billofquantities)){
			$obj->billofquantitiesbqitemid="";
			$obj->billofquantitiesquantity="";
			$obj->billofquantitiesbqrate="";
			$obj->billofquantitiesremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addtenders_proc.php?id=".$obj->id."&error=".$error."#tabs-4");
}

if(empty($obj->action)){

	$tendertypes= new Tendertypes();
	$fields="tender_tendertypes.id, tender_tendertypes.name, tender_tendertypes.description, tender_tendertypes.remarks, tender_tendertypes.ipaddress, tender_tendertypes.createdby, tender_tendertypes.createdon, tender_tendertypes.lasteditedby, tender_tendertypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tendertypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$statuss= new Statuss();
	$fields="tender_statuss.id, tender_statuss.name, tender_statuss.remarks, tender_statuss.ipaddress, tender_statuss.createdby, tender_statuss.createdon, tender_statuss.lasteditedby, tender_statuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$tenders=new Tenders();
	$where=" where id=$id ";
	$fields="tender_tenders.id, tender_tenders.proposalno, tender_tenders.name, tender_tenders.tendertypeid, tender_tenders.datereceived, tender_tenders.actionplandate, tender_tenders.dateofreview, tender_tenders.dateofsubmission, tender_tenders.employeeid, tender_tenders.statusid, tender_tenders.remarks, tender_tenders.ipaddress, tender_tenders.createdby, tender_tenders.createdon, tender_tenders.lasteditedby, tender_tenders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tenders->fetchObject;

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
		$obj->statusid=1;
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Tenders ";
include "addtenders.php";
?>