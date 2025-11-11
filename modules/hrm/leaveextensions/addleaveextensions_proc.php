<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Leaveextensions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employeeleaveapplications/Employeeleaveapplications_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="10592";//Edit
}
else{
	$auth->roleid="10592";//Add
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
$employeeleaveapplicationid=$_GET['employeeleaveapplicationid'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$leaveextensions=new Leaveextensions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$leaveextensions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leaveextensions=$leaveextensions->setObject($obj);
		if($leaveextensions->add($leaveextensions)){
			$error=SUCCESS;
			redirect("addleaveextensions_proc.php?id=".$leaveextensions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$leaveextensions=new Leaveextensions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$leaveextensions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leaveextensions=$leaveextensions->setObject($obj);
		if($leaveextensions->edit($leaveextensions)){
			$error=UPDATESUCCESS;
			redirect("addleaveextensions_proc.php?id=".$leaveextensions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employeeleaveapplications= new Employeeleaveapplications();
	$fields="hrm_employeeleaveapplications.id, hrm_employeeleaveapplications.employeeid, hrm_employeeleaveapplications.leavetypeid, hrm_employeeleaveapplications.startdate, hrm_employeeleaveapplications.duration, hrm_employeeleaveapplications.appliedon, hrm_employeeleaveapplications.status, hrm_employeeleaveapplications.remarks, hrm_employeeleaveapplications.createdby, hrm_employeeleaveapplications.createdon, hrm_employeeleaveapplications.lasteditedby, hrm_employeeleaveapplications.lasteditedon, hrm_employeeleaveapplications.ipaddress, hrm_employeeleaveapplications.type";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeleaveapplications->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$leaveextensions=new Leaveextensions();
	$where=" where hrm_leaveextensions.id=$id ";
	$fields="hrm_leaveextensions.*,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeename,hrm_employees.id as employeeid";
	$join=" left join hrm_employeeleaveapplications on hrm_employeeleaveapplications.id=hrm_leaveextensions.employeeleaveapplicationid join hrm_employees on hrm_employees.id=hrm_employeeleaveapplications.employeeid ";
	$having="";
	$groupby="";
	$orderby="";
	$leaveextensions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$leaveextensions->fetchObject;

	//for autocompletes
}
if(!empty($employeeleaveapplicationid)){
	$employeeleaveapplication=new Employeeleaveapplications();
	$where=" where hrm_employeeleaveapplications.id='$employeeleaveapplicationid' ";
	$fields="hrm_employeeleaveapplications.*,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeename";
	$join=" left join hrm_employees on hrm_employees.id=hrm_employeeleaveapplications.employeeid ";
	$having="";
	$groupby="";
	$orderby="";
	$employeeleaveapplication->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeeleaveapplication->sql;
	$employeeleaveapplication=$employeeleaveapplication->fetchObject;
	$obj->employeeid=$employeeleaveapplication->employeeid;
	$obj->employeeleaveapplicationid=$employeeleaveapplication->id;
	$obj->employeename=$employeeleaveapplication->employeename;

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
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='hrm_leaveextensions' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addleaveextensions.php";
?>