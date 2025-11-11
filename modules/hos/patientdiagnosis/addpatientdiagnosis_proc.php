<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Patientdiagnosis_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/patients/Patients_class.php");
require_once("../../hos/patienttreatmentss/Patienttreatmentss_class.php");
require_once("../../hos/diagnosis/Diagnosis_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11472";//Edit
}
else{
	$auth->roleid="11472";//Add
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
	$patientdiagnosis=new Patientdiagnosis();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$patientdiagnosis->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientdiagnosis=$patientdiagnosis->setObject($obj);
		if($patientdiagnosis->add($patientdiagnosis)){
			$error=SUCCESS;
			redirect("addpatientdiagnosis_proc.php?id=".$patientdiagnosis->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$patientdiagnosis=new Patientdiagnosis();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$patientdiagnosis->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientdiagnosis=$patientdiagnosis->setObject($obj);
		if($patientdiagnosis->edit($patientdiagnosis)){
			$error=UPDATESUCCESS;
			redirect("addpatientdiagnosis_proc.php?id=".$patientdiagnosis->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$patients= new Patients();
	$fields="hos_patients.id, hos_patients.brancheid, hos_patients.customerid, hos_patients.departmentcategoryid, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.bloodgroup, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.tel, hos_patients.genderid, hos_patients.dob, hos_patients.civilstatusid, hos_patients.remarks, hos_patients.status, hos_patients.ipaddress, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$patienttreatmentss= new Patienttreatmentss();
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patienttreatmentss->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$diagnosis= new Diagnosis();
	$fields="hos_diagnosis.id, hos_diagnosis.name, hos_diagnosis.remarks, hos_diagnosis.ipaddress, hos_diagnosis.createdby, hos_diagnosis.createdon, hos_diagnosis.lasteditedby, hos_diagnosis.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$diagnosis->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$patientdiagnosis=new Patientdiagnosis();
	$where=" where id=$id ";
	$fields="hos_patientdiagnosis.id, hos_patientdiagnosis.documentno, hos_patientdiagnosis.patientid, hos_patientdiagnosis.patienttreatmentid, hos_patientdiagnosis.diagnosiid, hos_patientdiagnosis.remarks, hos_patientdiagnosis.createdby, hos_patientdiagnosis.createdon, hos_patientdiagnosis.lasteditedby, hos_patientdiagnosis.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patientdiagnosis->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientdiagnosis->fetchObject;

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
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='hos_patientdiagnosis' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addpatientdiagnosis.php";
?>