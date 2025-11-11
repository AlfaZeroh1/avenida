<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Departmentbudgets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/departments/Departments_class.php");
//require_once("../../con/projects/Projects_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8401";//Edit
}
else{
	$auth->roleid="8399";//Add
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
	$departmentbudgets=new Departmentbudgets();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$departmentbudgets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$departmentbudgets=$departmentbudgets->setObject($obj);
		if($departmentbudgets->add($departmentbudgets)){
			$error=SUCCESS;
			redirect("adddepartmentbudgets_proc.php?id=".$departmentbudgets->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$departmentbudgets=new Departmentbudgets();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$departmentbudgets->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$departmentbudgets=$departmentbudgets->setObject($obj);
		if($departmentbudgets->edit($departmentbudgets)){
			$error=UPDATESUCCESS;
			redirect("adddepartmentbudgets_proc.php?id=".$departmentbudgets->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$departments= new Departments();
	$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	//$projects= new Projects();
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	//$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$departmentbudgets=new Departmentbudgets();
	$where=" where id=$id ";
	$fields="fn_departmentbudgets.id, fn_departmentbudgets.departmentid, fn_departmentbudgets.projectid, fn_departmentbudgets.frommonth, fn_departmentbudgets.fromyear, fn_departmentbudgets.tomonth, fn_departmentbudgets.toyear, fn_departmentbudgets.amount, fn_departmentbudgets.remarks, fn_departmentbudgets.ipaddress, fn_departmentbudgets.createdby, fn_departmentbudgets.createdon, fn_departmentbudgets.lasteditedby, fn_departmentbudgets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departmentbudgets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$departmentbudgets->fetchObject;

	//for autocompletes
	$projects = new Projects();
	$fields=" * ";
	$where=" where id='$obj->projectid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$projects->fetchObject;

	$obj->projectname=$auto->name;
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
	
	
$page_title="Departmentbudgets ";
include "adddepartmentbudgets.php";
?>