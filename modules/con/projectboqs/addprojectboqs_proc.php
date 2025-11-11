<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectboqs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../tender/billofquantities/Billofquantities_class.php");
require_once("../../tender/unitofmeasures/Unitofmeasures_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8521";//Edit
}
else{
	$auth->roleid="8519";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->billofquantitieid))
  $obj->billofquantitieid=$ob->billofquantitieid;

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
	$projectboqs=new Projectboqs();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectboqs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectboqs=$projectboqs->setObject($obj);
		if($projectboqs->add($projectboqs)){
			$error=SUCCESS;
			redirect("addprojectboqs_proc.php?id=".$projectboqs->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectboqs=new Projectboqs();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectboqs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectboqs=$projectboqs->setObject($obj);
		if($projectboqs->edit($projectboqs)){
			$error=UPDATESUCCESS;
			redirect("addprojectboqs_proc.php?id=".$projectboqs->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$billofquantities= new Billofquantities();
	$fields="tender_billofquantities.id, tender_billofquantities.tenderid, tender_billofquantities.bqitem, tender_billofquantities.quantity, tender_billofquantities.unitofmeasureid, tender_billofquantities.bqrate, tender_billofquantities.remarks, tender_billofquantities.ipaddress, tender_billofquantities.createdby, tender_billofquantities.createdon, tender_billofquantities.lasteditedby, tender_billofquantities.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$billofquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$unitofmeasures= new Unitofmeasures();
	$fields="tender_unitofmeasures.id, tender_unitofmeasures.name, tender_unitofmeasures.remarks, tender_unitofmeasures.ipaddress, tender_unitofmeasures.createdby, tender_unitofmeasures.createdon, tender_unitofmeasures.lasteditedby, tender_unitofmeasures.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectboqs=new Projectboqs();
	$where=" where id=$id ";
	$fields="con_projectboqs.id, con_projectboqs.billofquantitieid, con_projectboqs.name, con_projectboqs.quantity, con_projectboqs.unitofmeasureid, con_projectboqs.bqrate, con_projectboqs.total, con_projectboqs.remarks, con_projectboqs.ipaddress, con_projectboqs.createdby, con_projectboqs.createdon, con_projectboqs.lasteditedby, con_projectboqs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectboqs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectboqs->fetchObject;

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
	
	
$page_title="Projectboqs ";
include "addprojectboqs.php";
?>