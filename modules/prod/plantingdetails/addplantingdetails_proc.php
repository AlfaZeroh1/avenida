<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plantingdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/plantings/Plantings_class.php");
require_once("../../prod/varietys/Varietys_class.php");
require_once("../../prod/areas/Areas_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8585";//Edit
}
else{
	$auth->roleid="8583";//Add
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
	$plantingdetails=new Plantingdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$plantingdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plantingdetails=$plantingdetails->setObject($obj);
		if($plantingdetails->add($plantingdetails)){
			$error=SUCCESS;
			redirect("addplantingdetails_proc.php?id=".$plantingdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$plantingdetails=new Plantingdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$plantingdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plantingdetails=$plantingdetails->setObject($obj);
		if($plantingdetails->edit($plantingdetails)){
			$error=UPDATESUCCESS;
			redirect("addplantingdetails_proc.php?id=".$plantingdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$plantings= new Plantings();
	$fields="prod_plantings.id, prod_plantings.documentno, prod_plantings.breederdeliveryid, prod_plantings.breederid, prod_plantings.plantedon, prod_plantings.week, prod_plantings.employeeid, prod_plantings.remarks, prod_plantings.ipaddress, prod_plantings.createdby, prod_plantings.createdon, prod_plantings.lasteditedby, prod_plantings.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plantings->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$areas= new Areas();
	$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.blockid, prod_areas.seasonid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$plantingdetails=new Plantingdetails();
	$where=" where id=$id ";
	$fields="prod_plantingdetails.id, prod_plantingdetails.plantingid, prod_plantingdetails.varietyid, prod_plantingdetails.areaid, prod_plantingdetails.quantity, prod_plantingdetails.memo, prod_plantingdetails.ipaddress, prod_plantingdetails.createdby, prod_plantingdetails.createdon, prod_plantingdetails.lasteditedby, prod_plantingdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plantingdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$plantingdetails->fetchObject;

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
	
	
$page_title="Plantingdetails ";
include "addplantingdetails.php";
?>