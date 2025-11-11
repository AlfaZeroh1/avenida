<?php 
require_once("InvoicesDBO.php");
require_once("../../../modules/pos/invoicedetails/InvoicedetailsDBO.php");
class Invoices
{				
	var $id;			
	var $documentno;
	var $code;
	var $saletypeid;
	var $packingno;			
	var $customerid;
	var $customername;
	var $agentid;	
	var $currencyid;
	var $vatable;
	var $vat;
	var $exchangerate;
	var $exchangerate2;
	var $remarks;			
	var $soldon;			
	var $memo;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $invoicesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->invoiceno=str_replace("'","\'",$obj->invoiceno);
		$this->saletypeid=str_replace("'","\'",$obj->saletypeid);
		$this->packingno=str_replace("'","\'",$obj->packingno);
		if(empty($obj->customerid))
		{
			$obj->customerid='NULL';
			$obj->code='NULL';
	        }
		$this->customerid=$obj->customerid;
		$this->code=$obj->code;
		if(empty($obj->agentid))
			$obj->agentid='NULL';
		$this->agentid=$obj->agentid;
		$this->currencyid=$obj->currencyid;
		$this->vat=$obj->vat;
		$this->vatable=$obj->vatable;
		$this->exchangerate=$obj->exchangerate;
		$this->exchangerate2=$obj->exchangerate2;
		$this->consignee=$obj->consignee;
		$this->shippedon=str_replace("'","\'",$obj->shippedon);
		$this->actualweight=str_replace("'","\'",$obj->actualweight);
		$this->volumeweight=str_replace("'","\'",$obj->volumeweight);
		$this->awbno=str_replace("'","\'",$obj->awbno);
		$this->dropoffpoint=str_replace("'","\'",$obj->dropoffpoint);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->soldon=str_replace("'","\'",$obj->soldon);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get packingno
	function getPackingno(){
		return $this->packingno;
	}
	//set packingno
	function setPackingno($packingno){
		$this->packingno=$packingno;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get agentid
	function getAgentid(){
		return $this->agentid;
	}
	//set agentid
	function setAgentid($agentid){
		$this->agentid=$agentid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get soldon
	function getSoldon(){
		return $this->soldon;
	}
	//set soldon
	function setSoldon($soldon){
		$this->soldon=$soldon;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj,$shop,$shp){ echo "HREREREREERERE";
		$invoicesDBO = new InvoicesDBO();
			$ob = $this->setObject($obj);
			if($invoicesDBO->persist($obj)){
			
				//update packing list
				mysql_query("update pos_packinglists set status=1 where documentno='$obj->packingno'");
				
				$invoicedetails = new Invoicedetails();
				$obj->invoiceid=$invoicesDBO->id;
				$invoicedetails->add($obj,$shop);
				
				$invoiceconsumables = new Invoiceconsumables();
				$obj->invoiceid=$invoicesDBO->id;
				$invoiceconsumables->add($obj,$shp);

				$this->id=$invoicesDBO->id;
				$this->sql=$invoicesDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$shop,$shp){
	
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='sales'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		mysql_query("delete from pos_invoicedetails where invoiceid in(select id from pos_invoices where documentno='$obj->documentno')");
		mysql_query("delete from pos_invoiceconsumables where invoiceid in(select id from pos_invoices where documentno='$obj->documentno')");
		mysql_query("delete from pos_invoices where documentno='$obj->documentno'");
		mysql_query("delete from fn_generaljournals where documentno='$obj->documentno' and transactionid='$transaction->id'");
		
		if($this->add($obj,$shop,$shp)){
		  return true;	
		}
		
	}			
	function delete($obj,$where=""){			
		$invoicesDBO = new InvoicesDBO();
		if($invoicesDBO->delete($obj,$where=""))		
			$this->sql=$invoicesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$invoicesDBO = new InvoicesDBO();
		$this->table=$invoicesDBO->table;
		$invoicesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$invoicesDBO->sql;
		$this->result=$invoicesDBO->result;
		$this->fetchObject=$invoicesDBO->fetchObject;
		$this->affectedRows=$invoicesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}else if(empty($obj->saletypeid)){
			$error="Sale Type should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->exchangerate)){
			$error="Rate should be provided";
		}else if(empty($obj->exchangerate2)){
			$error="Euro Rate should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		
				//retrieve account to debit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->customerid' and acctypeid='29'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;

				//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where acctypeid='25' and refid='$obj->saletypeid'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}else if(empty($obj->customerid)){
			$error="Customer should be provided";
		}else if(empty($obj->saletypeid)){
			$error="Sale Type should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->exchangerate)){
			$error="Rate should be provided";
		}else if(empty($obj->exchangerate2)){
			$error="Euro Rate should be provided";
		}
// 		else if($generaljournalaccounts->affectedRows==0){
// 			$error="Debtor Account do not exist! Talk to Finance Department.";
// 		}
// 		else if($generaljournalaccounts2->affectedRows==0){
// 			$error="Revenue Account do not exist! Talk to Finance Department.";
// 		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
