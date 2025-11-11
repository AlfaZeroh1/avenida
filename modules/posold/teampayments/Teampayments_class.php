<?php 
require_once("TeampaymentsDBO.php");
class Teampayments
{				
	var $id;			
	var $teamdetailid;			
	var $cashier;			
	var $brancheid;			
	var $paymentmodeid;			
	var $bankid;			
	var $imprestaccountid;			
	var $amount;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $teampaymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->teamdetailid=str_replace("'","\'",$obj->teamdetailid);
		$this->cashier=str_replace("'","\'",$obj->cashier);
		$this->brancheid=str_replace("'","\'",$obj->brancheid);
		$this->paymentmodeid=str_replace("'","\'",$obj->paymentmodeid);
		$this->bankid=str_replace("'","\'",$obj->bankid);
		$this->imprestaccountid=str_replace("'","\'",$obj->imprestaccountid);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get teamdetailid
	function getTeamdetailid(){
		return $this->teamdetailid;
	}
	//set teamdetailid
	function setTeamdetailid($teamdetailid){
		$this->teamdetailid=$teamdetailid;
	}

	//get cashier
	function getCashier(){
		return $this->cashier;
	}
	//set cashier
	function setCashier($cashier){
		$this->cashier=$cashier;
	}

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
	}

	//get paymentmodeid
	function getPaymentmodeid(){
		return $this->paymentmodeid;
	}
	//set paymentmodeid
	function setPaymentmodeid($paymentmodeid){
		$this->paymentmodeid=$paymentmodeid;
	}

	//get bankid
	function getBankid(){
		return $this->bankid;
	}
	//set bankid
	function setBankid($bankid){
		$this->bankid=$bankid;
	}

	//get imprestaccountid
	function getImprestaccountid(){
		return $this->imprestaccountid;
	}
	//set imprestaccountid
	function setImprestaccountid($imprestaccountid){
		$this->imprestaccountid=$imprestaccountid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	function add($obj){
		$teampaymentsDBO = new TeampaymentsDBO();
		if($teampaymentsDBO->persist($obj)){
			
			$it=0;
			$shpgeneraljournals = array();
			
			$query="select t.teamedon, t.brancheid from pos_teamdetails td left join pos_teams t on td.teamid=t.id where td.id='$obj->teamdetailid'";
			$r = mysql_fetch_object(mysql_query($query));
			
			$obj->documentno=$obj->itemdetailid;
			$obj->transactdate=$r->teamedon;
			$obj->currencyid=5;
			$obj->exchangerate=1;
			
			$paymentmodes = new Paymentmodes();
			$fields=" * ";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id='$obj->paymentmodeid'";
			$join=" ";
			$paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$paymentmodes = $paymentmodes->fetchObject;
			
			if(!empty($obj->imprestaccountid) and !is_null($obj->imprestaccountid))
			  $obj->bankid=$obj->imprestaccountid;
			  
			if(empty($obj->bankid) or is_null($obj->bankid) or $obj->bankid=="NULL"){
				$obj->bankid=1;
			}
			
			if(empty($obj->cashier)){
			  $query="select * from fn_imprestaccounts where brancheid='$r->brancheid'";
			  $rw = mysql_fetch_object(mysql_query($query));
			  
			  $obj->bankid=$rw->id;
			  $paymentmodes->acctypeid=24;
			}
		      
			$generaljournalaccounts = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->bankid' and acctypeid='$paymentmodes->acctypeid'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);echo $generaljournalaccounts->sql;
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
			
				    //retrieve account to credit
			$generaljournalaccounts2 = new Generaljournalaccounts();
			$fields="*";
			if(empty($obj->cashier))
			  $where=" where refid='1' and acctypeid='25'";
			else{
			  $query="select * from fn_imprestaccounts where brancheid='$r->brancheid'";echo $query;
			  $rw = mysql_fetch_object(mysql_query($query));
			  
			  $obj->bankid=$rw->id;
			  $paymentmodes->acctypeid=24;
			  
			  $where=" where refid='$obj->bankid' and acctypeid='24'";
			}
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
			$ob->credit=$obj->amount;
			$ob->balance=$obj->amount;
			$ob->debit=0;
			$generaljournal = $generaljournal->setObject($ob);
			
			$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name",'documentno'=>"$generaljournal->documentno", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total", 'transactdate'=>"$ob->transactdate",'balance'=>"$generaljournal->balance",'transactionid'=>"$generaljournal->transactionid");
			
			$obj->currencyid=5;
			$obj->exchangerate=1;
			
			$gn = new Generaljournals();
			$gn->add($obj, $shpgeneraljournals,true);
			
			$this->id=$teampaymentsDBO->id;
			$this->sql=$teampaymentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$teampaymentsDBO = new TeampaymentsDBO();
		if($teampaymentsDBO->update($obj,$where)){
			$this->sql=$teampaymentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$teampaymentsDBO = new TeampaymentsDBO();
		if($teampaymentsDBO->delete($obj,$where=""))		
			$this->sql=$teampaymentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$teampaymentsDBO = new TeampaymentsDBO();
		$this->table=$teampaymentsDBO->table;
		$teampaymentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$teampaymentsDBO->sql;
		$this->result=$teampaymentsDBO->result;
		$this->fetchObject=$teampaymentsDBO->fetchObject;
		$this->affectedRows=$teampaymentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->teamdetailid)){
			$error="Team Detail should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
