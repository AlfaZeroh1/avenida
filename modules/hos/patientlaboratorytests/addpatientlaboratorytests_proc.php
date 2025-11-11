<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientlaboratorytests_class.php");
require_once("../laboratorytestdetails/Laboratorytestdetails_class.php");
require_once("../patientlaboratorytestdetails/Patientlaboratorytestdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/patients/Patients_class.php");
require_once("../../hos/laboratorytests/Laboratorytests_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1284";//Edit
}
else{
	$auth->roleid="1282";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
$testno = $_GET['testno'];

if(!empty($id)){
	$patientlaboratorytests=new Patientlaboratorytests();
	$where=" where hos_patientlaboratorytests.id=$id ";
	$fields="hos_patientlaboratorytests.id, hos_patientlaboratorytests.testno,hos_laboratorytests.name laboratorytestname, concat(hos_patients.surname,' ',hos_patients.othernames) patient, hos_patientlaboratorytests.patientid, hos_patientlaboratorytests.patienttreatmentid, hos_patientlaboratorytests.laboratorytestid, hos_patientlaboratorytests.charge, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
$join=" left join hos_patients on hos_patients.id=hos_patientlaboratorytests.patientid left join hos_laboratorytests on hos_laboratorytests.id=hos_patientlaboratorytests.laboratorytestid ";
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
		if($patientlaboratorytests->add($patientlaboratorytests)){
			$error=SUCCESS;
			redirect("addpatientlaboratorytests_proc.php?id=".$patientlaboratorytests->id."&error=".$error);
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
		
			$laboratorytestdetails=new Laboratorytestdetails();
			$fields="hos_laboratorytestdetails.id, hos_laboratorytests.name as laboratorytestid, hos_laboratorytestdetails.detail, hos_laboratorytestdetails.remarks, hos_laboratorytestdetails.ipaddress, hos_laboratorytestdetails.createdby, hos_laboratorytestdetails.createdon, hos_laboratorytestdetails.lasteditedby, hos_laboratorytestdetails.lasteditedon";
			$join=" left join hos_laboratorytests on hos_laboratorytestdetails.laboratorytestid=hos_laboratorytests.id ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where hos_laboratorytestdetails.laboratorytestid='$obj->laboratorytestid' ";
			$laboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$laboratorytestdetails->result;
			while($row=mysql_fetch_object($res)){
			  if(!empty($_POST[$row->id])){
			  
			    $patientlaboratorytestdetails = new Patientlaboratorytestdetails();
			    $patientlaboratorytestdetails->patientlaboratorytestid=$obj->id;
			    $patientlaboratorytestdetails->laboratorytestdetailid=$row->id;
			    $patientlaboratorytestdetails->result=$_POST[$row->id];
			    
			    $patientlaboratorytestdetails = $patientlaboratorytestdetails->setObject($patientlaboratorytestdetails);
			    
			    $patientlaboratorytestdetail = new Patientlaboratorytestdetails();
			    $fields="hos_patientlaboratorytestdetails.id, hos_laboratorytestdetails.id as laboratorytestdetailid, hos_patientlaboratorytestdetails.result, hos_patientlaboratorytestdetails.remarks, hos_patientlaboratorytestdetails.ipaddress, hos_patientlaboratorytestdetails.createdby, hos_patientlaboratorytestdetails.createdon, hos_patientlaboratorytestdetails.lasteditedby, hos_patientlaboratorytestdetails.lasteditedon";
			    $join=" left join hos_patientlaboratorytests on hos_patientlaboratorytestdetails.patientlaboratorytestid=hos_patientlaboratorytests.id  left join hos_laboratorytestdetails on hos_patientlaboratorytestdetails.laboratorytestdetailid=hos_laboratorytestdetails.id ";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $where=" where hos_patientlaboratorytestdetails.patientlaboratorytestid='$obj->id' and hos_patientlaboratorytestdetails.laboratorytestdetailid='$row->id' ";
			    $patientlaboratorytestdetail->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    
			    			    
			    if($patientlaboratorytestdetail->affectedRows==0)
			      $patientlaboratorytestdetails->add($patientlaboratorytestdetails);
			    else{
			      $pat = $patientlaboratorytestdetail->fetchObject;
			      $patientlaboratorytestdetails->id=$pat->id;
			      $patientlaboratorytestdetails->edit($patientlaboratorytestdetails);
			    }
			    
			  }
			}
			
			$obj="";
			$error=UPDATESUCCESS;
			redirect("addpatientlaboratorytests_proc.php?id=".$patientlaboratorytests->id."&error=".$error);
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

	$shop['$it']=array("id"=>$obj->id, "testno"=>$obj->testno, "patientid"=>$obj->patientid, "patienttreatmentid"=>$obj->patienttreatmentid, "laboratorytestid"=>$obj->laboratorytestid, "charge"=>$obj->charge, "labresults"=>$obj->labresults, "testedon"=>$obj->testedon, "consult"=>$obj->consult, "createdby"=>$obj->createdby, "createdon"=>$obj->createdon, "lasteditedby"=>$obj->lasteditedby, "lasteditedon"=>$obj->lasteditedon);

 	$it++;
 	$_SESSION['shop']=$shop;

	$obj->id="";
 	$obj->testno="";
 	$obj->patientid="";
 	$obj->patienttreatmentid="";
 	$obj->laboratorytestid="";
 	$obj->charge="";
 	$obj->labresults="";
 	$obj->testedon="";
 	$obj->consult="";
 	$obj->createdby="";
 	$obj->createdon="";
 	$obj->lasteditedby="";
 	$obj->lasteditedon="";
 }
if(empty($obj->action)){

	$where="";
	$patients= new Patients ();
	$fields="hos_patients.id, hos_patients.patientno, hos_patients.surname, hos_patients.othernames, hos_patients.address, hos_patients.email, hos_patients.mobile, hos_patients.genderid, hos_patients.dob, hos_patients.createdby, hos_patients.createdon, hos_patients.lasteditedby, hos_patients.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$laboratorytests= new Laboratorytests ();
	$fields="hos_laboratorytests.id, hos_laboratorytests.name, hos_laboratorytests.remarks, hos_laboratorytests.charge";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$laboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}
if(empty($id) and empty($obj->action)){
	$obj->action="Save";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
	
	$patientlaboratorytestdetails = new Patientlaboratorytestdetails();
	$fields="hos_patientlaboratorytestdetails.id, hos_laboratorytestdetails.id as laboratorytestdetailid, hos_patientlaboratorytestdetails.result, hos_patientlaboratorytestdetails.remarks, hos_patientlaboratorytestdetails.ipaddress, hos_patientlaboratorytestdetails.createdby, hos_patientlaboratorytestdetails.createdon, hos_patientlaboratorytestdetails.lasteditedby, hos_patientlaboratorytestdetails.lasteditedon";
	$join=" left join hos_patientlaboratorytests on hos_patientlaboratorytestdetails.patientlaboratorytestid=hos_patientlaboratorytests.id  left join hos_laboratorytestdetails on hos_patientlaboratorytestdetails.laboratorytestdetailid=hos_laboratorytestdetails.id ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where hos_patientlaboratorytestdetails.patientlaboratorytestid='$obj->id' ";
	$patientlaboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$patientlaboratorytestdetails->results;
	while($row=mysql_fetch_object($res)){
	  $_POST[$row->laboratorytestdetailid]=$row->result;
	}
}
	
if(!empty($testno)){
	
	$obj->testno=$testno;
	$patientlaboratorytests=new Patientlaboratorytests();
	$where=" where hos_patientlaboratorytests.testno=$testno ";
	$fields="hos_patientlaboratorytests.id, hos_patientlaboratorytests.testno, concat(hos_patients.surname,' ',hos_patients.othernames) patient, hos_patientlaboratorytests.patientid, hos_patientlaboratorytests.patienttreatmentid, hos_patientlaboratorytests.laboratorytestid, hos_patientlaboratorytests.charge, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
	$join=" left join hos_patients on hos_patients.id=hos_patientlaboratorytests.patientid ";
	$having="";
	$groupby="";
	$orderby="";
	$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$patientlaboratorytests=$patientlaboratorytests->fetchObject;
	$obj->patientid=$patientlaboratorytests->patientid;
	$obj->patient=$patientlaboratorytests->patient;
	$obj->patienttreatmentid=$patientlaboratorytests->patienttreatmentid;
	$obj->testedon=date("Y-m-d");
	
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
		$patientlaboratorytests->charge=str_replace(',','',$obj->charge);
		$patientlaboratorytests->labresults=str_replace(',','',$obj->labresults);
		$patientlaboratorytests->labresults=str_replace("'","\'",$obj->labresults);
		$patientlaboratorytests->labresults=str_replace('"','\"',$obj->labresults);
		$patientlaboratorytests->results=str_replace(',','',$obj->results);
		$patientlaboratorytests->testedon=str_replace(',','',$obj->testedon);
		$patientlaboratorytests->consult=str_replace(',','',$obj->consult);
		$patientlaboratorytests->createdby=str_replace(',','',$obj->createdby);
		$patientlaboratorytests->createdon=str_replace(',','',$obj->createdon);
		$patientlaboratorytests->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$patientlaboratorytests->lasteditedon=str_replace(',','',$obj->lasteditedon);
		return $patientlaboratorytests;
	
}
$page_title="Patientlaboratorytests ";
include "addpatientlaboratorytests.php";
?>