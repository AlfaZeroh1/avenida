<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Payables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/patients/Patients_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once '../../hos/bills/Bills_class.php';
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../../fn/generaljournals/Generaljournals_class.php';
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8435";//Edit
}
else{
	$auth->roleid="8435";//Add
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

if(!empty($ob->treatmentno))
{
  $obj->treatmentno=$ob->treatmentno;
  $obj->departmentid=$ob->departmentid;
  $obj->patientid=$ob->patientid;
  $obj->consult=$ob->consult;
  $obj->paid="No";
  $obj->invoicedon=date("Y-m-d");
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$payables=new Payables();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$payables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payables=$payables->setObject($obj);
		$payables->transactdate=$obj->invoicedon;
		if($payables->add($payables)){
			$error=SUCCESS;
			redirect("addpayables_proc.php?id=".$payables->id."&error=".$error);
		}
		else{
			$error=SUCCESS;
		}
	}
}
	
if($obj->action=="Update"){
	$payables=new Payables();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$payables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$payables=$payables->setObject($obj);
		if($payables->edit($payables)){
			$error=UPDATESUCCESS;
			redirect("addpayables_proc.php?id=".$payables->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$patients= new Patients();
	$fields="hos_patients.id, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.patientclasseid, hos_patients.bloodgroup, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.genderid, hos_patients.dob, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon, hos_patients.civilstatusid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$transactions= new Transactions();
	$fields="sys_transactions.id, sys_transactions.name, sys_transactions.moduleid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$payables=new Payables();
	$where=" where id=$id ";
	$fields="hos_payables.id, hos_payables.documentno, hos_payables.patientid, hos_payables.transactionid, hos_payables.treatmentno, hos_payables.amount, hos_payables.remarks, hos_payables.invoicedon, hos_payables.consult, hos_payables.paid, hos_payables.createdby, hos_payables.createdon, hos_payables.lasteditedby, hos_payables.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$payables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$payables->fetchObject;

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
	
	
$page_title="Payables ";
include "addpayables.php";
?>