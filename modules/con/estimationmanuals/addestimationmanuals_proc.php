<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Estimationmanuals_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../tender/unitofmeasures/Unitofmeasures_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8513";//Edit
}
else{
	$auth->roleid="8511";//Add
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
	$estimationmanuals=new Estimationmanuals();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$estimationmanuals->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimationmanuals=$estimationmanuals->setObject($obj);
		if($estimationmanuals->add($estimationmanuals)){
			$error=SUCCESS;
			redirect("addestimationmanuals_proc.php?id=".$estimationmanuals->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$estimationmanuals=new Estimationmanuals();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$estimationmanuals->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimationmanuals=$estimationmanuals->setObject($obj);
		if($estimationmanuals->edit($estimationmanuals)){
			$error=UPDATESUCCESS;
			redirect("addestimationmanuals_proc.php?id=".$estimationmanuals->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$unitofmeasures= new Unitofmeasures();
	$fields="tender_unitofmeasures.id, tender_unitofmeasures.name, tender_unitofmeasures.remarks, tender_unitofmeasures.ipaddress, tender_unitofmeasures.createdby, tender_unitofmeasures.createdon, tender_unitofmeasures.lasteditedby, tender_unitofmeasures.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$estimationmanuals=new Estimationmanuals();
	$where=" where id=$id ";
	$fields="con_estimationmanuals.id, con_estimationmanuals.type, con_estimationmanuals.name, con_estimationmanuals.unitofmeasureid, con_estimationmanuals.remarks, con_estimationmanuals.ipaddress, con_estimationmanuals.createdby, con_estimationmanuals.createdon, con_estimationmanuals.lasteditedby, con_estimationmanuals.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$estimationmanuals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$estimationmanuals->fetchObject;

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
	
	
$page_title="Estimationmanuals ";
include "addestimationmanuals.php";
?>