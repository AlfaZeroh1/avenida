<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patients_class.php");
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';
require_once '../../hos/patientclasses/Patientclasses_class.php';
require_once("../../hos/civilstatuss/Civilstatuss_class.php");



if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
require_once("../../sys/genders/Genders_class.php");


//connect to db
$db=new DB();
$obj=(object)$_POST;
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($id)){
	
	$patients=new Patients();
	$where=" where id=$id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	$obj=$patients->fetchObject;
	
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
		$patients=new Patients();
		$patients=setObject($obj);
		if($patients->add($patients)){
		        //adding general journal account(s)
// 			$generaljournalaccount=new Generaljournalaccounts();
// 			$fields="*";
// 			$join="";
// 			$where=" where acctypeid=31 and refid='$obj->patientclasseid' and categoryid is null ";
// 			$having="";
// 			$groupby="";
// 			$orderby="";
// 			$generaljournalaccount->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 			$generaljournalaccount=$generaljournalaccount->fetchObject;
// 			
// 			$obj->name=$obj->surname." ".$obj->othernames;
// 			$generaljournalaccounts = new Generaljournalaccounts();
// 			$obj->refid=$patients->id;
// 			$obj->acctypeid=31;
// 			$obj->categoryid=$generaljournalaccount->id;
// 			$generaljournalaccounts->setObject($obj);
// 			$generaljournalaccounts->add($generaljournalaccounts);
			
			$error=SUCCESS;
			redirect("addpatients_proc.php?error=".$error);
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
		$patients=new Patients();
		$patients=setObject($obj);
		if($patients->edit($patients)){
		
			//edit Journal Account
			$generaljournalaccounts = new Generaljournalaccounts();
			$where=" where refid=$obj->id ";
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$patients->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
			$obj=$patients->fetchObject;
			$obj="";
			$error=UPDATESUCCESS;
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$Patientclasses= new Patientclasses();
	$fields=" * ";
	$join=" ";
	$having="";
	$groupby="";
	$orderby="";
	$Patientclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);



	$civilstatuss= new Civilstatuss();
	$fields="hos_civilstatuss.id, hos_civilstatuss.name, hos_civilstatuss.remarks, hos_civilstatuss.createdby, hos_civilstatuss.createdon, hos_civilstatuss.lasteditedby, hos_civilstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$civilstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}
if(empty($obj->action)){

	$genders= new Genders();
	$fields="sys_genders.id, sys_genders.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$genders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}
if(empty($id) and empty($obj->action)){
	@$obj->action="Save";
	
	$patients = new Patients();
	$fields=" max(id)+1 as id ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where="";
	$patients->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$pat = $patients->fetchObject;
	$obj->patientno=str_pad($pat->id, 5, 0, STR_PAD_LEFT)."/".date("y");
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
function validate($obj){
	if(empty($obj->patientno)){
		$error="patientno should be provided";
	}
	else if(empty($obj->surname)){
		$error="surname should be provided";
	}
	else if(empty($obj->othernames)){
		$error="othernames should be provided";
	}
	else if(empty($obj->patientclasseid)){
		$error="patient's class should be provided";
	}
	else if(empty($obj->genderid)){
		$error="genderid should be provided";
	}
	if(!empty($error))
		return $error;
	else
		return null;
	
}
function setObject($obj){
		$patients= new Patients();
		$patients->id=str_replace(',','',$obj->id);
		$patients->patientno=str_replace(',','',$obj->patientno);
		$patients->surname=str_replace(',','',$obj->surname);
		$patients->othernames=str_replace(',','',$obj->othernames);
		$patients->patientclasseid=str_replace(',','',$obj->patientclasseid);
		$patients->address=str_replace(',','',$obj->address);
		$patients->email=str_replace(',','',$obj->email);
		$patients->mobile=str_replace(',','',$obj->mobile);
		$patients->genderid=str_replace(',','',$obj->genderid);
		$patients->dob=str_replace(',','',$obj->dob);
		$patients->age=str_replace(',','',$obj->age);
		$patients->createdby=str_replace(',','',$obj->createdby);
		$patients->createdon=str_replace(',','',$obj->createdon);
		$patients->lasteditedby=str_replace(',','',$obj->lasteditedby);
		$patients->lasteditedon=str_replace(',','',$obj->lasteditedon);
		$patients->civilstatusid=str_replace("'","\'",$obj->civilstatusid);
		return $patients;
	
}
$page_title="Patients";
include "addpatients.php";
?>