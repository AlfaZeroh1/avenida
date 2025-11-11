<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotpenaltys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/plots/Plots_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4329";//Edit
}
else{
	$auth->roleid="4329";//Add
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
	$plotpenaltys=new Plotpenaltys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$plotpenaltys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotpenaltys=$plotpenaltys->setObject($obj);
		if($plotpenaltys->add($plotpenaltys)){
			$error=SUCCESS;
			redirect("addplotpenaltys_proc.php?id=".$plotpenaltys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$plotpenaltys=new Plotpenaltys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$plotpenaltys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotpenaltys=$plotpenaltys->setObject($obj);
		if($plotpenaltys->edit($plotpenaltys)){
			$error=UPDATESUCCESS;
			redirect("addplotpenaltys_proc.php?id=".$plotpenaltys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$plots= new Plots();
	$fields="em_plots.id, em_plots.code, em_plots.landlordid, em_plots.actionid, em_plots.noofhouses, em_plots.regionid, em_plots.managefrom, em_plots.managefor, em_plots.indefinite, em_plots.typeid, em_plots.commission, em_plots.target, em_plots.name, em_plots.lrno, em_plots.estate, em_plots.road, em_plots.location, em_plots.letarea, em_plots.unusedarea, em_plots.employeeid, em_plots.deposit, em_plots.vatable, em_plots.status, em_plots.penalty, em_plots.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$plotpenaltys=new Plotpenaltys();
	$where=" where id=$id ";
	$fields="em_plotpenaltys.id, em_plotpenaltys.plotid, em_plotpenaltys.month, em_plotpenaltys.year, em_plotpenaltys.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plotpenaltys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$plotpenaltys->fetchObject;

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
	
	
$page_title="Plotpenaltys ";
include "addplotpenaltys.php";
?>