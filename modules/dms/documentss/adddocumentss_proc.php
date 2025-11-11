<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documentss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../dms/documenttypes/Documenttypes_class.php");
require_once("../../wf/routes/Routes_class.php");
require_once("../../dms/departments/Departments_class.php");
require_once("../../dms/categorys/Categorys_class.php");
require_once("../../dms/departmentcategorys/Departmentcategorys_class.php");
require_once '../../sys/config/Config_class.php';
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8161";//Edit
}
else{
	$auth->roleid="8159";//Add
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
	
	
if($obj->action=="Save"){
	$documentss=new Documentss();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$documentss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$obj->document=$obj->documentno.$obj->title."_".$obj->expirydate;
		
		$documentss=$documentss->setObject($obj);
		$file=$_FILES['document']['tmp_name'];
		$filename=$_FILES['document']['name'];
		
		if($documentss->add($documentss,$file,$filename)){
			$error=SUCCESS;					
			
			redirect("adddocumentss_proc.php?id=".$documentss->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$documentss=new Documentss();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$documentss->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$documentss=$documentss->setObject($obj);
		if($documentss->edit($documentss)){
			$error=UPDATESUCCESS;
			redirect("adddocumentss_proc.php?id=".$documentss->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$documenttypes= new Documenttypes();
	$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$routes= new Routes();
	$fields="wf_routes.id, wf_routes.name, wf_routes.moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$departments= new Departments();
	$fields="dms_departments.id, dms_departments.name, dms_departments.remarks, dms_departments.ipaddress, dms_departments.createdby, dms_departments.createdon, dms_departments.lasteditedby, dms_departments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$categorys= new Categorys();
	$fields="dms_categorys.id, dms_categorys.name, dms_categorys.remarks, dms_categorys.ipaddress, dms_categorys.createdby, dms_categorys.createdon, dms_categorys.lasteditedby, dms_categorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$departments= new Departments();
	$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$documentss=new Documentss();
	$where=" where id=$id ";
	$fields="dms_documentss.id, dms_documentss.routeid, dms_documentss.documentno, dms_documentss.documenttypeid, dms_documentss.departmentid, dms_documentss.departmentcategoryid, dms_documentss.categoryid, dms_documentss.hrmdepartmentid, dms_documentss.document, dms_documentss.link, dms_documentss.status, dms_documentss.expirydate, dms_documentss.description, dms_documentss.remarks, dms_documentss.ipaddress, dms_documentss.createdby, dms_documentss.createdon, dms_documentss.lasteditedby, dms_documentss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documentss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$documentss->fetchObject;

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
	
	
$page_title="Documentss ";
include "adddocumentss.php";
?>