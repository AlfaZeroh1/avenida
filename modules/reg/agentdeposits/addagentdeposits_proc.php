<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agentdeposits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../reg/agents/Agents_class.php");
require_once("../../fn/banks/Banks_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
require_once("../../sys/transactions/Transactions_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8409";//Edit
}
else{
	$auth->roleid="8407";//Add
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
	
	
if($obj->action=="Save"){
	$agentdeposits=new Agentdeposits();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$agentdeposits->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$agentdeposits=$agentdeposits->setObject($obj);
		if($agentdeposits->add($agentdeposits)){

			//Make a journal entry

			//retrieve account to debit
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='1' and acctypeid='35'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;

			//retrieve account to credit
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='1' and acctypeid='24'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

			//Get transaction Identity
			$transaction = new Transactions();
			$fields="*";
			$where=" where lower(replace(name,' ',''))='deposit'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$transaction=$transaction->fetchObject;

			$ob->transactdate=$obj->depositedon;

			//make debit entry
			$generaljournal = new Generaljournals();
			$ob->tid=$agentdeposits->id;
			$ob->documentno="$obj->slipno";
			$ob->remarks="Agent Deposit slipno $obj->slipno";
			$ob->memo=$agentdeposits->remarks;
			$ob->accountid=$generaljournalaccounts->id;
			$ob->daccountid=$generaljournalaccounts2->id;
			$ob->transactionid=$transaction->id;
			$ob->mode="credit";
			$ob->debit=$obj->amount;
			$ob->credit=0;
			$generaljournal->setObject($ob);
			$generaljournal->add($generaljournal);

			//make credit entry
			$generaljournal2 = new Generaljournals();
			$ob->tid=$agentdeposits->id;
			$ob->documentno=$obj->slipno;
			$ob->remarks="Agent Deposit slipno $obj->slipno";
			$ob->memo=$agentdeposits->remarks;
			$ob->daccountid=$generaljournalaccounts->id;
			$ob->accountid=$generaljournalaccounts2->id;
			$ob->transactionid=$transaction->id;
			$ob->mode="credit";
			$ob->debit=0;
			$ob->credit=$obj->amount;
			$ob->did=$generaljournal->id;
			$generaljournal2->setObject($ob);
			$generaljournal2->add($generaljournal2);

			$generaljournal->did=$generaljournal2->id;
			$generaljournal->edit($generaljournal);

			$error=SUCCESS;
			redirect("addagentdeposits_proc.php?id=".$agentdeposits->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$agentdeposits=new Agentdeposits();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$agentdeposits->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$agentdeposits=$agentdeposits->setObject($obj);
		if($agentdeposits->edit($agentdeposits)){

			//Make a journal entry

			//retrieve account to debit
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='1' and acctypeid='35'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts=$generaljournalaccounts->fetchObject;

			//retrieve account to credit
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='1' and acctypeid='24'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
			$error=UPDATESUCCESS;
			redirect("addagentdeposits_proc.php?id=".$agentdeposits->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$agents= new Agents();
	$fields="reg_agents.id, reg_agents.name, reg_agents.agentid, reg_agents.agenttypeid, reg_agents.regionid, reg_agents.subregionid, reg_agents.contactperson, reg_agents.tel, reg_agents.mobile, reg_agents.email, reg_agents.remarks, reg_agents.ipaddress, reg_agents.createdby, reg_agents.createdon, reg_agents.lasteditedby, reg_agents.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$banks= new Banks();
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$agentdeposits=new Agentdeposits();
	$where=" where id=$id ";
	$fields="reg_agentdeposits.id, reg_agentdeposits.agentid, reg_agentdeposits.bankid, reg_agentdeposits.depositedon, reg_agentdeposits.amount, reg_agentdeposits.slipno, reg_agentdeposits.file, reg_agentdeposits.ipaddress, reg_agentdeposits.createdby, reg_agentdeposits.createdon, reg_agentdeposits.lasteditedby, reg_agentdeposits.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agentdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$agentdeposits->fetchObject;

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
	
	
$page_title="Agentdeposits ";
include "addagentdeposits.php";
?>