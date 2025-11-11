<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Observations_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../hos/patients/Patients_class.php");
require_once("../../hos/patienttreatments/Patienttreatments_class.php");


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$observations=new Observations();
	$where=" where id=$id ";
	$fields="hos_observations.id, hos_observations.patientid, hos_observations.patienttreatmentid, hos_observations.observation, hos_observations.createdby, hos_observations.createdon, hos_observations.lasteditedby, hos_observations.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
	$observations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$observations->fetchObject;
}
	
if($obj->action=="Save"){
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$observations=new Observations();
		$observations=setObject($obj);
		if($observations->add($observations)){
			$error=SUCCESS;
			redirect("addobservations_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d");
	$error=validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$observations=new Observations();
		$observations=setObject($obj);
		if($observations->edit($observations)){
			$obj="";
			$error=UPDATESUCCESS;
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$patients= new Patients();
	$fields="hos_patients.id, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.genderid, hos_patients.dob, hos_patients.age, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$patienttreatments= new Patienttreatments();
	$fields="hos_patienttreatments.id, hos_patienttreatments.patientid, hos_patienttreatments.patientappointmentid, hos_patienttreatments.observation, hos_patienttreatments.symptoms, hos_patienttreatments.diagnosis, hos_patienttreatments.treatedon, hos_patienttreatments.patientstatusid, hos_patienttreatments.createdby, hos_patienttreatments.createdon, hos_patienttreatments.lasteditedby, hos_patienttreatments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	if(empty($obj->patientid)){
		$error="patientid should be provided";
	}
	else if(empty($obj->patienttreatmentid)){
		$error="patienttreatmentid should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$observations= new Observations();
		$observations->id=str_replace(',','',$obj->id);
		$observations->patientid=str_replace(',','',$obj->patientid);
		$observations->patienttreatmentid=str_replace(',','',$obj->patienttreatmentid);
		$observations->observation=str_replace(',','',$obj->observation);
		$observations->createdby=str_replace(',','',$obj->createdby);
		$observations->createdon=str_replace(',','',$obj->createdon);
		$observations->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$observations->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $observations;
	
}
$page_title="Observations";
include "addobservations.php";
?>