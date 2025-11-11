<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientappointments_class.php");
require_once('../../hos/patientclasses/Patientclasses_class.php');


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../hos/patients/Patients_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hos/departments/Departments_class.php");
require_once '../../hos/payables/Payables_class.php';
require_once '../../hos/patientclasses/Patientclasses_class.php';
require_once '../../fn/generaljournals/Generaljournals_class.php';
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../../sys/transactions/Transactions_class.php';

//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$patientappointments=new Patientappointments();
	$where=" where hos_patientappointments.id=$id ";
	$fields="hos_patientappointments.id, hos_patientappointments.patientid, concat(hos_patients.surname,' ',hos_patients.othernames) patientname, hos_patientappointments.appointmentdate, hos_patientappointments.remarks, hos_patientappointments.createdby, hos_patientappointments.createdon, hos_patientappointments.lasteditedby, hos_patientappointments.lasteditedon";
	$join=" left join hos_patients on hos_patients.id=hos_patientappointments.patientid ";
	$having="";
	$groupby="";
	$orderby="";
	$patientappointments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientappointments->fetchObject;
	$obj->patientname=initialCap($obj->patientname);
}
	
if($obj->action=="Save"){
	$patientappointments=new Patientappointments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$patientappointments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		
		$patientappointments=$patientappointments->setObject($obj);
		$patientappointments->status=$obj->status;
		if($patientappointments->add($patientappointments)){
			$error=SUCCESS;
			$query="update hos_patients set patientclasseid='$obj->patientclasseid' where id='$obj->patientid'";
			mysql_query($query);
			
			if($obj->payconsultancy){
			    //retrieve patientclass
// 			    $patientclasses = new Patientclasses();
// 			    $fields=" * ";
// 			    $join=" left join hos_patients on hos_patients.patientclasseid=hos_patientclasses.id ";
// 			    $having="";
// 			    $groupby="";
// 			    $orderby="";
// 			    $where=" where hos_patients.id='$obj->patientid'";
// 			    $patientclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo mysql_error();
// 			    $patientclasses = $patientclasses->fetchObject;		    

			    $obj->transactionid=9;	
			    $obj->treatmentno=$patientappointments->id;
			    $obj->amount=$obj->amount;
			    $obj->invoicedon=date("Y-m-d");
			    $obj->consult=1;
						    
			    $obj->remarks = "Consultancy Fees";
			    $payables = new Payables();
			    
			    $payables->setObject($obj);
			    $payables->transactdate=$obj->invoicedon;
			    $payables->add($payables);
		    }
		
			redirect("addpatientappointments_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$patientappointments=new Patientappointments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d");
	$error=$patientappointments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		
		$patientappointments=$patientappointments->setObject($obj);
		if($patientappointments->edit($patientappointments)){
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
	$fields="hos_patients.id, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.genderid, hos_patients.dob, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon";
	$join="";
	$where="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
	$obj->appointmentdate=date("Y-m-d");
	$obj->bookedon=date("Y-m-d");
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	if(empty($obj->patientid)){
		$error="patientid should be provided";
	}
	else if(empty($obj->appointmentdate)){
		$error="appointmentdate should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$patientappointments= new Patientappointments();
		$patientappointments->id=str_replace(',','',$obj->id);
		$patientappointments->patientid=str_replace(',','',$obj->patientid);
		$patientappointments->appointmentdate=str_replace(',','',$obj->appointmentdate);
		$patientappointments->bookedon=str_replace(',','',$obj->bookedon);
		$patientappointments->remarks=str_replace(',','',$obj->remarks);
		$patientappointments->status=str_replace(',','',$obj->status);
		$patientappointments->payconsultancy=str_replace(',','',$obj->payconsultancy);
		$patientappointments->createdby=str_replace(',','',$obj->createdby);
		$patientappointments->createdon=str_replace(',','',$obj->createdon);
		$patientappointments->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$patientappointments->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $patientappointments;
	
}
$page_title="Patientappointments";
include "addpatientappointments.php";
?>