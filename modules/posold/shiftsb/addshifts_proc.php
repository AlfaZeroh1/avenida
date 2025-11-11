<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Shifts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/teams/Teams_class.php");
require_once("../../pos/branchteams/Branchteams_class.php");
require_once("../../pos/teamdetails/Teamdetails_class.php");
require_once("../../sys/branches/Branches_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11917";//Edit
}
else{
	$auth->roleid="11915";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

if(!empty($ob->personnel)){
  $obj->personnel=$ob->personnel;
}

if(!empty($ob->brancheid)){
  $obj->brancheid=$ob->brancheid;
  
  $query="select * from sys_branches where id='$obj->brancheid'";
  $rw=mysql_fetch_object(mysql_query($query));
  
  $obj->branchname=$rw->name;
  
  
}

if(empty($obj->action)){
  $obj->starttime=date("Y-m-d H:i:s");
}

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}

if($obj->action=="NEW SHIFT"){
  //constitute team
  
  $teams = new Teams();
  $teams->startedon=$obj->starttime;
  $teams = $teams->setObject($teams);
  $teams->add($teams);
  
  
  //team details
  
  $i=0;
  $brancheteams = new Branchteams();
  $fields="*, pos_teamroles.id teamroleid";
  $join=" left join pos_teamroles on pos_teamroles.id=pos_branchteams.teamroleid ";
  $having="";
  $groupby="";
  $orderby="";
  $where =" where pos_branchteams.brancheid='$obj->brancheid' ";
  $brancheteams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $res=$brancheteams->result;
  while($row=mysql_fetch_object($res)){
    $x=0;
    while($x<$row->number){
      
    $employee="employeeid".$i;
    
    if(!empty($obj->$employee)){
           
      $teamdetails = new Teamdetails();
      $teamdetails->teamid=$teams->id;
      $teamdetails->employeeid=$obj->$employee;
      $teamdetails->teamroleid=$row->teamroleid;
      $teamdetails = $teamdetails->setObject($teamdetails);
      
      $teamdetails->add($teamdetails);
    }
    $x++;
    $i++;
   }
  }
  
  //open shift and assign team to shift
  $shifts = new Shifts();
  $shifts->teamid=$teams->id;
  $shifts->brancheid=$obj->brancheid;
  $shifts->starttime=$obj->starttime;
  $shifts = $shifts->setObject($shifts);
  $shifts->add($shifts);
  
  
  
  //tie shift to location
  redirect("shifts.php");
}

if($obj->action=="CLEAR"){
  $query="update pos_shifts set ordered='$obj->ordered', paid='$obj->paid', balance='$obj->balance', status=1, submitted='$obj->submitted' where id='$obj->id'";
  mysql_query($query);
}
	
if($obj->action=="Save"){
	$shifts=new Shifts();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$shifts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$shifts=$shifts->setObject($obj);
		if($shifts->add($shifts)){
			$error=SUCCESS;
			redirect("addshifts_proc.php?id=".$shifts->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$shifts=new Shifts();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$shifts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$shifts=$shifts->setObject($obj);
		if($shifts->edit($shifts)){
			$error=UPDATESUCCESS;
			redirect("addshifts_proc.php?id=".$shifts->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$teams= new Teams();
	$fields="pos_teams.id, pos_teams.brancheid, pos_teams.shiftid, pos_teams.startedon, pos_teams.endedon, pos_teams.teamedon, pos_teams.remarks, pos_teams.ipaddress, pos_teams.createdby, pos_teams.createdon, pos_teams.lasteditedby, pos_teams.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$branches= new Branches();
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.type, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$shifts=new Shifts();
	$where=" where id=$id ";
	$fields="pos_shifts.id, pos_shifts.teamid, pos_shifts.brancheid, pos_shifts.name, pos_shifts.starttime, pos_shifts.enddate, pos_shifts.remarks, pos_shifts.ipaddress, pos_shifts.createdby, pos_shifts.createdon, pos_shifts.lasteditedby, pos_shifts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$shifts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$shifts->fetchObject;
	
	
	//get amounts
	if(!empty($ob->type)){
	  $query="select sum(pos_orderdetails.price*pos_orderdetails.quantity) amount,sum(pos_orderpayments.amount) paid from pos_orders left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join pos_orderpayments on pos_orderpayments.orderid=pos_orders.id where pos_orders.shiftid='$id'";
	  $rw=mysql_fetch_object(mysql_query($query));
	  
	  $balance=$rw->amount-$rw->paid;
	  
	  $obj->ordered=$rw->amount;
	  $obj->paid=$rw->paid;
	  $obj->balance=$balance;
// 	  $obj->submitted=$rw->paid;
	}

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
// 		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
if(!empty($ob->id)){
  $obj->shiftid=$ob->id;
}

$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='pos_shifts' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;

if(!empty($ob->type))
  $obj->type=$ob->type;

if(empty($obj->type))
  include "addshifts.php";
else
  include "add.php";
?>