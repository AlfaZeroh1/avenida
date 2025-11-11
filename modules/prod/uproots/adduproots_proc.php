<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Uproots_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/plantingdetails/Plantingdetails_class.php");
require_once("../../prod/areas/Areas_class.php");
require_once("../../prod/varietys/Varietys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8613";//Edit
}
else{
	$auth->roleid="8611";//Add
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
	$uproots=new Uproots();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$uproots->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$uproots=$uproots->setObject($obj);
		if($uproots->add($uproots)){
			$error=SUCCESS;
			redirect("adduproots_proc.php?id=".$uproots->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$uproots=new Uproots();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$uproots->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$uproots=$uproots->setObject($obj);
		if($uproots->edit($uproots)){
			$error=UPDATESUCCESS;
			redirect("adduproots_proc.php?id=".$uproots->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$plantingdetails= new Plantingdetails();
	$fields="prod_plantingdetails.id, prod_plantingdetails.plantingid, prod_plantingdetails.varietyid, prod_plantingdetails.areaid, prod_plantingdetails.quantity, prod_plantingdetails.memo, prod_plantingdetails.ipaddress, prod_plantingdetails.createdby, prod_plantingdetails.createdon, prod_plantingdetails.lasteditedby, prod_plantingdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plantingdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$areas= new Areas();
	$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.blockid, prod_areas.seasonid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$uproots=new Uproots();
	$where=" where id=$id ";
	$fields="prod_uproots.id, prod_uproots.plantingdetailid, prod_uproots.areaid, prod_uproots.varietyid, prod_uproots.quantity, prod_uproots.reportedon,prod_uproots.uprootedon, prod_uproots.remarks, prod_uproots.ipaddress, prod_uproots.createdby, prod_uproots.createdon, prod_uproots.lasteditedby, prod_uproots.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$uproots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$uproots->fetchObject;

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
	
	
$page_title="Uproots ";
include "adduproots.php";
?>