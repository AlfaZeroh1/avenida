<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotutilitys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/plots/Plots_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4141";//Edit
}
else{
	$auth->roleid="4139";//Add
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
	$plotutilitys=new Plotutilitys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$plotutilitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotutilitys=$plotutilitys->setObject($obj);
		if($plotutilitys->add($plotutilitys)){
			$error=SUCCESS;
			redirect("addplotutilitys_proc.php?id=".$plotutilitys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$plotutilitys=new Plotutilitys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$plotutilitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$plotutilitys=$plotutilitys->setObject($obj);
		if($plotutilitys->edit($plotutilitys)){
			$error=UPDATESUCCESS;
			redirect("addplotutilitys_proc.php?id=".$plotutilitys->id."&error=".$error);
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


	$vatclasses= new Vatclasses();
	$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$paymentterms= new Paymentterms();
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.remarks, em_paymentterms.ipaddress, em_paymentterms.createdby, em_paymentterms.createdon, em_paymentterms.lasteditedby, em_paymentterms.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$plotutilitys=new Plotutilitys();
	$where=" where id=$id ";
	$fields="em_plotutilitys.id, em_plotutilitys.plotid, em_plotutilitys.paymenttermid, em_plotutilitys.amount, em_plotutilitys.showinst, em_plotutilitys.mgtfee, em_plotutilitys.mgtfeeperc, em_plotutilitys.vatable, em_plotutilitys.vatclasseid, em_plotutilitys.mgtfeevatable, em_plotutilitys.mgtfeevatclasseid, em_plotutilitys.ipaddress, em_plotutilitys.createdby, em_plotutilitys.createdon, em_plotutilitys.lasteditedby, em_plotutilitys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plotutilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$plotutilitys->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->mgtfee="No";
	$obj->vatable="No";
	$obj->mgtfeevatable="No";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Plotutilitys ";
include "addplotutilitys.php";
?>