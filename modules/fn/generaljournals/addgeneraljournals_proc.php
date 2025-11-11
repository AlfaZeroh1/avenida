<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Generaljournals_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../sys/currencys/Currencys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="761";//Edit
}
else{
	$auth->roleid="759";//Add
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
	$obj->rjvno=$ob->documentno;
	$obj->action="Filter";
}
	
if(empty($obj->action) and empty($obj->action2)){
	$obj->transactdate=date('Y-m-d');
	//get jvno
		$generaljournals = new Generaljournals();
		$fields="case when max(jvno+1) is null then 1 else max(jvno+1) end jvno";
		$join="";
		$where="";
		$having="";
		$orderby="";
		$groupby="";
		$generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournals=$generaljournals->fetchObject;
		$obj->jvno=$generaljournals->jvno;

}
	
if($obj->action=="Save"){
	$generaljournals=new Generaljournals();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	
	$obj->rate=$obj->exchangerate;
	$obj->eurorate=$obj->exchangerate2;
// 	print_r($obj);
	$shpgeneraljournals=$_SESSION['shpgeneraljournals'];
	$error=$generaljournals->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	elseif(empty($shpgeneraljournals)){
		$error="No items in the sale list!";
	}
	else{
		$generaljournals=$generaljournals->setObject($obj);//echo $obj->drtotals;
		if($generaljournals->add($generaljournals,$shpgeneraljournals,false,true,true)){
			$error=SUCCESS;
			unset($_SESSION['shpgeneraljournals']);
			redirect("addgeneraljournals_proc.php?error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$generaljournals=new Generaljournals();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$generaljournals->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$obj->rate=$obj->exchangerate;
		$obj->eurorate=$obj->exchangerate2;
		
		$generaljournals=$generaljournals->setObject($obj);
		$shpgeneraljournals=$_SESSION['shpgeneraljournals'];
		if($generaljournals->edit($generaljournals,$where="",$shpgeneraljournals)){
			$error=UPDATESUCCESS;
			unset($_SESSION['shpgeneraljournals']);
			redirect("addgeneraljournals_proc.php?id=&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if($obj->action2=="Add"){

	if(empty($obj->accountid)){
		$error="Account must be provided";
	}
	elseif(empty($obj->memo)){
		$error="Memo must be provided";
	}
	else{
	$_SESSION['obj']=$obj;
	if(empty($obj->iterator))
		$it=0;
	else
		$it=$obj->iterator;
	$shpgeneraljournals=$_SESSION['shpgeneraljournals'];

	$generaljournalaccounts = new Generaljournalaccounts();
	$fields=" fn_generaljournalaccounts.*, sys_acctypes.name acctypename ";
	$join=" left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid ";
	$groupby="";
	$having="";
	$where=" where fn_generaljournalaccounts.id='$obj->accountid'";
	$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	$generaljournalaccounts=$generaljournalaccounts->fetchObject;

	$obj->debitkshs = $obj->debit*$obj->exchangerate;
	$obj->creditkshs = $obj->credit*$obj->exchangerate;
	
	$query="select * from sys_currencys where id='$obj->currencyid'";
	$cur = mysql_fetch_object(mysql_query($query));
	$obj->currencyname=$cur->name;
	
	$shpgeneraljournals[$it]=array('accountid'=>"$obj->accountid", 'accountname'=>"$generaljournalaccounts->name", 'accounttype'=>"$generaljournalaccounts->acctypename", 'memo'=>"$obj->memo", 'debit'=>"$obj->debit", 'credit'=>"$obj->credit", 'total'=>"$obj->total",'jvno'=>"$obj->jvno",'transactdate'=>"$obj->transactdate",'currencyid'=>"$obj->currencyid",'currencyname'=>"$obj->currencyname",'exchangerate'=>"$obj->exchangerate",'exchangerate2'=>"$obj->exchangerate2",'rate'=>"$obj->exchangerate",'eurorate'=>"$obj->exchangerate2", 'debitkshs'=>"$obj->debitkshs", 'creditkshs'=>"$obj->creditkshs",'documentno'=>"$obj->documentno", 'transactionid'=>"$obj->transactionid",'balance'=>"$obj->balance",'reconstatus'=>"$obj->reconstatus",'recondate'=>"$obj->recondate",'recontime'=>"$obj->recontime");

 	$it++;
		$obj->iterator=$it;
 	$_SESSION['shpgeneraljournals']=$shpgeneraljournals;

	$obj->accountname="";
 	$obj->accountid="";
 	$obj->total=0;
	$obj->memo="";
 	$obj->debit="";
 	$obj->credit="";
 }
}

if(empty($obj->action)){

	$generaljournalaccounts= new Generaljournalaccounts();
	$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.refid, fn_generaljournalaccounts.code, fn_generaljournalaccounts.name, fn_generaljournalaccounts.acctypeid, fn_generaljournalaccounts.categoryid, fn_generaljournalaccounts.ipaddress, fn_generaljournalaccounts.createdby, fn_generaljournalaccounts.createdon, fn_generaljournalaccounts.lasteditedby, fn_generaljournalaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$generaljournals=new Generaljournals();
	$where=" where id=$id ";
	$fields="fn_generaljournals.id, fn_generaljournals.accountid, fn_generaljournals.daccountid, fn_generaljournals.tid, fn_generaljournals.documentno, fn_generaljournals.mode, fn_generaljournals.transactionid, fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.class, fn_generaljournals.ipaddress, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$generaljournals->fetchObject;

	//for autocompletes
	$generaljournalaccounts = new Generaljournalaccounts();
	$fields=" * ";
	$where=" where id='$obj->accountid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$generaljournalaccounts->fetchObject;

	$obj->accountname=$auto->name;
}

if($obj->action=="Filter"){
	if(!empty($obj->rjvno)){
		$generaljournals = new Generaljournals();
		$fields="fn_generaljournals.id, fn_generaljournalaccounts.id as accountid,fn_generaljournalaccounts.name as account, fn_generaljournals.daccountid, fn_generaljournalaccounts.categoryid, fn_generaljournals.tid,fn_generaljournals.currencyid,fn_generaljournals.rate as exchangerate,fn_generaljournals.eurorate as exchangerate2,    fn_generaljournals.documentno, fn_generaljournals.mode, fn_generaljournals.transactionid, fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.recontime, fn_generaljournals.class, fn_generaljournals.ipaddress, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon, sys_acctypes.name acctypeid, sys_currencys.name currencyname";
		$join=" left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join sys_currencys on sys_currencys.id=fn_generaljournals.currencyid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_generaljournals.jvno='$obj->rjvno' ";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$generaljournals->result;
		$it=0;
		while($row=mysql_fetch_object($res)){
				
			
			$query="select * from fn_generaljournalaccounts where id='$row->categoryid'";
			$r = mysql_fetch_object(mysql_query($query));		
			
			$ob=$row;
			
			if(!empty($r->id))
			  $ob->account=$r->name." => ".$ob->account;
			  
			$ob->debitkshs=$ob->debit*$ob->exchangerate;
			$ob->creditkshs=$ob->credit*$ob->exchangerate;
			
			$shpgeneraljournals[$it]=array('id'=>"$ob->id",'accountid'=>"$ob->accountid", 'accountname'=>"$ob->account", 'memo'=>"$ob->memo", 'remarks'=>"$ob->remarks", 'debit'=>"$ob->debit", 'credit'=>"$ob->credit", 'total'=>"$ob->total",'accounttype'=>"$ob->acctypeid", 'currencyname'=>"$ob->currencyname", 'rate'=>"$ob->exchangerate", 'debitkshs'=>"$ob->debitkshs",'creditkshs'=>"$ob->creditkshs", 'transactionid'=>"$ob->transactionid",'balance'=>"$ob->balance",'reconstatus'=>"$ob->reconstatus",'recondate'=>"$ob->recondate",'recontime'=>"$ob->recontime",'documentno'=>"$ob->documentno");

			$it++;
		}

		$obj = (object) array_merge((array) $obj, (array) $ob);
		$obj->iterator=$it;
		$obj->retrieve=1;
		$obj->action='Update';
		$_SESSION['obj']=$obj;
		$_SESSION['shpgeneraljournals']=$shpgeneraljournals;
		}
}

if(empty($id) and empty($obj->action) and empty($obj->retrieve)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif((!empty($id) and empty($obj->action)) or !empty($obj->retrieve)){
	$obj->action="Update";
}
	
	
$page_title="Generaljournals ";
include "addgeneraljournals.php";
?>