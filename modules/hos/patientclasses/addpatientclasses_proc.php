<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientclasses_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4411";//Edit
}
else{
	$auth->roleid="4411";//Add
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
	$patientclasses=new Patientclasses();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$patientclasses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientclasses=$patientclasses->setObject($obj);
		if($patientclasses->add($patientclasses)){
			$obj->name=$obj->name." - Patient class";
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$patientclasses->id;
			$obj->acctypeid=31;
			$obj->categoryid="";
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
		        
			$error=SUCCESS;
			redirect("addpatientclasses_proc.php?id=".$patientclasses->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$patientclasses=new Patientclasses();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$patientclasses->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientclasses=$patientclasses->setObject($obj);
		if($patientclasses->edit($patientclasses)){
			$error=UPDATESUCCESS;
			redirect("addpatientclasses_proc.php?id=".$patientclasses->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$patientclasses=new Patientclasses();
	$where=" where id=$id ";
	$fields="hos_patientclasses.id, hos_patientclasses.name, hos_patientclasses.fee, hos_patientclasses.remarks, hos_patientclasses.createdby, hos_patientclasses.createdon, hos_patientclasses.lasteditedby, hos_patientclasses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patientclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientclasses->fetchObject;

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
	
	
$page_title="Patientclasses ";
include "addpatientclasses.php";
?>