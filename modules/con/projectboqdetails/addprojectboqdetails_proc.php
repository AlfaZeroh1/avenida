<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectboqdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projectboqs/Projectboqs_class.php");
require_once("../../con/labours/Labours_class.php");
require_once("../../inv/items/Items_class.php");
require_once("../../con/projects/Projects_class.php");
require_once("../../con/projectquantities/Projectquantities_class.php");
require_once("../../con/estimationmanuals/Estimationmanuals_class.php");
require_once("../../con/estimationmanualitems/Estimationmanualitems_class.php");
require_once("../../tender/unitofmeasures/Unitofmeasures_class.php");
require_once("../../con/materialcategorys/Materialcategorys_class.php");
require_once("../../con/materialsubcategorys/Materialsubcategorys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8517";//Edit
}
else{
	$auth->roleid="8515";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->projectid)){
  $obj->projectid=$ob->projectid;
}

if(!empty($ob->projectboqid))
  $obj->projectboqid=$ob->projectboqid;

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
	$projectboqdetails=new Projectboqdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectboqdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectboqdetails=$projectboqdetails->setObject($obj);
		if($projectboqdetails->add($projectboqdetails)){
			$error=SUCCESS;
			redirect("addprojectboqdetails_proc.php?id=".$projectboqdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectboqdetails=new Projectboqdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectboqdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectboqdetails=$projectboqdetails->setObject($obj);
		if($projectboqdetails->edit($projectboqdetails)){
			$error=UPDATESUCCESS;
			redirect("addprojectboqdetails_proc.php?id=".$projectboqdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$projectboqs= new Projectboqs();
	$fields="con_projectboqs.id, con_projectboqs.billofquantitieid, con_projectboqs.name, con_projectboqs.quantity, con_projectboqs.unitofmeasureid, con_projectboqs.bqrate, con_projectboqs.total, con_projectboqs.remarks, con_projectboqs.ipaddress, con_projectboqs.createdby, con_projectboqs.createdon, con_projectboqs.lasteditedby, con_projectboqs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectboqs->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$estimationmanuals= new Estimationmanuals();
	$fields="con_estimationmanuals.id, con_estimationmanuals.type, con_estimationmanuals.name, con_estimationmanuals.unitofmeasureid, con_estimationmanuals.rate, con_estimationmanuals.remarks, con_estimationmanuals.ipaddress, con_estimationmanuals.createdby, con_estimationmanuals.createdon, con_estimationmanuals.lasteditedby, con_estimationmanuals.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$estimationmanuals->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$unitofmeasures= new Unitofmeasures();
	$fields="tender_unitofmeasures.id, tender_unitofmeasures.name, tender_unitofmeasures.remarks, tender_unitofmeasures.ipaddress, tender_unitofmeasures.createdby, tender_unitofmeasures.createdon, tender_unitofmeasures.lasteditedby, tender_unitofmeasures.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$materialcategorys= new Materialcategorys();
	$fields="con_materialcategorys.id, con_materialcategorys.name, con_materialcategorys.remarks, con_materialcategorys.ipaddress, con_materialcategorys.createdby, con_materialcategorys.createdon, con_materialcategorys.lasteditedby, con_materialcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$materialcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$materialsubcategorys= new Materialsubcategorys();
	$fields="con_materialsubcategorys.id, con_materialsubcategorys.name, con_materialsubcategorys.categoryid, con_materialsubcategorys.remarks, con_materialsubcategorys.ipaddress, con_materialsubcategorys.createdby, con_materialsubcategorys.createdon, con_materialsubcategorys.lasteditedby, con_materialsubcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$materialsubcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectboqdetails=new Projectboqdetails();
	$where=" where id=$id ";
	$fields="con_projectboqdetails.id, con_projectboqdetails.projectboqid, con_projectboqdetails.materialcategoryid, con_projectboqdetails.materialsubcategoryid, con_projectboqdetails.estimationmanualid, con_projectboqdetails.unitofmeasureid, con_projectboqdetails.quantity, con_projectboqdetails.rate, con_projectboqdetails.total, con_projectboqdetails.remarks, con_projectboqdetails.ipaddress, con_projectboqdetails.createdby, con_projectboqdetails.createdon, con_projectboqdetails.lasteditedby, con_projectboqdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectboqdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectboqdetails->fetchObject;

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
	
	
$page_title="Projectboqdetails ";
include "addprojectboqdetails.php";
?>