<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientotherservices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/otherservices/Otherservices_class.php");
require_once("../../hos/departments/Departments_class.php");
require_once("../../hos/payables/Payables_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1331";//Edit
}
else{
	$auth->roleid="1329";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	$patientotherservices=new Patientotherservices();
	$where=" where id=$id ";
	$fields="hos_patientotherservices.id, hos_patientotherservices.patienttreatmentid, hos_patientotherservices.otherserviceid, hos_patientotherservices.charge, hos_patientotherservices.remarks, hos_patientotherservices.createdby, hos_patientotherservices.createdon, hos_patientotherservices.lasteditedby, hos_patientotherservices.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby="";
	$patientotherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$patientotherservices->fetchObject;
}
	
if($obj->action=="Save"){
$patientotherservices=new Patientotherservices();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$patientotherservices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		
		$patientotherservices=$patientotherservices->setObject($obj);
		if($patientotherservices->add($patientotherservices)){
			$error=SUCCESS;
// 			
			$otherservices = new Otherservices();
			$fields="*";
			$where=" where id='$obj->otherserviceid' ";
			$having="";
			$groupby="";
			$orderby="";
			$otherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$otherservices = $otherservices->fetchObject;
			
			$obj->remarks = $otherservices->name;
			$obj->patientid=$obj->patientid;
			$obj->treatmentno=$obj->documentno;
			$obj->consult=0;
			$obj->paid="No";
			$obj->amount=$obj->charge;
			$obj->transactionid=8;
			$obj->invoicedon=date("Y-m-d");
			$obj->createdby=$_SESSION['userid'];
			$obj->createdon=date("Y-m-d H:i:s");
			$obj->lasteditedby=$_SESSION['userid'];
			$obj->lasteditedon=date("Y-m-d H:i:s");
			
			$obj->otherserviceid="";
			$obj->charge="";
			
			$payables = new Payables();
			$payables->setObject($obj);
			$payables->transactdate=$obj->invoicedon;
			$payables->add($payables);
			
			//redirect("addpatientotherservices_proc.php?id=".$patientotherservices->id."&error=".$error);
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
		$patientotherservices=new Patientotherservices();
		$patientotherservices=setObject($obj);
		if($patientotherservices->edit($patientotherservices)){
			$obj="";
			$error=UPDATESUCCESS;
			redirect("addpatientotherservices_proc.php?id=".$patientotherservices->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action=="Add"){

	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shop=$_SESSION['shop'];

	$shop['$it']=array("id"=>$obj->id, "patienttreatmentid"=>$obj->patienttreatmentid, "otherserviceid"=>$obj->otherserviceid, "charge"=>$obj->charge, "remarks"=>$obj->remarks, "createdby"=>$obj->createdby, "createdon"=>$obj->createdon, "lasteditedby"=>$obj->lasteditedby, "lasteditedon"=>$obj->lasteditedon);

 	$it++;
 	$_SESSION['shop']=$shop;

	$obj->id="";
 	$obj->patienttreatmentid="";
 	$obj->otherserviceid="";
 	$obj->charge="";
 	$obj->remarks="";
 	$obj->createdby="";
 	$obj->createdon="";
 	$obj->lasteditedby="";
 	$obj->lasteditedon="";
 }
if(empty($obj->action)){

	$otherservices= new Otherservices ();
	$fields="hos_otherservices.id, hos_otherservices.name, hos_otherservices.charge, hos_otherservices.createdby, hos_otherservices.createdon, hos_otherservices.lasteditedby, hos_otherservices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$otherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	
	$patientotherservices = new Patientotherservices();
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fields=" max(documentno) testno ";
	$where="";
	$patientotherservices->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$test=$patientotherservices->fetchObject;
	$obj->documentno=$test->testno+1;

}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	if(empty($obj->patienttreatmentid)){
		$error="patienttreatmentid should be provided";
	}
	else if(empty($obj->otherserviceid)){
		$error="otherserviceid should be provided";
	}
	
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$patientotherservices= new Patientotherservices();
		$patientotherservices->id=str_replace(',','',$obj->id);
		$patientotherservices->patienttreatmentid=str_replace(',','',$obj->patienttreatmentid);
		$patientotherservices->otherserviceid=str_replace(',','',$obj->otherserviceid);
		$patientotherservices->charge=str_replace(',','',$obj->charge);
		$patientotherservices->remarks=str_replace(',','',$obj->remarks);
		$patientotherservices->createdby=str_replace(',','',$obj->createdby);
		$patientotherservices->createdon=str_replace(',','',$obj->createdon);
		$patientotherservices->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$patientotherservices->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $patientotherservices;
	
}
$page_title="Patientotherservices ";
include "addpatientotherservicess.php";
?>