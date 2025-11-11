<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Employeeleaveapplications_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../sys/config/Config_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/leavetypes/Leavetypes_class.php");
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../hrm/employeeleavedays/Employeeleavedays_class.php");
require_once("../../hrm/leaveextensions/Leaveextensions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4231";//Edit
}
else{
	$auth->roleid="4229";//Add
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
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
if($_GET['documentno']){
$id=$_GET['documentno'];
}

if($obj->action=="Save"){
	$employeeleaveapplications=new Employeeleaveapplications();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$employeeleaveapplications->validate($obj);
	
	$year=date('Y');
	$today=date('Y-m-d');
	
	$firstday=date("Y-m-d",mktime(0,0,0,1,1,$year));
	$lastday=date("Y-m-d",mktime(0,0,0,12,31,$year));
	
	$str=(strtotime($today)) - (strtotime($firstday));
        $totaldays=floor($str/3600/24);
        	
	$leavetypes = new Leavetypes();
	$fields="*";
	$where=" where id='$obj->leavetypeid' ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavetypes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$leavetypes=$leavetypes->fetchObject;
	
	$employ= new Employees();
	$fields="*";
	$where=" where id='$obj->leavetypeid' ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employ->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$employ=$employ->fetchObject;	
	
	$accruedleavedays=round(($totaldays*($leavetypes->earningrate/30)),0);
	
	if($leavetypes->earningrate==0)
	   $accruedleavedays=$leavetypes->noofdays;
	
	$employeeleaveapplicationss = new Employeeleaveapplications();
	$fields=" case when sum(duration) is null then 0 else sum(duration) end days";
	$where=" where leavetypeid='$obj->leavetypeid' and employeeid='$obj->employeeid' and status='granted' and enddate<'$today' ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeleaveapplicationss->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $employeeleaveapplication->sql;
	$employeeleaveapplicationss=$employeeleaveapplicationss->fetchObject;
	
	$employeeleaveapplicationdays=0; 
	
	$employeeleaveapplication = new Employeeleaveapplications();
	$fields=" * ";
	$where=" where leavetypeid='$obj->leavetypeid' and employeeid='$obj->employeeid' and status='granted' and startdate between '$firstday' and '$lastday' ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeleaveapplication->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $employeeleaveapplication->sql;
	$res=$employeeleaveapplication->result;
	while($row=mysql_fetch_object($res)){
	
	      $leaveextensions = new Leaveextensions();
	      $fields=" case when sum(days) is null then 0 else sum(days) end days";
	      $where=" where employeeleaveapplicationid='$row->id' and type='Extension' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $leaveextensions->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $leaveextensions->sql;
	      $leaveextensions=$leaveextensions->fetchObject;
	      
	      $leaveextension = new Leaveextensions();
	      $fields=" case when sum(days) is null then 0 else sum(days) end days";
	      $where=" where employeeleaveapplicationid='$row->id' and type='Recalling' ";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $leaveextension->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $employeeleavedays->sql;
	      $leaveextension=$leaveextension->fetchObject;
	      
	      $employeeleaveapplicationdays+=$row->duration+$leaveextensions->days-$leaveextension->days;
	
	}
// 	echo $employeeleaveapplicationdays.' days';
	
	$employeeleavedays = new Employeeleavedays();
	$fields=" case when sum(days) is null then 0 else sum(days) end days";
	$where=" where leavetypeid='$obj->leavetypeid' and employeeid='$obj->employeeid' and year='$year' ";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeleavedays->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $employeeleavedays->sql;
	$employeeleavedays=$employeeleavedays->fetchObject;

 	//echo $accruedleavedays.'+'.$employeeleavedays->days.'-'.$employeeleaveapplicationdays;
	  
	if(!empty($error)){
		$error=$error;
	}/*elseif($leavetypes->gender!='Both' and $employ->gender!=$leavetypes->gender){
	       $error=$leavetypes->name." is only allowed for ".$leavetypes->gender;
	}elseif(($accruedleavedays-$employeeleaveapplicationdays)<$obj->duration and $employeeleavedays->days==0){
	       $error="Your Accrued Leave days to todate is ".($accruedleavedays-$employeeleaveapplication->days).' Days';
	}elseif($employeeleavedays->days!=0 and ($accruedleavedays+$employeeleavedays->days-$employeeleaveapplicationdays)<$obj->duration){
	       $error="Your Accrued Leave days to todate is ".($accruedleavedays+$employeeleavedays->days-$employeeleaveapplicationdays).' Days';
	}elseif($accruedleavedays<$obj->duration and $employeeleavedays->days==0){
	       $error="Your Accrued Leave days to todate year is ".$accruedleavedays.' Days';
	}elseif($employeeleavedays->days!=0 and ($accruedleavedays+$employeeleavedays->days)<$obj->duration){
	       $error="Your Accrued Leave days to todate are ".($accruedleavedays+$employeeleavedays->days).' Days';
	}
	elseif($employeeleavedays->days!=0 and ($leavetypes->noofdays+$employeeleavedays->days)<$obj->duration){
	       $error="Your Maximum Leave days This year is ".($leavetypes->noofdays+$employeeleavedays->days).' Days';
	}*/
	else{
		$employeeleaveapplications=$employeeleaveapplications->setObject($obj);
		if($employeeleaveapplications->add($employeeleaveapplications)){
			$error=SUCCESS;
			redirect("addemployeeleaveapplications_proc.php?id=".$employeeleaveapplications->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeeleaveapplications=new Employeeleaveapplications();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeeleaveapplications->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeleaveapplications=$employeeleaveapplications->setObject($obj);
		if($employeeleaveapplications->edit($employeeleaveapplications)){
			$error=UPDATESUCCESS;
			redirect("addemployeeleaveapplications_proc.php?id=".$employeeleaveapplications->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.type, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.pensiondate, hrm_employees.medschemedate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.dlicence, hrm_employees.mobile, hrm_employees.phoneno, hrm_employees.workphoneno, hrm_employees.extension, hrm_employees.fax, hrm_employees.email, hrm_employees.officemail, hrm_employees.postaladdress, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.nationalityid2, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.disabled, hrm_employees.disabilitydetails, hrm_employees.medschemecode, hrm_employees.medschemeno, hrm_employees.marital, hrm_employees.religionid, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.hubid, hrm_employees.departmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$leavetypes= new Leavetypes();
	$fields="hrm_leavetypes.id, hrm_leavetypes.type, hrm_leavetypes.maxcf, hrm_leavetypes.earningrate, hrm_leavetypes.remarks, hrm_leavetypes.ipaddress, hrm_leavetypes.createdby, hrm_leavetypes.createdon, hrm_leavetypes.lasteditedby, hrm_leavetypes.lasteditedon, hrm_leavetypes.per";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeeleaveapplications=new Employeeleaveapplications();
	$where=" where hrm_employeeleaveapplications.id=$id ";
	$fields=" hrm_employeeleaveapplications.*,concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) employeename,concat(concat(hr.firstname,' ',hr.middlename),' ',hr.lastname) employeename1 ";
	$join=" left join hrm_employees on hrm_employees.id=hrm_employeeleaveapplications.employeeid left join hrm_employees as hr on hr.id=hrm_employeeleaveapplications.employeeid1 ";
	$having="";
	$groupby="";
	$orderby="";
	$employeeleaveapplications->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeeleaveapplications->sql;
	$obj=$employeeleaveapplications->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->status="pending";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='hrm_employeeleaveapplications' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addemployeeleaveapplications.php";
?>