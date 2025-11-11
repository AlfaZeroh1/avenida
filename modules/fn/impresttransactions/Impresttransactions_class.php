<?php 
require_once("ImpresttransactionsDBO.php");
class Impresttransactions
{				
	var $id;			
	var $documentno;			
	var $imprestaccountid;			
	var $imprestid;			
	var $memo;			
	var $quantity;			
	var $amount;			
	var $incurredon;			
	var $enteredon;			
	var $remarks;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $expenseid;			
	var $impresttransactionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->imprestaccountid))
			$obj->imprestaccountid='NULL';
		$this->imprestaccountid=$obj->imprestaccountid;
		if(empty($obj->imprestid))
			$obj->imprestid='NULL';
		$this->imprestid=$obj->imprestid;
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->incurredon=str_replace("'","\'",$obj->incurredon);
		$this->enteredon=str_replace("'","\'",$obj->enteredon);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		if(empty($obj->expenseid))
			$obj->expenseid='NULL';
		$this->expenseid=$obj->expenseid;
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get imprestaccountid
	function getImprestaccountid(){
		return $this->imprestaccountid;
	}
	//set imprestaccountid
	function setImprestaccountid($imprestaccountid){
		$this->imprestaccountid=$imprestaccountid;
	}

	//get imprestid
	function getImprestid(){
		return $this->imprestid;
	}
	//set imprestid
	function setImprestid($imprestid){
		$this->imprestid=$imprestid;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get incurredon
	function getIncurredon(){
		return $this->incurredon;
	}
	//set incurredon
	function setIncurredon($incurredon){
		$this->incurredon=$incurredon;
	}

	//get enteredon
	function getEnteredon(){
		return $this->enteredon;
	}
	//set enteredon
	function setEnteredon($enteredon){
		$this->enteredon=$enteredon;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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

	//get expenseid
	function getExpenseid(){
		return $this->expenseid;
	}
	//set expenseid
	function setExpenseid($expenseid){
		$this->expenseid=$expenseid;
	}

	function add($obj,$shop){
		$impresttransactionsDBO = new ImpresttransactionsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		
				//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='impresttransaction'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;

		$it=0;

		$ob->transactdate=$obj->enteredon;
		
		while($i<$num){

			

			$obj->expenseid=$shop[$i]['expenseid'];
			$obj->expensename=$shop[$i]['expensename'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->amount=$shop[$i]['amount'];
			$obj->incurredon=$shop[$i]['incurredon'];
			$obj->remarks=$shop[$i]['remarks'];
			$obj->total=$shop[$i]['total'];
			if($impresttransactionsDBO->persist($obj)){		
				//$this->id=$impresttransactionsDBO->id;
				$this->sql=$impresttransactionsDBO->sql;
			}
			$total+=$obj->total;
			$i++;
			
			//retrieve account to debit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->expenseid' and acctypeid='4'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;
		
				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$impresttransactions->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks=$impresttransactions->remarks;
		$ob->memo=
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=$obj->total;
		$ob->class=$obj->projectid;
		$ob->credit=0;
		$generaljournal->setObject($ob);

		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		$it++;
		
		}

				//Make a journal entry				

				//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->imprestaccountid' and acctypeid='24'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;


				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$impresttransactions->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="Imprest Transactions #$obj->documentno";
		$ob->memo=$impresttransactions->remarks;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=0;
		$ob->credit=$total;
		$ob->class=$obj->projectid;
		$generaljournal2->setObject($ob);
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");

		$gn= new Generaljournals();
		$gn->add($obj,$shpgeneraljournals);

		return true;	
	}	
	
	function edit($obj,$where="",$shop){
		$impresttransactionsDBO = new ImpresttransactionsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$impresttransactionsDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->expenseid=$shop['expenseid'];
			$obj->expensename=$shop['expensename'];
			$obj->quantity=$shop['quantity'];
			$obj->amount=$shop['amount'];
			$obj->incurredon=$shop['incurredon'];
			$obj->remarks=$shop['remarks'];
			if($impresttransactionsDBO->update($obj,$where)){
				$this->sql=$impresttransactionsDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$impresttransactionsDBO = new ImpresttransactionsDBO();
		if($impresttransactionsDBO->delete($obj,$where=""))		
			$this->sql=$impresttransactionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$impresttransactionsDBO = new ImpresttransactionsDBO();
		$this->table=$impresttransactionsDBO->table;
		$impresttransactionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$impresttransactionsDBO->sql;
		$this->result=$impresttransactionsDBO->result;
		$this->fetchObject=$impresttransactionsDBO->fetchObject;
		$this->affectedRows=$impresttransactionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Imprest No should be provided";
		}
		else if(empty($obj->imprestaccountid)){
			$error="Imprest Account should be provided";
		}
		else if(empty($obj->imprestid)){
			$error="Imprest should be provided";
		}
		else if(empty($obj->expenseid)){
			$error="Expense should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Imprest No should be provided";
		}
		else if(empty($obj->imprestaccountid)){
			$error="Imprest Account should be provided";
		}
		else if(empty($obj->imprestid)){
			$error="Imprest should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
