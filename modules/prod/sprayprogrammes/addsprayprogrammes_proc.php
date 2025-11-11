<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sprayprogrammes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../prod/sizes/Sizes_class.php");
require_once("../../prod/sections/Sections_class.php");

require_once("../../prod/chemicals/Chemicals_class.php");
require_once("../../prod/nozzles/Nozzles_class.php");
require_once("../../prod/spraymethods/Spraymethods_class.php");
require_once("../../prod/areas/Areas_class.php");
require_once("../../prod/varietys/Varietys_class.php");
require_once("../../prod/blocks/Blocks_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8721";//Edit
}
else{
	$auth->roleid="8719";//Add
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
	$sprayprogrammes=new Sprayprogrammes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$sprayprogrammes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sprayprogrammes=$sprayprogrammes->setObject($obj);
		if($sprayprogrammes->add($sprayprogrammes)){
			$error=SUCCESS;
			redirect("addsprayprogrammes_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$sprayprogrammes=new Sprayprogrammes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$sprayprogrammes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$sprayprogrammes=$sprayprogrammes->setObject($obj);
		if($sprayprogrammes->edit($sprayprogrammes)){
			$error=UPDATESUCCESS;
			redirect("addsprayprogrammes_proc.php?id=".$sprayprogrammes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$chemicals= new Chemicals();
	$fields="prod_chemicals.id, prod_chemicals.name, prod_chemicals.remarks, prod_chemicals.ipaddress, prod_chemicals.createdby, prod_chemicals.createdon, prod_chemicals.lasteditedby, prod_chemicals.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$chemicals->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$nozzles= new Nozzles();
	$fields="prod_nozzles.id, prod_nozzles.name, prod_nozzles.remarks, prod_nozzles.ipaddress, prod_nozzles.createdby, prod_nozzles.createdon, prod_nozzles.lasteditedby, prod_nozzles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nozzles->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$spraymethods= new Spraymethods();
	$fields="prod_spraymethods.id, prod_spraymethods.name, prod_spraymethods.remarks, prod_spraymethods.ipaddress, prod_spraymethods.createdby, prod_spraymethods.createdon, prod_spraymethods.lasteditedby, prod_spraymethods.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$spraymethods->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$areas= new Areas();
	$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.noofplants, prod_areas.blockid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$blocks= new Blocks();
	$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$sprayprogrammes=new Sprayprogrammes();
	$where=" where id=$id ";
	$fields="prod_sprayprogrammes.id, prod_sprayprogrammes.areaid, prod_sprayprogrammes.varietyid, prod_sprayprogrammes.chemicalid, prod_sprayprogrammes.ingredients, prod_sprayprogrammes.quantity, prod_sprayprogrammes.watervol, prod_sprayprogrammes.blockid, prod_sprayprogrammes.nozzleid, prod_sprayprogrammes.target, prod_sprayprogrammes.spraymethodid, prod_sprayprogrammes.spraydate, prod_sprayprogrammes.time, prod_sprayprogrammes.remarks, prod_sprayprogrammes.ipaddress, prod_sprayprogrammes.createdby, prod_sprayprogrammes.createdon, prod_sprayprogrammes.lasteditedby, prod_sprayprogrammes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sprayprogrammes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$sprayprogrammes->fetchObject;

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
	
	
$page_title="Sprayprogrammes ";
include "addsprayprogrammes.php";
?>