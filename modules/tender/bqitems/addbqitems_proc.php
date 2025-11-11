<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bqitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../tender/unitofmeasures/Unitofmeasures_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7785";//Edit
}
else{
	$auth->roleid="7783";//Add
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
	$bqitems=new Bqitems();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$bqitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$bqitems=$bqitems->setObject($obj);
		if($bqitems->add($bqitems)){
			$error=SUCCESS;
			redirect("addbqitems_proc.php?id=".$bqitems->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$bqitems=new Bqitems();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$bqitems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$bqitems=$bqitems->setObject($obj);
		if($bqitems->edit($bqitems)){
			$error=UPDATESUCCESS;
			redirect("addbqitems_proc.php?id=".$bqitems->id."&error=".$error);
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
	$bqitems=new Bqitems();
	$where=" where id=$id ";
	$fields="tender_bqitems.id, tender_bqitems.name, tender_bqitems.unitofmeasureid, tender_bqitems.bqrate, tender_bqitems.actualrate, tender_bqitems.remarks, tender_bqitems.ipaddress, tender_bqitems.createdby, tender_bqitems.createdon, tender_bqitems.lasteditedby, tender_bqitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$bqitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$bqitems->fetchObject;

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
	
	
$page_title="Bqitems ";
include "addbqitems.php";
?>