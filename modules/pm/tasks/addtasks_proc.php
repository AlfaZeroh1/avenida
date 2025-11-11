<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tasks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../wf/routes/Routes_class.php");
require_once("../../hrm/assignments/Assignments_class.php");
require_once("../../pm/taskstatuss/Taskstatuss_class.php");
require_once("../../pm/tasktracks/Tasktracks_class.php");
require_once("../../wf/routedetails/Routedetails_class.php");
require_once("../../pm/notifications/Notifications_class.php");
require_once("../../pm/notificationrecipients/Notificationrecipients_class.php");
require_once("../../con/projects/Projects_class.php");
require_once("../../auth/users/Users_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8229";//Edit
}
else{
	$auth->roleid="8227";//Add
}
$auth->levelid=$_SESSION['level'];
//auth($auth);


//connect to db
$db=new DB();
$objs=(object)$_POST;
$ob=(object)$_GET;

$mode=$_GET['mode'];
if(!empty($mode)){
	$objs->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$objs->retrieve=$_GET['retrieve'];
}
	
	
if($objs->action=="Save"){
	$tasks=new Tasks();
	$objs->createdby=$_SESSION['userid'];
	$objs->createdon=date("Y-m-d H:i:s");
	$objs->lasteditedby=$_SESSION['userid'];
	$objs->lasteditedon=date("Y-m-d H:i:s");
	$objs->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tasks->validate($objs);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tasks=$tasks->setObject($objs);
		$objs->subject=$objs->name;
		$objs->body=$objs->description;
		if($tasks->add($tasks)){
			$error=SUCCESS;
			//redirect("addtasks_proc.php?id=".$tasks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($objs->action=="Update"){
	$tasks=new Tasks();
	$objs->lasteditedby=$_SESSION['userid'];
	$objs->lasteditedon=date("Y-m-d H:i:s");

	$error=$tasks->validate($objs);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tasks=$tasks->setObject($objs);
		$objs->subject=$objs->name;
		$objs->body=$objs->description;
		if($tasks->edit($tasks)){
			$error=UPDATESUCCESS;
			redirect("addtasks_proc.php?id=".$tasks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(!empty($objs->actions)){

	$action=$objs->actions;
	$remarks=$objs->remarks;
	
	$tasks=new Tasks();
	$where=" where id=$objs->id ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$objs=$tasks->fetchObject;
	
	$objs->workflow=1;	
	
	if(empty($objs->origtask))
	  $objs->origtask=$objs->id;
	
	$tasks = new Tasks();
	
	switch($action){
	  case "Start":
	    $objs->statusid=3;
	    $objs->action="Start";
	    $statusid=$objs->statusid;
	    $tasks->setObject($objs);
	    $tasks->edit($tasks);
	    
	    $tasks->addTaskTrack($objs);
	    
	    break;
	    
	  case "Delegate":
	  //create new task for employee delegated to
	    $objs->statusid=4;
	    $objs->action="Delegate";
	    $statusid=$objs->statusid;
	    $tasks->employeeid=$objs->employee;
	    $tasks->setObject($objs);
	    $tasks->edit($tasks);
	    
	    $tasks->addTaskTrack($objs);
	    
	    
	    break;
	  case "Approve":
	  //create a new task to the next guy in wf route
	      $objs->statusid=6;
	      $objs->action="Approve";
	      $statusid=$objs->statusid;
	      $tasks->setObject($objs);
	      $tasks->edit($tasks);
	      
	      $objs->ownerid=$objs->employeeid;
	      $objs->body=$objs->description;
	      $objs->remarks=$remarks;
	      
	      $tasks->addTaskTrack($objs);
	      
	      $tasks=new Tasks();
	      $tasks->processTask($objs);
	      
	      break;
	      
	  case "Send Up":
	  //create a new task to the next guy in wf route
	      $objs->statusid=6;
	      $objs->action="Send Up";
	      $statusid=$objs->statusid;
	      $tasks->setObject($objs);
	      $tasks->edit($tasks);
	      
	      $objs->ownerid=$objs->employeeid;
	      $objs->body=$objs->description;
	      $objs->remarks=$remarks;
	      
	      $tasks->addTaskTrack($objs);
	      
	      $tasks=new Tasks();
	      $tasks->processTask($objs);
	      
	      break;
	      
	  case "Send Back":
	  //create NOTIFICATION to the creator of the document and other nodes who had approved it already
	      $objs->statusid=5;
	      $objs->action="Send Back";
	      $statusid=$objs->statusid;
	      $tasks->setObject($objs);
	      $tasks->edit($tasks);      
	      
	      $objs->employeeid=$objs->ownerid;
	      
	      $objs->name="SENT BACK: ".$objs->name;
	      $objs->body=$objs->description;
	      $objs->remarks=$remarks;
	      
	      $tasks->addTaskTrack($objs);
	      
	      $tasks=new Tasks();
	      $id = $tasks->processTask($objs);	      
	  
	      break;
	      
	  case "Decline":
	  //create NOTIFICATION to the creator of the document and other nodes who had approved it already
	      $objs->statusid=7;
	      $objs->action="Decline";
	      $statusid=$objs->statusid;
	      $tasks->setObject($objs);
	      $tasks->edit($tasks);      
	      
	      $objs->employeeid=$objs->ownerid;
	      
	      $objs->name="REJECTED: ".$objs->name;
	      $objs->body=$objs->description;
	      $objs->remarks=$remarks;
	      
	      $tasks->addTaskTrack($objs);
	      
	      $tasks=new Tasks();
	      $id = $tasks->processTask($objs);
	      
	      
	      $tsks = new Tasks();
	      //$where=" where origtask=$objs->origtask and id in(select distinct taskid from pm_tasktracks where origtask=$objs->origtask) and id not in($objs->id) ";
	      $where=" where id='$objs->id' ";
	      $fields="*";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $tsks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	      $tsks = $tsks->fetchObject;
	      
	      $tsk = new Tasks();
	      //$where=" where origtask=$objs->origtask and id in(select distinct taskid from pm_tasktracks where origtask=$objs->origtask) and id not in($objs->id) ";
	      $where=" where id='$tsks->taskid' ";
	      $fields="*";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $tsk->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	      while($st=mysql_fetch_object($tsk->result)){
		
			  require_once("../../../modules/auth/users/Users_class.php");
			  
			  if(!empty($st->employeeid)){
			    //add notification
			    $notifications = new Notifications();
			    $notifications->subject=$objs->name;//"Requisition Approval #".$objs->documentno;
			    $notifications->body=$remarks;//"A Requisition has been raised tht requires your attention";
			    $notifications->taskid=$tasks->id;
			    $notifications->createdby=$_SESSION['userid'];
			    $notifications->createdon=date("Y-m-d H:i:s");
			    $notifications->lasteditedby=$_SESSION['userid'];
			    $notifications->lasteditedon=date("Y-m-d H:i:s");
			    $notifications->ipaddress=$_SERVER['REMOTE_ADDR'];
			    $notifications->setObject($notifications);
			    $notifications->add($notifications);
			    
			    
			    //add notification recipient
			    $notificationrecipients = new Notificationrecipients();
			    $nitificationrecipients->id="";
			    $notificationrecipients->notificationid=$notifications->id;
			    $notificationrecipients->employeeid=$st->ownerid;
			    
			    $users = new Users();
			    $fields="*";
			    $where=" where id='".$_SESSION['userid']."'";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    $users = $users->fetchObject;
			    
			    $notificationrecipients->fromemployeeid=$users->employeeid;
			    $notificationrecipients->email=$objs->email;
			    $notificationrecipients->notifiedon=date("Y-m-d H:i:s");
			    $notificationrecipients->status="unread";
			    $notificationrecipients->createdby=$_SESSION['userid'];
			    $notificationrecipients->createdon=date("Y-m-d H:i:s");
			    $notificationrecipients->lasteditedby=$_SESSION['userid'];
			    $notificationrecipients->lasteditedon=date("Y-m-d H:i:s");
			    $notificationrecipients->ipaddress=$_SERVER['REMOTE_ADDR'];
			    $notificationrecipients = $notificationrecipients->setObject($notificationrecipients);
			    $notificationrecipients->add($notificationrecipients);
			  }
	      }
	  
	      break;
	  case "Finish":
	      $objs->statusid=8;
	      $tasks->setObject($objs);
	      $tasks->edit($tasks);
	      break;
	  default:
	    
	}   
    
    redirect("addtasks_proc.php?id=".$objs->id."&not=true&error=".$error);
}
if(empty($objs->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$routes= new Routes();
	$fields="wf_routes.id, wf_routes.name, wf_routes.moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$assignments= new Assignments();
	$fields="hrm_assignments.id, hrm_assignments.code, hrm_assignments.name, hrm_assignments.departmentid, hrm_assignments.levelid, hrm_assignments.remarks, hrm_assignments.createdby, hrm_assignments.createdon, hrm_assignments.lasteditedby, hrm_assignments.lasteditedon, hrm_assignments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$taskstatuss= new Taskstatuss();
	$fields="pm_taskstatuss.id, pm_taskstatuss.name, pm_taskstatuss.remarks, pm_taskstatuss.ipaddress, pm_taskstatuss.createdby, pm_taskstatuss.createdon, pm_taskstatuss.lasteditedby, pm_taskstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$taskstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$tasks=new Tasks();
	$where=" where pm_tasks.id=$id ";
	$fields="pm_tasks.id, pm_tasks.name, pm_tasks.description, pm_tasks.ownerid, wf_routes.id routeid, pm_tasks.projectid, wf_routedetails.approval, pm_tasks.routedetailid, pm_tasks.routeid, pm_tasks.projecttype, pm_tasks.employeeid, pm_tasks.assignmentid, pm_tasks.documenttype, pm_tasks.documentno, pm_tasks.priority, pm_tasks.tracktime, pm_tasks.reqduration, pm_tasks.reqdurationtype, pm_tasks.deadline, pm_tasks.startdate, pm_tasks.starttime, pm_tasks.enddate, pm_tasks.endtime, pm_tasks.duration, pm_tasks.durationtype, pm_tasks.remind, pm_tasks.taskid, pm_tasks.origtask, pm_tasks.statusid, pm_tasks.ipaddress, pm_tasks.createdby, pm_tasks.createdon, pm_tasks.lasteditedby, pm_tasks.lasteditedon";
	$join=" left join wf_routedetails on wf_routedetails.id=pm_tasks.routedetailid left join wf_routes on wf_routes.id=wf_routedetails.routeid ";
	$having="";
	$groupby="";
	$orderby="";
	$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$objs=$tasks->fetchObject;

	//for autocompletes
	$employees = new Employees();
	$fields=" * ";
	$where=" where id='$objs->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$objs->employeename=$auto->name;
	$assignments = new Assignments();
	$fields=" hrm_assignments.name, hrm_levels.name levelid ";
	$where=" where hrm_assignments.id='$objs->assignmentid'";
	$join=" left join hrm_levels on hrm_assignments.levelid=hrm_levels.id ";
	$having="";
	$groupby="";
	$orderby="";
	$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$assignments->fetchObject;
	
	$objs->assignmentname=$auto->name;
	$objs->levelname=$auto->levelid;
	
	$projects = new Projects();
	$fields=" * ";
	$where=" where id='$objs->projectid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$projects->fetchObject;

	$objs->projectname=$auto->name;
	
	$routes = new Routes();
	$fields=" * ";
	$where=" where id='$objs->routeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$routes->fetchObject;

	$objs->routename=$auto->name;
}
if(empty($id) and empty($objs->action)){
	if(empty($_GET['edit'])){
		$objs->action="Save";
		$objs->startdate=date("Y-m-d");
		$objs->starttime=date("H:m:s");
	}
	else{
		$objs=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($objs->action)){
	$objs->action="Update";
}
	
	
$page_title="Tasks ";

if($ob->not){
  //change tasks status to viewed
  if($objs->statusid==1){
    $objs->statusid=2;
    
    //update task record
    $tasks = new Tasks();
    $tasks->setObject($objs);
    $tasks->edit($tasks);
    
    if($objs->approval=="No"){
      $routes = new Routes();
      $fields=" sys_modules.name moduleid, auth_roles.module module ";
      $where=" where wf_routes.id='$objs->routeid'";
      $join=" left join auth_roles on auth_roles.id=wf_routes.roleid left join sys_modules on sys_modules.id=wf_routes.moduleid ";
      $having="";
      $groupby="";
      $orderby="";
      $routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      $routes=$routes->fetchObject;
      
      $href="../../$routes->moduleid/$routes->module/add".$routes->module."_proc.php?retrieve=1&documentno=".$objs->documentno;
      redirect($href);
    }
    
    //add task tracktime
    $tasktracks = new Tasktracks();
    $tasktracks->id=0;
    $tasktracks->taskid=$objs->taskid;
    $tasktracks->statusid=2;
    $tasktracks->changedon=date("Y-m-d H:i:s");
    $tasktracks->remarks=$objs->remarks;
    $tasktracks->add($tasktracks);
  }
  
  $notificationrecipients = new Notificationrecipients();
  $fields=" pm_notifications.taskid,pm_notificationrecipients.* ";
  $where=" where pm_notifications.taskid='$objs->id'";
  $join=" left join pm_notifications on pm_notifications.id=pm_notificationrecipients.notificationid ";
  $having="";
  $groupby="";
  $orderby="";
  $notificationrecipients->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $notificationrecipients = $notificationrecipients->fetchObject;
  
  $not = new Notificationrecipients();  
  $notificationrecipients->status="read";
  $not = $not->setObject($notificationrecipients);
  $not->edit($not);
  
  include "addtask.php";
}
else
  include "addtasks.php";
?>