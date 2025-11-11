<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Leaves_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/allowances/Allowances_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4243";//Edit
}
else{
	$auth->roleid="4241";//Add
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
	$leaves=new Leaves();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$leaves->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leaves=$leaves->setObject($obj);
		if($leaves->add($leaves)){
			$error=SUCCESS;
			redirect("addleaves_proc.php?id=".$leaves->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$leaves=new Leaves();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$leaves->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leaves=$leaves->setObject($obj);
		if($leaves->edit($leaves)){
			$error=UPDATESUCCESS;
			redirect("addleaves_proc.php?id=".$leaves->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$allowances= new Allowances();
	$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowances.allowancetypeid, hrm_allowances.expenseid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon, hrm_allowances.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$leaves=new Leaves();
	$where=" where id=$id ";
	$fields="hrm_leaves.id, hrm_leaves.name, hrm_leaves.days, hrm_leaves.remarks, hrm_leaves.createdby, hrm_leaves.createdon, hrm_leaves.lasteditedby, hrm_leaves.lasteditedon, hrm_leaves.ipaddress, hrm_leaves.allowanceid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$leaves->fetchObject;

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
	
	
$page_title="Leaves ";
include "addleaves.php";
?>