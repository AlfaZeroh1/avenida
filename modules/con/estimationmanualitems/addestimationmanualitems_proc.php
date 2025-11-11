<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Estimationmanualitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../con/labours/Labours_class.php");
require_once("../../con/estimationmanuals/Estimationmanuals_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8525";//Edit
}
else{
	$auth->roleid="8523";//Add
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
	$estimationmanualitems=new Estimationmanualitems();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$estimationmanualitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimationmanualitems=$estimationmanualitems->setObject($obj);
		if($estimationmanualitems->add($estimationmanualitems)){
			$error=SUCCESS;
			redirect("addestimationmanualitems_proc.php?id=".$estimationmanualitems->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$estimationmanualitems=new Estimationmanualitems();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$estimationmanualitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimationmanualitems=$estimationmanualitems->setObject($obj);
		if($estimationmanualitems->edit($estimationmanualitems)){
			$error=UPDATESUCCESS;
			redirect("addestimationmanualitems_proc.php?id=".$estimationmanualitems->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$labours= new Labours();
	$fields="con_labours.id, con_labours.name, con_labours.rate, con_labours.remarks, con_labours.ipaddress, con_labours.createdby, con_labours.createdon, con_labours.lasteditedby, con_labours.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$labours->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$estimationmanuals= new Estimationmanuals();
	$fields="con_estimationmanuals.id, con_estimationmanuals.type, con_estimationmanuals.name, con_estimationmanuals.unitofmeasureid, con_estimationmanuals.remarks, con_estimationmanuals.ipaddress, con_estimationmanuals.createdby, con_estimationmanuals.createdon, con_estimationmanuals.lasteditedby, con_estimationmanuals.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$estimationmanuals->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$estimationmanualitems=new Estimationmanualitems();
	$where=" where id=$id ";
	$fields="con_estimationmanualitems.id, con_estimationmanualitems.estimationmanualid, con_estimationmanualitems.itemid, con_estimationmanualitems.labourid, con_estimationmanualitems.quantity, con_estimationmanualitems.rate, con_estimationmanualitems.total, con_estimationmanualitems.remarks, con_estimationmanualitems.ipaddress, con_estimationmanualitems.createdby, con_estimationmanualitems.createdon, con_estimationmanualitems.lasteditedby, con_estimationmanualitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$estimationmanualitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$estimationmanualitems->fetchObject;

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
	
	
$page_title="Estimationmanualitems ";
include "addestimationmanualitems.php";
?>