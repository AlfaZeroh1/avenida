<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientfoods_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/meals/Meals_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4511";//Edit
}
else{
	$auth->roleid="4511";//Add
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
	
	
if($obj->action=="Save"){
	$patientfoods=new Patientfoods();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$patientfoods->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientfoods=$patientfoods->setObject($obj);
		if($patientfoods->add($patientfoods)){
			$error=SUCCESS;
			redirect("addpatientfoods_proc.php?id=".$patientfoods->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$patientfoods=new Patientfoods();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$patientfoods->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientfoods=$patientfoods->setObject($obj);
		if($patientfoods->edit($patientfoods)){
			$error=UPDATESUCCESS;
			redirect("addpatientfoods_proc.php?id=".$patientfoods->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$meals= new Meals();
	$fields="hos_meals.id, hos_meals.name, hos_meals.remarks, hos_meals.createdby, hos_meals.createdon, hos_meals.lasteditedby, hos_meals.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$meals->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$patientfoods=new Patientfoods();
	$where=" where id=$id ";
	$fields="hos_patientfoods.id, hos_patientfoods.foodid, hos_patientfoods.patientid, hos_patientfoods.price, hos_patientfoods.servedon, hos_patientfoods.mealid, hos_patientfoods.createdby, hos_patientfoods.createdon, hos_patientfoods.lasteditedby, hos_patientfoods.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patientfoods->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientfoods->fetchObject;

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
	
	
$page_title="Patientfoods ";
include "addpatientfoods.php";
?>