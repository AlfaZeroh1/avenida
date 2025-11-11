<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeleaves_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../hrm/leaves/Leaves_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/employeeleaveapplications/Employeeleaveapplications_class.php");
require_once("../../hrm/leavesectiondetails/Leavesectiondetails_class.php");
require_once("../../hrm/employeeleaves/Employeeleaves_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4239";//Edit
}
else{
	$auth->roleid="4237";//Add
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
$id=$_GET['lid'];
$error=$_GET['error'];
	
	
if($obj->action=="Save"){
	$employeeleaves=new Employeeleaves();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->appliedon=date("Y-m-d");
	$error=$employeeleaves->validate($obj);	
	
	//check for remaining days
	$employeeleaves=new Employeeleaves();
	$fields=" hrm_employeeleaves.id,hrm_employeeleaves.employeeid,hrm_employeeleaves.startdate, hrm_employeeleaves.duration ";
	$join="";
	$having="";
	$where=" where hrm_employeeleaves.employeeid='$obj->employeeid' ";
	$groupby="";
	$orderby="";
	$employeeleaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$employeeleaves->result;
	//echo mysql_affected_rows($res);
	//echo mysql_num_rows($result);
	if(mysql_affected_rows()!=0) 
	    { 
	    //pick leave section id to which the employee fall
	        $employees=new Employees();
		$fields=" hrm_assignments.leavesectionid as leavesectionid ";
		$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.id='$obj->employeeid' ";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){		
		$leavesectionid=$row->leavesectionid;
		//get already taken leave days
	        $employeeleaves=new Employeeleaves();
		$fields=" sum(hrm_employeeleaves.duration) as duration ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeeleaves.employeeid='$obj->employeeid' and hrm_employeeleaves.leaveid='$obj->leaveid' and year(hrm_employeeleaves.startdate)='year($obj->startdate)' and status='granted' ";
		$employeeleaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeeleaves->result;
		while($row=mysql_fetch_object($res)){		
		$tdays=$row->duration;
		
               //retrieve remaining days
		$leavesectiondetails=new Leavesectiondetails();
		$fields=" hrm_leavesectiondetails.days as days,hrm_leavesectiondetails.duration as duration ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_leavesectiondetails.leaveid='$obj->leaveid' and hrm_leavesectiondetails.leavesectionid='$leavesectionid' ";
		$leavesectiondetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$leavesectiondetails->result;
		while($row=mysql_fetch_object($res)){
		      $duration=$row->duration;
		      $days=($row->days-$tdays);
		      }  		
		}	    
	       } 
	      }
	else{
	//pick leave section id to which the employee fall
	     $employees=new Employees();
		$fields="hrm_assignments.leavesectionid as leavesectionid";
		$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employees.id='$obj->employeeid'";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employees->result;
		while($row=mysql_fetch_object($res)){		
		$leavesectionid=$row->leavesectionid;
		}
		
	//retrieve number of days	
	 $leavesectiondetails=new Leavesectiondetails();
		$fields=" hrm_leavesectiondetails.days as days,hrm_leavesectiondetails.duration as duration ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_leavesectiondetails.leaveid='$obj->leaveid' and hrm_leavesectiondetails.leavesectionid='$leavesectionid' ";
		$leavesectiondetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$leavesectiondetails->result;
		while($row=mysql_fetch_object($res)){
		      $duration=$row->duration;
		      $days=$row->days;
		      }  
	   }
	    //echo an error if days are more than required or remaining
	    if($days<$obj->duration)
		  {
		  $error="You Only have  ".$days." days remaining";
		  }
		  
            //check for the required days
		  $daylen = 60*60*24;
		  $date1 = $obj->startdate;
		  $date2 = date('Y-m-d');
		  $interval=(strtotime($date1)-strtotime($date2))/$daylen;
	
	      //echo $interval if duration is less than required
		  if($interval<$duration){
		  $error="Start date should be ".$duration." Days from today";
		  }
		  
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeleaves=$employeeleaves->setObject($obj);
		if($employeeleaves->add($employeeleaves)){
			$error=SUCCESS;
			redirect("addemployeeleaves_proc.php?id=".$employeeleaves->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update" or $obj->action=="Grant" or $obj->action=="Send Back" or $obj->action=="Decline"){
	$employeeleaves=new Employeeleaves();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeeleaves->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeleaves=$employeeleaves->setObject($obj);
		if($employeeleaves->edit($employeeleaves)){
			$error=UPDATESUCCESS;
			redirect("addemployeeleaves_proc.php?id=".$employeeleaves->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}


if(!empty($id)){
	$employeeleaves=new Employeeleaves();
	$where=" where id=$id ";
	$fields="hrm_employeeleaves.id, hrm_employeeleaves.employeeleaveapplicationid, hrm_employeeleaves.startdate, hrm_employeeleaves.duration, hrm_employeeleaves.createdby, hrm_employeeleaves.createdon, hrm_employeeleaves.lasteditedby, hrm_employeeleaves.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeleaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeeleaves->fetchObject;

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
	

if(!empty($ob->tt)){
  $obj->tt=$ob->tt;
  $obj->status=$obj->tt;
  
  if($obj->tt=="sent back"){
    $obj->action="Send Back";
  }elseif($obj->tt=="declined"){
    $obj->action="Decline";
  }elseif($obj->tt=="granted"){
    $obj->action="Grant";
  }
}	
$page_title="Employeeleaves ";
include "addemployeeleaves.php";
?>