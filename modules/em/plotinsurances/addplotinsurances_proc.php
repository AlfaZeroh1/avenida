<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotinsurances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/plots/Plots_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8121";//Edit
}
else{
	$auth->roleid="8119";//Add
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
	$plotinsurances=new Plotinsurances();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$plotinsurances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotinsurances=$plotinsurances->setObject($obj);
		if($plotinsurances->add($plotinsurances)){
			$error=SUCCESS;
			redirect("addplotinsurances_proc.php?id=".$plotinsurances->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$plotinsurances=new Plotinsurances();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$plotinsurances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotinsurances=$plotinsurances->setObject($obj);
		if($plotinsurances->edit($plotinsurances)){
			$error=UPDATESUCCESS;
			redirect("addplotinsurances_proc.php?id=".$plotinsurances->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$plots= new Plots();
	$fields="em_plots.id, em_plots.code, em_plots.landlordid, em_plots.actionid, em_plots.noofhouses, em_plots.regionid, em_plots.managefrom, em_plots.managefor, em_plots.indefinite, em_plots.typeid, em_plots.commission, em_plots.target, em_plots.name, em_plots.lrno, em_plots.estate, em_plots.road, em_plots.location, em_plots.letarea, em_plots.unusedarea, em_plots.employeeid, em_plots.deposit, em_plots.depositmgtfee, em_plots.depositmgtfeeperc, em_plots.depositmgtfeevatable, em_plots.depositmgtfeevatclasseid, em_plots.mgtfeevatclasseid, em_plots.vatable, em_plots.vatclasseid, em_plots.deductcommission, em_plots.status, em_plots.penaltydate, em_plots.paydate, em_plots.remarks, em_plots.photo, em_plots.longitude, em_plots.latitude, em_plots.ipaddress, em_plots.createdby, em_plots.createdon, em_plots.lasteditedby, em_plots.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$plotinsurances=new Plotinsurances();
	$where=" where id=$id ";
	$fields="em_plotinsurances.id, em_plotinsurances.plotid, em_plotinsurances.company, em_plotinsurances.startdate, em_plotinsurances.expirydate, em_plotinsurances.remarks, em_plotinsurances.ipaddress, em_plotinsurances.createdby, em_plotinsurances.createdon, em_plotinsurances.lasteditedby, em_plotinsurances.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plotinsurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$plotinsurances->fetchObject;

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
	
	
$page_title="Plotinsurances ";
include "addplotinsurances.php";
?>