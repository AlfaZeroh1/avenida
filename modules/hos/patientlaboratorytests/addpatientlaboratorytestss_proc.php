<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientlaboratorytests_class.php");
require_once '../../fn/generaljournals/Generaljournals_class.php';
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../hos/patients/Patients_class.php");
require_once("../../hos/laboratorytests/Laboratorytests_class.php");

require_once '../../hos/payables/Payables_class.php';
require_once("../../sys/transactions/Transactions_class.php");


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$delid=$_GET['delid'];
if(!empty($delid)){
	$patientlaboratorytests = new Patientlaboratorytests();
	$patientlaboratorytests->id=$delid;
	$patientlaboratorytests->delete($patientlaboratorytests);
}
$error=$_GET['error'];
if(!empty($id)){
	$patientlaboratorytests=new Patientlaboratorytests();
	$where=" where patienttreatmentid=$id ";
	$fields="hos_patientlaboratorytests.id, hos_patientlaboratorytests.testno, hos_patientlaboratorytests.patientid, hos_patientlaboratorytests.patienttreatmentid, hos_patientlaboratorytests.laboratorytestid, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
	$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientlaboratorytests->fetchObject;
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
		$patientlaboratorytests=new Patientlaboratorytests();
		$patientlaboratorytests=setObject($obj);
		$patientlaboratorytests->testedon=date("Y-m-d H:i:s");
		if($patientlaboratorytests->add($patientlaboratorytests)){
			//make a journal entry
			
			$obj->remarks = $obj->laboratorytestname;
			$obj->patientid=$obj->patientid;
			$obj->treatmentno=$obj->testno;
			$obj->departmentid=1;
			$obj->consult=0;
			$obj->paid="No";
			$obj->amount=$obj->price;
			$obj->transactionid=7;
			$obj->invoicedon=date("Y-m-d");
			$obj->createdby=$_SESSION['userid'];
			$obj->createdon=date("Y-m-d H:i:s");
			$obj->lasteditedby=$_SESSION['userid'];
			$obj->lasteditedon=date("Y-m-d H:i:s");
			
			$payables = new Payables();
			$payables->setObject($obj);
			$payables->transactdate=$obj->invoicedon;
			$payables->add($payables);
			
			/*if(!empty($patientlaboratorytests->laboratorytestid)){
			$gen = new Generaljournals();
			$where=" where transactionid=3 and documentno='$obj->testno' ";
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$gen->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			if($gen->affectedRows>0){
				//record amount payable to generaljournal
				//debit Patients A/c and credit Accounts Receivable A/C
				$generaljournals = new Generaljournals();
					
				$generaljournalaccounts = new Generaljournalaccounts();
				$fields=" * ";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where fn_generaljournalaccounts.refid=1 and fn_generaljournalaccounts.acctype=31 ";
				$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$gna=$generaljournalaccounts->fetchObject;
					
				$generaljournalaccounts2 = new Generaljournalaccounts();
				$fields=" * ";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where fn_generaljournalaccounts.refid=1 and fn_generaljournalaccounts.acctype=11 ";
				$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$gnas=$generaljournalaccounts2->fetchObject;
					
				$drgeneraljournals = new Generaljournals();
				$crgeneraljournals = new Generaljournals();
					
				$drgeneraljournals->accountid=$gna->id;
				$drgeneraljournals->tid=$obj->patientid;
				$drgeneraljournals->documentno=$obj->testno;
				$drgeneraljournals->transactionid=3;
				$drgeneraljournals->transactdate=$obj->treatedon;
				$drgeneraljournals->debit=$obj->charge;
				$drgeneraljournals->credit=0;
				$drgeneraljournals->createdby=$_SESSION['userid'];
				$drgeneraljournals->createdon=date("Y-m-d H:i:s");
				$drgeneraljournals->lasteditedby=$_SESSION['userid'];
				$drgeneraljournals->lasteditedon=date("Y-m-d H:i:s");
				$drgeneraljournals->add($drgeneraljournals);
				$id=mysql_insert_id();
					
				$crgeneraljournals->accountid=$gnas->id;
				$crgeneraljournals->daccountid=$gna->id;
				$crgeneraljournals->tid=$obj->patientid;
				$crgeneraljournals->documentno=$obj->testno;
				$crgeneraljournals->transactionid=3;
				$crgeneraljournals->transactdate=$obj->treatedon;
				$crgeneraljournals->debit=0;
				$crgeneraljournals->credit=$obj->charge;
				$crgeneraljournals->did=$id;
				$crgeneraljournals->createdby=$_SESSION['userid'];
				$crgeneraljournals->createdon=date("Y-m-d H:i:s");
				$crgeneraljournals->lasteditedby=$_SESSION['userid'];
				$crgeneraljournals->lasteditedon=date("Y-m-d H:i:s");
				$crgeneraljournals->add($crgeneraljournals);
				$did=mysql_insert_id();
					
				$drgeneraljournals->id=$id;
				$drgeneraljournals->did=$did;
				$drgeneraljournals->daccountid=$crgeneraljournals->accountid;
				$drgeneraljournals->edit($drgeneraljournals);
			}
			else{
				//record amount payable to generaljournal
				//debit Patients A/c and credit Accounts Receivable A/C
				$generaljournals = new Generaljournals();
					
				$generaljournals = new Generaljournalaccounts();
				$fields=" * ";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where fn_generaljournalaccounts.refid=1 and fn_generaljournalaccounts.acctype=31 ";
				$generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$gna=$generaljournalaccounts->fetchObject;
					
				$generaljournalaccounts2 = new Generaljournalaccounts();
				$fields=" * ";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where fn_generaljournalaccounts.refid=1 and fn_generaljournalaccounts.acctype=11 ";
				$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$gnas=$generaljournalaccounts2->fetchObject;
					
				$drgeneraljournals = new Generaljournals();
				$crgeneraljournals = new Generaljournals();
					
				$drgeneraljournals->accountid=$gna->id;
				$drgeneraljournals->tid=$obj->patientid;
				$drgeneraljournals->documentno=$obj->testno;
				$drgeneraljournals->transactionid=3;
				$drgeneraljournals->transactdate=$obj->treatedon;
				$drgeneraljournals->debit=$obj->charge;
				$drgeneraljournals->credit=0;
				$drgeneraljournals->createdby=$_SESSION['userid'];
				$drgeneraljournals->createdon=date("Y-m-d H:i:s");
				$drgeneraljournals->lasteditedby=$_SESSION['userid'];
				$drgeneraljournals->lasteditedon=date("Y-m-d H:i:s");
				$drgeneraljournals->add($drgeneraljournals);
				$id=mysql_insert_id();
					
				$crgeneraljournals->accountid=$gnas->id;
				$crgeneraljournals->daccountid=$gna->id;
				$crgeneraljournals->tid=$obj->patientid;
				$crgeneraljournals->documentno=$obj->testno;
				$crgeneraljournals->transactionid=3;
				$crgeneraljournals->transactdate=$obj->treatedon;
				$crgeneraljournals->debit=0;
				$crgeneraljournals->credit=$obj->charge;
				$crgeneraljournals->did=$id;
				$crgeneraljournals->createdby=$_SESSION['userid'];
				$crgeneraljournals->createdon=date("Y-m-d H:i:s");
				$crgeneraljournals->lasteditedby=$_SESSION['userid'];
				$crgeneraljournals->lasteditedon=date("Y-m-d H:i:s");
				$crgeneraljournals->add($crgeneraljournals);
				$did=mysql_insert_id();
					
				$drgeneraljournals->id=$id;
				$drgeneraljournals->did=$did;
				$drgeneraljournals->daccountid=$crgeneraljournals->accountid;
				$drgeneraljournals->edit($drgeneraljournals);
			}
			}*/
			$obj->laboratorytestid="";
			$obj->price="";
			$obj->laboratorytestname="";
			//$error=SUCCESS;
			//redirect("addpatientlaboratorytests_proc.php?error=".$error);
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
		$patientlaboratorytests=new Patientlaboratorytests();
		$patientlaboratorytests=setObject($obj);
		if($patientlaboratorytests->edit($patientlaboratorytests)){
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
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$laboratorytests= new Laboratorytests();
	$fields="hos_laboratorytests.id, hos_laboratorytests.name, hos_laboratorytests.remarks, hos_laboratorytests.charge";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$laboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	
	$patientlaboratorytests = new Patientlaboratorytests();
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fields=" max(testno) testno ";
	$where="";
	$patientlaboratorytests->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$test=$patientlaboratorytests->fetchObject;
	$obj->testno=$test->testno+1;

}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	if(empty($obj->testno)){
		$error="testno should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$patientlaboratorytests= new Patientlaboratorytests();
		$patientlaboratorytests->id=str_replace(',','',$obj->id);
		$patientlaboratorytests->testno=str_replace(',','',$obj->testno);
		$patientlaboratorytests->patientid=str_replace(',','',$obj->patientid);
		$patientlaboratorytests->patienttreatmentid=str_replace(',','',$obj->patienttreatmentid);
		$patientlaboratorytests->laboratorytestid=str_replace(',','',$obj->laboratorytestid);
		$patientlaboratorytests->labresults=str_replace(',','',$obj->labresults);
		$patientlaboratorytests->testedon=str_replace(',','',$obj->testedon);
		$patientlaboratorytests->consult=str_replace(',','',$obj->consult);
		$patientlaboratorytests->createdby=str_replace(',','',$obj->createdby);
		$patientlaboratorytests->createdon=str_replace(',','',$obj->createdon);
		$patientlaboratorytests->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$patientlaboratorytests->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $patientlaboratorytests;
	
}
$page_title="Patientlaboratorytests";
include "addpatientlaboratorytestss.php";
?>