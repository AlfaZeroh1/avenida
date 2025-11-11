<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projects_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../crm/customers/Customers_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9045";//Edit
}
else{
	$auth->roleid="9043";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);
require_once("../../pm/projectteams/Projectteams_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../pm/teampositions/Teampositions_class.php");

//Process delete of projectteams
if(!empty($_GET['projectteams'])){
	$projectteams = new Projectteams();
	$projectteams->id=$_GET['projectteams'];
	$projectteams->delete($projectteams);
}
require_once("../../pm/projectdocuments/Projectdocuments_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");

//Process delete of projectdocuments
if(!empty($_GET['projectdocuments'])){
	$projectdocuments = new Projectdocuments();
	$projectdocuments->id=$_GET['projectdocuments'];
	$projectdocuments->delete($projectdocuments);
}
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../hrm/employees/Employees_class.php");

//Process delete of tasks
if(!empty($_GET['tasks'])){
	$tasks = new Tasks();
	$tasks->id=$_GET['tasks'];
	$tasks->delete($tasks);
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

//Process adding of projectteams
if($obj->action=="Add Projectteam"){
	$projectteams = new Projectteams();

	$ob->projectid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->employeeid=$obj->projectteamsemployeeid;
	$ob->teampositionid=$obj->projectteamsteampositionid;
	$ob->remarks=$obj->projectteamsremarks;

	$error=$projectteams->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectteams->setObject($ob);

		if($projectteams->add($projectteams)){
			$obj->projectteamsemployeeid="";
			$obj->projectteamsteampositionid="";
			$obj->projectteamsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addprojects_proc.php?id=".$obj->id."&error=".$error);
}


//Process adding of projectdocuments
if($obj->action=="Add Projectdocument"){
	$projectdocuments = new Projectdocuments();

	$ob->projectid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->documenttypeid=$obj->projectdocumentsdocumenttypeid;

		$file=$_FILES['projectdocumentsfile']['tmp_name'];
		$filename=$_FILES['projectdocumentsfile']['name'];
		$ob->file=$filename;
		copy($file,"files/".$filename);

	$ob->uploadedon=$obj->projectdocumentsuploadedon;
	$ob->type=$obj->projectdocumentstype;
	$ob->remarks=$obj->projectdocumentsremarks;

	$error=$projectdocuments->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectdocuments->setObject($ob);

		if($projectdocuments->add($projectdocuments)){
			$obj->projectdocumentsdocumenttypeid="";
			$obj->projectdocumentsfile="";
			$obj->projectdocumentsuploadedon="";
			$obj->projectdocumentstype="";
			$obj->projectdocumentsremarks="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addprojects_proc.php?id=".$obj->id."&error=".$error);
}


//Process adding of tasks
if($obj->action=="Add Task"){
	$tasks = new Tasks();

	$ob->projectid=$obj->id;
	$ob->createdby=$_SESSION['userid'];
	$ob->createdon=date("Y-m-d H:i:s");
	$ob->lasteditedby=$_SESSION['userid'];
	$ob->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

	$ob->description=$obj->tasksdescription;
	$ob->employeeid=$obj->tasksemployeeid;
	$ob->name=$obj->tasksname;
	$ob->duration=$obj->tasksduration;
	$ob->durationtype=$obj->tasksdurationtype;
	$ob->deadline=$obj->tasksdeadline;

	$error=$tasks->validate($ob);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tasks->setObject($ob);

		if($tasks->add($tasks)){
			$obj->tasksdescription="";
			$obj->tasksemployeeid="";
			$obj->tasksname="";
			$obj->tasksduration="";
			$obj->tasksdurationtype="";
			$obj->tasksdeadline="";
			$error=SUCCESS;
		}else{
			$error=FAILURE;
		}
	}
	redirect("addprojects_proc.php?id=".$obj->id."&error=".$error);
}

if(empty($obj->action)){

	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projects=new Projects();
	$where=" where id=$id ";
	$fields="pm_projects.id, pm_projects.customerid, pm_projects.name, pm_projects.description, pm_projects.startdate, pm_projects.expectedcompletion, pm_projects.actualcompletion, pm_projects.remarks, pm_projects.ipaddress, pm_projects.createdby, pm_projects.createdon, pm_projects.lasteditedby, pm_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projects->fetchObject;

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
	
	
$page_title="Projects ";
include "addprojects.php";
?>