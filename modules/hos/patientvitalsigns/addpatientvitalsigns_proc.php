<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientvitalsigns_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/patients/Patients_class.php");
require_once("../../hos/patientappointments/Patientappointments_class.php");
require_once("../../hos/vitalsigns/Vitalsigns_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4361";//Edit
}
else{
	$auth->roleid="4359";//Add
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
$patientid = $_GET['patientid'];
$treatmentid=$_GET['treatmentid'];

if(!empty($patientid)){
	$obj->patientid=$patientid;
	$obj->patienttreatmentid=$treatmentid;
	$obj->patientappointmentid=$ob->appointmentid;
	
	$patients = new Patients();
	$fields="concat(surname,' ',othernames) name, patientno";
	$where=" where id='$obj->patientid'";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$patients = $patients->fetchObject;
	
	$obj->observedon=date("Y-m-d");
	$obj->observedtime=date("H:i:s");
}
	
	
if($obj->action=="Save"){
	$patientvitalsigns=new Patientvitalsigns();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$patientvitalsigns->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$vitalsigns = new Vitalsigns();
		$fields="*";
		$where="";
		$having="";
		$groupby="";
		$orderby="";
		$vitalsigns->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		while($rw=mysql_fetch_object($vitalsigns->result)){
			if(!empty($_POST['results'.$rw->id])){
				$obj->vitalsignid=$rw->id;
				$obj->results=$_POST['results'.$rw->id];
				$obj->remarks=$_POST['remarks'.$rw->id];
				
				$patientvitalsigns=$patientvitalsigns->setObject($obj);
				
				$patvitalsigns = new Patientvitalsigns();
				$fields="*";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where patientappointmentid='$obj->patientappointmentid' and vitalsignid='$obj->vitalsignid'";
				$patvitalsigns->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				
				if($patvitalsigns->affectedRows>0 and empty($obj->patienttreatmentid)){						
										
					$pav=$patvitalsigns->fetchObject;
					$patientvitalsigns->id=$pav->id;
					$patientvitalsigns->edit($patientvitalsigns);
					
					//redirect("addpatientvitalsigns_proc.php?id=".$patientvitalsigns->id."&error=".$error);
				}
				else{
					$patientvitalsigns->add($patientvitalsigns);
				}
				
				$patientappointments = new Patientappointments();
				$fields="*";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where id='$obj->patientappointmentid' ";
				$patientappointments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$pat=$patientappointments->fetchObject;
				$pat->status=2;
					
				$patient = new Patientappointments();
				$patient->edit($pat);
				
			}
			$error=SUCCESS;
		}		
	}
}
	
if($obj->action=="Update"){
	$patientvitalsigns=new Patientvitalsigns();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$patientvitalsigns->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$patientvitalsigns=$patientvitalsigns->setObject($obj);
		if($patientvitalsigns->edit($patientvitalsigns)){
			$error=UPDATESUCCESS;
			redirect("addpatientvitalsigns_proc.php?id=".$patientvitalsigns->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action) and empty($patientid)){

	$patients= new Patients();
	$fields="hos_patients.id, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.genderid, hos_patients.dob,  hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$vitalsigns= new Vitalsigns();
	$fields="hos_vitalsigns.id, hos_vitalsigns.name, hos_vitalsigns.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vitalsigns->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($appointmentid)){
	$patientvitalsigns=new Patientvitalsigns();
	$where=" where patientappointmentid=$appointmentid ";
	$fields="hos_patientvitalsigns.id, hos_patientvitalsigns.patientid, hos_patientvitalsigns.patientappointmentid, hos_patientvitalsigns.vitalsignid, hos_patientvitalsigns.results, hos_patientvitalsigns.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patientvitalsigns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	//$obj=$patientvitalsigns->fetchObject;
	while($rw=mysql_fetch_object($patientvitalsigns->result)){
		$_POST['vitalsign'.$rw->vitalsignid]=$rw->vitalsign;
		$_POST['results'.$rw->vitalsignid]=$rw->results;
		$_POST['remarks'.$rw->vitalsignid]=$rw->remarks;
	}

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
	
	
$page_title="Patient Vital Signs ";
include "addpatientvitalsigns.php";
?>