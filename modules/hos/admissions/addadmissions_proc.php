<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Admissions_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../hos/patients/Patients_class.php");
require_once("../../hos/beds/Beds_class.php");
require_once '../../hos/departments/Departments_class.php';

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/patienttreatments/Patienttreatments_class.php");
require_once("../../hos/wards/Wards_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4485";//Edit
}
else{
	$auth->roleid="4483";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->treatmentid)){
	$obj->treatmentid=$ob->treatmentid;
	$obj->patientid=$ob->patientid;	
}

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
	
	
if($obj->action=="Save"){
	$admissions=new Admissions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$admissions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		
		$obj->status=1;
		
		$admissions=$admissions->setObject($obj);
		if($admissions->add($admissions)){
			$error=SUCCESS;
			
			$patienttreatments = new Patienttreatments();
			$fields="*";
			$join="";
			$where=" where id='$obj->treatmentid' ";
			$having="";
			$groupby="";
			$orderby="";
			$patienttreatments->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$patienttreatments=$patienttreatments->fetchObject;
			$patienttreatments->admission="Yes";
			
			$pat = new Patienttreatments();
			$pat->setObject($patienttreatments);
			$pat->edit($pat);
			
			redirect("../patienttreatments/addpatienttreatments_proc.php?treatmentid=".$obj->treatmentid."&error=".$error."&tab=2");
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$admissions=new Admissions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$admissions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$admissions=$admissions->setObject($obj);
		if($admissions->edit($admissions)){
			$error=UPDATESUCCESS;
			redirect("addadmissions_proc.php?id=".$admissions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$patienttreatments= new Patienttreatments();
	$fields="hos_patienttreatments.id treatmentid, hos_patienttreatments.patientid, hos_patienttreatments.patientappointmentid, hos_patienttreatments.symptoms, hos_patienttreatments.hpi, hos_patienttreatments.obs, hos_patienttreatments.findings, hos_patienttreatments.investigation, hos_patienttreatments.diagnosis, hos_patienttreatments.admission, hos_patienttreatments.treatedon, hos_patienttreatments.patientstatusid, hos_patienttreatments.payconsultancy, hos_patienttreatments.createdby, hos_patienttreatments.createdon, hos_patienttreatments.lasteditedby, hos_patienttreatments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$wards= new Wards();
	$fields="hos_wards.id, hos_wards.name, hos_wards.departmentid, hos_wards.remarks, hos_wards.firstroom, hos_wards.lastroom, hos_wards.roomprefix, hos_wards.status, hos_wards.createdby, hos_wards.createdon, hos_wards.lasteditedby, hos_wards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$wards->retrieve($fields,$join,$where,$having,$groupby,$orderby);



	/*$patients= new Patients();
	$fields=" hos_admissions.treatmentid, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid ";
	$join=" left join hos_admissions on hos_admissions.patientid=hos_patients.id ";
	$having="";
	$groupby="";
	$where=" where hos_admissions.treatmentid=$obj->treatmentid";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);*/

	$obj->admissiondate=date("Y-m-d");


}

if(!empty($id)){
	$admissions=new Admissions();
	$where=" where id=$id ";
	$fields="hos_admissions.id, hos_admissions.bedid, hos_admissions.patientid, hos_admissions.treatmentid, hos_admissions.admissiondate, hos_admissions.remarks, hos_admissions.status, hos_admissions.createdby, hos_admissions.createdon, hos_admissions.lasteditedby, hos_admissions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$admissions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$admissions->fetchObject;

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

if(!empty($ob->status)){
  $obj->status=$ob->status;
}
	
$page_title="Admissions ";
include "addadmissions.php";
?>