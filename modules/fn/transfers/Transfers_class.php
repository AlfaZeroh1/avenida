<?php 
require_once("TransfersDBO.php");
class Transfers
{				
	var $id;			
	var $bankid;			
	var $amount;	
	var $amount1;
	var $currencyid;			
	var $rate;	
	var $documentno;
	var $eurorate;			
	var $exchangerate;			
	var $tobankid;			
	var $tocurrencyid;			
	var $toeurate;			
	var $torate;			
	var $diffksh;			
	var $diffeuro;			
	var $paymentmodeid;			
	var $transactno;			
	var $chequeno;			
	var $transactdate;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedon;			
	var $lasteditedby;			
	var $ipaddress;			
	var $transfersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->amount1=str_replace("'","\'",$obj->amount1);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->eurorate=str_replace("'","\'",$obj->eurorate);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->tobankid=str_replace("'","\'",$obj->tobankid);
		if(empty($obj->tocurrencyid))
			$obj->tocurrencyid='NULL';
		$this->tocurrencyid=$obj->tocurrencyid;
		$this->toeurate=str_replace("'","\'",$obj->toeurate);
		$this->torate=str_replace("'","\'",$obj->torate);
		$this->diffksh=str_replace("'","\'",$obj->diffksh);
		$this->diffeuro=str_replace("'","\'",$obj->diffeuro);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		$this->transactno=str_replace("'","\'",$obj->transactno);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->transactdate=str_replace("'","\'",$obj->transactdate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get bankid
	function getBankid(){
		return $this->bankid;
	}
	//set bankid
	function setBankid($bankid){
		$this->bankid=$bankid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get currencyid
	function getCurrencyid(){
		return $this->currencyid;
	}
	//set currencyid
	function setCurrencyid($currencyid){
		$this->currencyid=$currencyid;
	}

	//get rate
	function getRate(){
		return $this->rate;
	}
	//set rate
	function setRate($rate){
		$this->rate=$rate;
	}

	//get eurorate
	function getEurorate(){
		return $this->eurorate;
	}
	//set eurorate
	function setEurorate($eurorate){
		$this->eurorate=$eurorate;
	}

	//get exchangerate
	function getExchangerate(){
		return $this->exchangerate;
	}
	//set exchangerate
	function setExchangerate($exchangerate){
		$this->exchangerate=$exchangerate;
	}

	//get tobankid
	function getTobankid(){
		return $this->tobankid;
	}
	//set tobankid
	function setTobankid($tobankid){
		$this->tobankid=$tobankid;
	}

	//get tocurrencyid
	function getTocurrencyid(){
		return $this->tocurrencyid;
	}
	//set tocurrencyid
	function setTocurrencyid($tocurrencyid){
		$this->tocurrencyid=$tocurrencyid;
	}

	//get toeurate
	function getToeurate(){
		return $this->toeurate;
	}
	//set toeurate
	function setToeurate($toeurate){
		$this->toeurate=$toeurate;
	}

	//get torate
	function getTorate(){
		return $this->torate;
	}
	//set torate
	function setTorate($torate){
		$this->torate=$torate;
	}

	//get diffksh
	function getDiffksh(){
		return $this->diffksh;
	}
	//set diffksh
	function setDiffksh($diffksh){
		$this->diffksh=$diffksh;
	}

	//get diffeuro
	function getDiffeuro(){
		return $this->diffeuro;
	}
	//set diffeuro
	function setDiffeuro($diffeuro){
		$this->diffeuro=$diffeuro;
	}

	//get paymentmodeid
	function getPaymentmodeid(){
		return $this->paymentmodeid;
	}
	//set paymentmodeid
	function setPaymentmodeid($paymentmodeid){
		$this->paymentmodeid=$paymentmodeid;
	}

	//get transactno
	function getTransactno(){
		return $this->transactno;
	}
	//set transactno
	function setTransactno($transactno){
		$this->transactno=$transactno;
	}

	//get chequeno
	function getChequeno(){
		return $this->chequeno;
	}
	//set chequeno
	function setChequeno($chequeno){
		$this->chequeno=$chequeno;
	}

	//get transactdate
	function getTransactdate(){
		return $this->transactdate;
	}
	//set transactdate
	function setTransactdate($transactdate){
		$this->transactdate=$transactdate;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$transfersDBO = new TransfersDBO();
		
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='Transfers'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		if($transfersDBO->persist($obj)){
		  $gna1 =new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$obj->bankid' and acctypeid='8' ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $gna1->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $gna1=$gna1->fetchObject;
		  
		  $gna2 =new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$obj->tobankid' and acctypeid='8' ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $gna2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $gna2=$gna2->fetchObject;
		  
		  $gna =new Generaljournalaccounts();
		  $fields="*";
		  $where=" where id='6368'";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $gna->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $gna=$gna->fetchObject;
		  
		  //make entries
		  $generaljournal = new Generaljournals();
		  $generaljournal->accountid=$gna1->id;
		  $generaljournal->daccountid=$gna2->id;
		  $generaljournal->remarks="Bank Transfer";
		  $generaljournal->transactdate=$obj->depositdate;
		  $generaljournal->debit=0;
		  $generaljournal->credit=$obj->amount;
		  $generaljournal->currencyid=$obj->currencyid;
		  $generaljournal->rate=$obj->rate;
		  $generaljournal->eurorate=$obj->eurorate;
		  $generaljournal->documentno=$obj->documentno;
		  $generaljournal->transactionid=$transaction->id;
		  
		  $it=0;
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'class'=>"$generaljournal->class",'jvno'=>"$generaljournal->jvno");
		  $it++;
		  
		  $generaljournal2 = new Generaljournals();
		  $generaljournal2->accountid=$gna2->id;
		  $generaljournal2->daccountid=$gna1->id;
		  $generaljournal2->remarks="Bank Transfer";
		  $generaljournal2->transactdate=$obj->depositdate;
		  $generaljournal2->debit=$obj->amount1;
		  $generaljournal2->credit=0;
		  $generaljournal2->currencyid=$obj->tocurrencyid;
		  $generaljournal2->rate=$obj->torate;
		  $generaljournal2->eurorate=$obj->toeurate;
		  $generaljournal2->documentno=$obj->documentno;
		  $generaljournal2->transactionid=$transaction->id;
		  
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'class'=>"$generaljournal2->class",'jvno'=>"$generaljournal2->jvno");
		  
		  $it++;
		  
		  //make entries
		  $currencys = new Currencys();
		  $fields="*";
		  $join="";
		  $where=" where id='5' ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $currencys = $currencys->fetchObject;
		  
		  $generaljournal3= new Generaljournals();
		  $generaljournal3->accountid=$gna->id;
		  $generaljournal3->daccountid=$gna2->id;
		  $generaljournal3->remarks="Bank Transfer";
		  $generaljournal3->transactdate=$obj->depositdate;
		  $generaljournal3->debit=$obj->diffksh;
		  $generaljournal3->currencyid=$obj->tocurrencyid;
		  $generaljournal3->rate=$obj->torate;
		  $generaljournal3->eurorate=$obj->toeurate;
		  $generaljournal3->documentno=$obj->documentno;
		  $generaljournal3->transactionid=$transaction->id;
		  
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal3->tid",'documentno'=>"$generaljournal3->documentno",'remarks'=>"$generaljournal3->remarks",'memo'=>"$generaljournal3->memo",'accountid'=>"$generaljournal3->accountid",'transactionid'=>"$generaljournal3->transactionid",'mode'=>"$generaljournal3->mode",'debit'=>"$generaljournal3->debit",'credit'=>"$generaljournal3->credit",'transactdate'=>"$generaljournal3->transactdate",'currencyid'=>"$generaljournal3->currencyid",'rate'=>"$generaljournal3->rate",'eurorate'=>"$generaljournal3->eurorate",'class'=>"$generaljournal3->class",'jvno'=>"$generaljournal3->jvno");
		  $it++;
		  
		  $gn = new Generaljournals();
		  $gn->add($obj,$shpgeneraljournals,true, false);
		  
		  $this->id=$transfersDBO->id;
		  $this->sql=$transfersDBO->sql;
		  return true;	
		}
	}			
	function edit($obj,$where=""){
		$transfersDBO = new TransfersDBO();
		
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='Transfers'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		if($transfersDBO->update($obj)){
		  $gna1 =new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$obj->bankid' and acctypeid='8' ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $gna1->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $gna1=$gna1->fetchObject;
		  
		  $gna2 =new Generaljournalaccounts();
		  $fields="*";
		  $where=" where refid='$obj->tobankid' and acctypeid='8' ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $gna2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $gna2=$gna2->fetchObject;
		  
		  $gna =new Generaljournalaccounts();
		  $fields="*";
		  $where=" where id='6368'";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $gna->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $gna=$gna->fetchObject;
		  
		  //make entries
		  $generaljournal = new Generaljournals();
		  $generaljournal->accountid=$gna1->id;
		  $generaljournal->daccountid=$gna2->id;
		  $generaljournal->remarks="Bank Transfer";
		  $generaljournal->transactdate=$obj->depositdate;
		  $generaljournal->debit=0;
		  $generaljournal->credit=$obj->amount;
		  $generaljournal->currencyid=$obj->currencyid;
		  $generaljournal->rate=$obj->rate;
		  $generaljournal->eurorate=$obj->eurorate;
		  $generaljournal->documentno=$obj->documentno;
		  $generaljournal->transactionid=$transaction->id;
		  
		  $it=0;
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'currencyid'=>"$generaljournal->currencyid",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'class'=>"$generaljournal->class",'jvno'=>"$generaljournal->jvno");
		  $it++;
		  
		  $generaljournal2 = new Generaljournals();
		  $generaljournal2->accountid=$gna2->id;
		  $generaljournal2->daccountid=$gna1->id;
		  $generaljournal2->remarks="Bank Transfer";
		  $generaljournal2->transactdate=$obj->depositdate;
		  $generaljournal2->debit=$obj->amount1;
		  $generaljournal2->credit=0;
		  $generaljournal2->currencyid=$obj->tocurrencyid;
		  $generaljournal2->rate=$obj->torate;
		  $generaljournal2->eurorate=$obj->toeurate;
		  $generaljournal2->documentno=$obj->documentno;
		  $generaljournal2->transactionid=$transaction->id;
		  
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'currencyid'=>"$generaljournal2->currencyid",'rate'=>"$generaljournal2->rate",'eurorate'=>"$generaljournal2->eurorate",'class'=>"$generaljournal2->class",'jvno'=>"$generaljournal2->jvno");
		  
		  $it++;
		  
		  $generaljournal3= new Generaljournals();
		  $generaljournal3->accountid=$gna->id;
		  $generaljournal3->daccountid=$gna2->id;
		  $generaljournal3->remarks="Bank Transfer";
		  $generaljournal3->transactdate=$obj->depositdate;
		  
		  $generaljournal3->debit=$obj->diffksh;
		  $generaljournal3->credit=0;
		  $generaljournal3->currencyid=5;
		  $generaljournal3->rate=1;
		  $generaljournal3->eurorate=$obj->toeurate;
		  $generaljournal3->documentno=$obj->documentno;
		  $generaljournal3->transactionid=$transaction->id;
		  
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal3->tid",'documentno'=>"$generaljournal3->documentno",'remarks'=>"$generaljournal3->remarks",'memo'=>"$generaljournal3->memo",'accountid'=>"$generaljournal3->accountid",'transactionid'=>"$generaljournal3->transactionid",'mode'=>"$generaljournal3->mode",'debit'=>"$generaljournal3->debit",'credit'=>"$generaljournal3->credit",'transactdate'=>"$generaljournal3->transactdate",'currencyid'=>"$generaljournal3->currencyid",'rate'=>"$generaljournal3->rate",'eurorate'=>"$generaljournal3->eurorate",'class'=>"$generaljournal3->class",'jvno'=>"$generaljournal3->jvno");
		  $it++;
		  
		  $gn = new Generaljournals();
		  $gn->edit($obj,"",$shpgeneraljournals, false);
		  
		  $this->id=$transfersDBO->id;
		  $this->sql=$transfersDBO->sql;
		  return true;	
		}	
	}			
	function delete($obj,$where=""){			
		$transfersDBO = new TransfersDBO();
		if($transfersDBO->delete($obj,$where=""))		
			$this->sql=$transfersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$transfersDBO = new TransfersDBO();
		$this->table=$transfersDBO->table;
		$transfersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$transfersDBO->sql;
		$this->result=$transfersDBO->result;
		$this->fetchObject=$transfersDBO->fetchObject;
		$this->affectedRows=$transfersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->bankid)){
			$error="From Bank Must Be Provided";
		}
		elseif(empty($obj->tobankid)){
			$error="To Bank Must Be Provided";
		}
		elseif(empty($obj->amount)){
			$error="Amount Must Be Provided";
		}
		elseif(empty($obj->currencyid)){
			$error="From Currency Must Be Provided";
		}
		elseif(empty($obj->tocurrencyid)){
			$error="To Currency Must Be Provided";
		}
		elseif(empty($obj->tocurrencyid)){
			$error="Currency Must Be Provided";
		}
		elseif(empty($obj->exchangerate)){
			$error="Exchange Rate Must Be Provided";
		}
		elseif(empty($obj->paymentmodeid)){
			$error="Payment Mode Must Be Provided";
		}
		elseif(empty($obj->transactdate)){
			$error="Date Mode Must Be Provided";
		}
		  
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->bankid)){
			$error="From Bank Must Be Provided";
		}
		elseif(empty($obj->tobankid)){
			$error="To Bank Must Be Provided";
		}
		elseif(empty($obj->amount)){
			$error="Amount Must Be Provided";
		}
		elseif(empty($obj->currencyid)){
			$error="From Currency Must Be Provided";
		}
		elseif(empty($obj->tocurrencyid)){
			$error="To Currency Must Be Provided";
		}
		elseif(empty($obj->tocurrencyid)){
			$error="Currency Must Be Provided";
		}
		elseif(empty($obj->exchangerate)){
			$error="Exchange Rate Must Be Provided";
		}
		elseif(empty($obj->paymentmodeid)){
			$error="Payment Mode Must Be Provided";
		}
		elseif(empty($obj->transactdate)){
			$error="Date Mode Must Be Provided";
		}
		  
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}
?>
