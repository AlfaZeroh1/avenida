<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Teamdetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../pos/teamroles/Teamroles_class.php");
require_once("../../pos/teams/Teams_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");
require_once("../../sys/paymentcategorys/Paymentcategorys_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../pos/teampayments/Teampayments_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9486";//Edit
}
else{
	$auth->roleid="9486";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;



if(!empty($ob->brancheid2)){
  $obj->brancheid=$ob->brancheid2;
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

if(!empty($ob->delid)){
  $query="delete from pos_teampayments where id='$ob->delid'";
  mysql_query($query);
}
	
if($obj->action2=="ADD"){
  
  if(empty($obj->paymentmodeid)){
    $error="Payment Mode must be selected!";
  }elseif(empty($obj->paid)){
    $error="Amount must be provided!";
  }else{
  
    $obj->createdby=$_SESSION['userid'];
    $obj->createdon=date("Y-m-d H:i:s");
    $obj->lasteditedby=$_SESSION['userid'];
    $obj->lasteditedon=date("Y-m-d H:i:s");
    $obj->ipaddress=$_SERVER['REMOTE_ADDR'];
    
    $teampayments = new Teampayments();
    $obj->teamdetailid=$obj->id;
    $obj->amount=$obj->paid;
    $obj->id="";
    $teampayments = $teampayments->setObject($obj);
   
    if($teampayments->add($teampayments)){    
      $saved="Yes";
      $error="SUCCESS";
    }
    
  }
  $obj->paymentmodeid="";
  $obj->paid=0;
  $obj->remarks="";
}

if($obj->action=="Effect Journals"){
  
  $query="select t.teamedon from pos_teamdetails td left join pos_teams t on td.teamid=t.id where td.id='$obj->id'";
  $r = mysql_fetch_object(mysql_query($query));
  
  $query="select * from pos_teampayments where cashier='1' and teamdetailid='$obj->id'";
  $res = mysql_query($query);
  
  $obj->documentno=$obj->id;
  $obj->transactdate=$r->teamedon;
  
  $it=0;
  $shpgeneraljournals = array();
  $total=0;
  
  while($row=mysql_fetch_object($res)){
  
    $obj->amount=$row->amount;
    
    $paymentmodes = new Paymentmodes();
    $fields=" * ";
    $having="";
    $groupby="";
    $orderby="";
    $where=" where id='$row->paymentmodeid'";
    $join=" ";
    $paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    $paymentmodes = $paymentmodes->fetchObject;
    
    if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
      $obj->bankid=$obj->imprestaccountid;
      
    if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
	    $obj->bankid=1;
    }
  
    $generaljournalaccounts = new Generaljournalaccounts();
    $fields="*";
    $where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    $generaljournalaccounts=$generaljournalaccounts->fetchObject;
    
    $generaljournal = new Generaljournals();
    $ob->tid=$sales->id;
    $ob->documentno="$obj->documentno";
    $ob->remarks="Cashier Clearance: ".$obj->employeename;
    $ob->memo=$obj->memo;
//     $ob->remarks=$obj->remarks;
    $ob->accountid=$generaljournalaccounts->id;
    $ob->daccountid=$generaljournalaccounts2->id;
    $ob->transactionid=$transaction->id;
    $ob->mode="credit";
    $ob->debit=$obj->amount;
    $ob->balance=$obj->amount;
    $ob->credit=0;
    $generaljournal = $generaljournal->setObject($ob);
    
    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name",'documentno'=>"$generaljournal->documentno", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total", 'transactdate'=>"$ob->transactdate",'balance'=>"$generaljournal->balance",'transactionid'=>"$generaljournal->transactionid");
    
    $it++;
    
    $total+=$obj->amount;
    
  }
  
  	    //retrieve account to credit
    $generaljournalaccounts2 = new Generaljournalaccounts();
    $fields="*";
    $where=" where refid='1' and acctypeid='25'";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
    
    $generaljournal = new Generaljournals();
    $ob->tid=$sales->id;
    $ob->documentno="$obj->documentno";
    $ob->remarks="Cashier Clearance: ".$obj->employeename;
    $ob->memo=$obj->memo;
//     $ob->remarks=$obj->remarks;
    $ob->accountid=$generaljournalaccounts2->id;
    $ob->daccountid=$generaljournalaccounts2->id;
    $ob->transactionid=$transaction->id;
    $ob->mode="credit";
    $ob->credit=$total;
    $ob->balance=$total;
    $ob->debit=0;
    $generaljournal = $generaljournal->setObject($ob);
    
    $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name",'documentno'=>"$generaljournal->documentno", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total", 'transactdate'=>"$ob->transactdate",'balance'=>"$generaljournal->balance",'transactionid'=>"$generaljournal->transactionid");
    
    $obj->documentno=$obj->id;
    $obj->transactdate=$r->teamedon;
    $obj->currencyid=5;
    $obj->exchangerate=1;
    
    $gn = new Generaljournals();
    $gn->add($obj, $shpgeneraljournals,true);
  
}
	
if($obj->action=="Save"){
	$teamdetails=new Teamdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$teamdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teamdetails=$teamdetails->setObject($obj);
		if($teamdetails->add($teamdetails)){
			$error=SUCCESS;
			redirect("addteamdetails_proc.php?id=".$teamdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$teamdetails=new Teamdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$teamdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$teamdetails=$teamdetails->setObject($obj);
		if($teamdetails->edit($teamdetails)){
			$error=UPDATESUCCESS;
// 			redirect("addteamdetails_proc.php?id=".$teamdetails->id."&error=".$error);
			if(!empty($obj->submitted)){
			  $query=" insert into pos_teamdetailclearances(teamdetailid,brancheid,submitted,short) values('$obj->id','$obj->brancheid','$obj->submitted','$obj->short') ";
			  mysql_query($query);
			}
			
			$saved="Yes";
			$itemdetailid=$teamdetails->id;
			$brancheid = $obj->brancheid;
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


	$teamroles= new Teamroles();
	$fields="pos_teamroles.id, pos_teamroles.name, pos_teamroles.remarks, pos_teamroles.ipaddress, pos_teamroles.createdby, pos_teamroles.createdon, pos_teamroles.lasteditedby, pos_teamroles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teamroles->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$teams= new Teams();
	$fields="pos_teams.id, pos_teams.brancheid, pos_teams.shiftid, pos_teams.startedon, pos_teams.endedon, pos_teams.teamedon, pos_teams.remarks, pos_teams.ipaddress, pos_teams.createdby, pos_teams.createdon, pos_teams.lasteditedby, pos_teams.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$teamdetails=new Teamdetails();
	
	if($ob->cashier==1)
	  $where=" where pos_teamdetails.id in($id) and pos_orders.brancheid2='$ob->brancheid2' and pos_orders.status=1 and pos_teamdetails.employeeid='$ob->employeeid' ";
	else
	  $where=" where pos_teamdetails.id in($id) and pos_orders.brancheid2='$ob->brancheid2' and pos_orders.status=1 ";
	
	$fields="pos_teamdetails.id, pos_teamdetails.teamid, pos_teamdetails.teamroleid, pos_teamdetails.employeeid, concat(hrm_employees.firstname, ' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename, pos_teamdetails.remarks, pos_teamdetails.ipaddress, pos_teamdetails.createdby, pos_teamdetails.createdon, pos_teamdetails.lasteditedby, pos_teamdetails.lasteditedon, auth_users.id userid, pos_teamdetails.submitted, pos_teamdetails.short, sum(pos_orderdetails.quantity*pos_orderdetails.price) amount, pos_teams.brancheid";
	$join=" left join hrm_employees on hrm_employees.id=pos_teamdetails.employeeid left join auth_users on auth_users.employeeid=hrm_employees.id left join pos_orders on pos_orders.createdby=auth_users.id and pos_orders.shiftid=pos_teamdetails.teamid left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join pos_teams on pos_teams.id=pos_teamdetails.teamid  ";
	if($ob->cashier==1)
	  $having="";
	else
	  $having=" having amount>0 ";
	$groupby="";
	$orderby="";
	$teamdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $teamdetails->sql."<br/>";
	$obj=$teamdetails->fetchObject;
	
	if(!empty($ob->cashier))
	  $obj->id=$ob->id;
	
	if(empty($ob->cashier))
	  $query="select sum(pos_orderdetails.price*pos_orderdetails.quantity) amount,sum(pos_orderpayments.amount) paid from pos_orders left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join pos_orderpayments on pos_orderpayments.orderid=pos_orders.id where pos_orders.shiftid in($obj->teamid) and pos_orders.createdby='$obj->userid' and pos_orders.brancheid2='$ob->brancheid2' and pos_orders.status=1 ";
	else
	  $query="select sum(pos_teampayments.amount) amount from pos_teamdetails left join pos_teampayments on pos_teamdetails.id=pos_teampayments.teamdetailid where pos_teampayments.brancheid='$ob->brancheid2' and pos_teamdetails.teamid in($obj->teamid) and pos_teampayments.cashier=0";
		
	$rw=mysql_fetch_object(mysql_query($query));
	
	if(empty($ob->cashier))
	  $rw->amount = $obj->amount;
// 	$rw->paid = $obj->paid;
	
	//get amount remitted already
	$query="select case when sum(submitted) is null then 0 else sum(submitted) end submitted from pos_teamdetailclearances where teamdetailid in($ob->id) and brancheid='$ob->brancheid2' ";
	$rws=mysql_fetch_object(mysql_query($query));
	
	if(!empty($ob->cashier)){
	  $query="select sum(pos_teampayments.amount) amount from pos_teamdetails left join pos_teampayments on pos_teamdetails.id=pos_teampayments.teamdetailid where pos_teampayments.brancheid='$ob->brancheid2' and pos_teamdetails.teamid in($obj->teamid) and pos_teampayments.cashier=1";	  
	}else{
	  $query="select case when sum(amount) is null then 0 else sum(amount) end amount from pos_teampayments where teamdetailid='$obj->id' and brancheid='$ob->brancheid2'";
	}//echo $query;
	$r=mysql_fetch_object(mysql_query($query));
	
	if(empty($ob->cashier)){
	  
	  $balance=$rw->amount-($rw->paid+$rws->submitted+$r->amount);	
	  $obj->ordered=$rw->amount;
	  $obj->paid=$rw->paid;
	  $obj->balance=$balance;
	  
	}else{
	  
	  $query="select pos_teams.* from pos_teams left join pos_teamdetails on pos_teams.id=pos_teamdetails.teamid where pos_teamdetails.id='$obj->id'";
	  $teams = mysql_fetch_object(mysql_query($query));
	  
	  $query="select sum(amount) amount from fn_imprests where employeeid in($obj->employeeid) and issuedon='$teams->teamedon'";
	  $float = mysql_fetch_object(mysql_query($query));
	  
	  $obj->float = $float->amount;
	  
	  $balance=$rw->amount+$obj->float-$r->amount;
	  $obj->balance=$balance;
	  $obj->ordered=$rw->amount;
	  $obj->paid=0;
	  
	}
	
	$obj->submitted=0;
	
	$obj->short=$balance;
	
	$brancheid=$ob->brancheid2;

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
if(!empty($ob->brancheid2)){
  $obj->brancheid=$ob->brancheid2;
}	

if(!empty($ob->cashier)){
  $obj->cashier=$ob->cashier;
}

$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='pos_teamdetails' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addteamdetails.php";
?>