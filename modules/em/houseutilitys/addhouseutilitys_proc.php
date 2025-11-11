<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houseutilitys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../em/houses/Houses_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
require_once("../../em/paymentterms/Paymentterms_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4121";//Edit
}
else{
	$auth->roleid="4119";//Add
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
	$houseutilitys=new Houseutilitys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$houseutilitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houseutilitys=$houseutilitys->setObject($obj);
		if($houseutilitys->add($houseutilitys)){
			$error=SUCCESS;
			redirect("addhouseutilitys_proc.php?id=".$houseutilitys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$houseutilitys=new Houseutilitys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$houseutilitys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$houseutilitys=$houseutilitys->setObject($obj);
		if($houseutilitys->edit($houseutilitys)){
			$error=UPDATESUCCESS;
			redirect("addhouseutilitys_proc.php?id=".$houseutilitys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$houses= new Houses();
	$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.depositmgtfee, em_houses.depositmgtfeevatable, em_houses.depositmgtfeevatclasseid, em_houses.depositmgtfeeperc, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.chargeable, em_houses.penalty, em_houses.remarks, em_houses.ipaddress, em_houses.createdby, em_houses.createdon, em_houses.lasteditedby, em_houses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);


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
	$houseutilitys=new Houseutilitys();
	$where=" where id=$id ";
	$fields="em_houseutilitys.id, em_houseutilitys.houseid, em_houseutilitys.paymenttermid, em_houseutilitys.amount, em_houseutilitys.showinst, em_houseutilitys.mgtfee, em_houseutilitys.mgtfeeperc, em_houseutilitys.vatable, em_houseutilitys.vatclasseid, em_houseutilitys.mgtfeevatable, em_houseutilitys.mgtfeevatclasseid, em_houseutilitys.remarks, em_houseutilitys.ipaddress, em_houseutilitys.createdby, em_houseutilitys.createdon, em_houseutilitys.lasteditedby, em_houseutilitys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$houseutilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$houseutilitys->fetchObject;

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
	
	
$page_title="Houseutilitys ";
include "addhouseutilitys.php";
?>