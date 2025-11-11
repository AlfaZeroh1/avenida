<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotspecialdeposits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/plots/Plots_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4319";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="4317";//Add
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
	$plotspecialdeposits=new Plotspecialdeposits();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$plotspecialdeposits->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotspecialdeposits=$plotspecialdeposits->setObject($obj);
		if($plotspecialdeposits->add($plotspecialdeposits)){
			$error=SUCCESS;
			redirect("addplotspecialdeposits_proc.php?id=".$plotspecialdeposits->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$plotspecialdeposits=new Plotspecialdeposits();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$plotspecialdeposits->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotspecialdeposits=$plotspecialdeposits->setObject($obj);
		if($plotspecialdeposits->edit($plotspecialdeposits)){
			$error=UPDATESUCCESS;
			redirect("addplotspecialdeposits_proc.php?id=".$plotspecialdeposits->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$plots= new Plots();
	$fields="em_plots.id, em_plots.code, em_plots.landlordid, em_plots.actionid, em_plots.noofhouses, em_plots.regionid, em_plots.managefrom, em_plots.managefor, em_plots.indefinite, em_plots.typeid, em_plots.commission, em_plots.target, em_plots.name, em_plots.lrno, em_plots.estate, em_plots.road, em_plots.location, em_plots.letarea, em_plots.unusedarea, em_plots.employeeid, em_plots.deposit, em_plots.vatable, em_plots.status, em_plots.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentterms= new Paymentterms();
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.specialdeposit, em_paymentterms.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$plotspecialdeposits=new Plotspecialdeposits();
	$where=" where id=$id ";
	$fields="em_plotspecialdeposits.id, em_plotspecialdeposits.plotid, em_plotspecialdeposits.paymenttermid, em_plotspecialdeposits.amount, em_plotspecialdeposits.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plotspecialdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$plotspecialdeposits->fetchObject;

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
	
	
$page_title="Plotspecialdeposits ";
include "addplotspecialdeposits.php";
?>