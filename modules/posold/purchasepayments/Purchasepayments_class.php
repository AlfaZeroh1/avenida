<?php 
require_once("PurchasepaymentsDBO.php");
class Purchasepayments
{				
	var $id;			
	var $documentno;			
	var $invoiceno;			
	var $supplierid;			
	var $amount;			
	var $paymentmodeid;			
	var $bankid;			
	var $chequeno;			
	var $paidon;			
	var $offsetid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $purchasepaymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->invoiceno=str_replace("'","\'",$obj->invoiceno);
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->amount=str_replace("'","\'",$obj->amount);
		if(empty($obj->paymentmodeid))
			$obj->paymentmodeid='NULL';
		$this->paymentmodeid=$obj->paymentmodeid;
		if(empty($obj->bankid))
			$obj->bankid='NULL';
		$this->bankid=$obj->bankid;
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->paidon=str_replace("'","\'",$obj->paidon);
		$this->offsetid=str_replace("'","\'",$obj->offsetid);
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

	//get invoiceno
	function getInvoiceno(){
		return $this->invoiceno;
	}
	//set invoiceno
	function setInvoiceno($invoiceno){
		$this->invoiceno=$invoiceno;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
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

	//get chequeno
	function getChequeno(){
		return $this->chequeno;
	}
	//set chequeno
	function setChequeno($chequeno){
		$this->chequeno=$chequeno;
	}

	//get paidon
	function getPaidon(){
		return $this->paidon;
	}
	//set paidon
	function setPaidon($paidon){
		$this->paidon=$paidon;
	}

	//get offsetid
	function getOffsetid(){
		return $this->offsetid;
	}
	//set offsetid
	function setOffsetid($offsetid){
		$this->offsetid=$offsetid;
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

	function add($obj){
		$purchasepaymentsDBO = new PurchasepaymentsDBO();
		if($purchasepaymentsDBO->persist($obj)){
			$this->id=$purchasepaymentsDBO->id;
			$this->sql=$purchasepaymentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$purchasepaymentsDBO = new PurchasepaymentsDBO();
		if($purchasepaymentsDBO->update($obj,$where)){
			$this->sql=$purchasepaymentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$purchasepaymentsDBO = new PurchasepaymentsDBO();
		if($purchasepaymentsDBO->delete($obj,$where=""))		
			$this->sql=$purchasepaymentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$purchasepaymentsDBO = new PurchasepaymentsDBO();
		$this->table=$purchasepaymentsDBO->table;
		$purchasepaymentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$purchasepaymentsDBO->sql;
		$this->result=$purchasepaymentsDBO->result;
		$this->fetchObject=$purchasepaymentsDBO->fetchObject;
		$this->affectedRows=$purchasepaymentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		else if(empty($obj->paidon)){
			$error="Paid On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}
		else if(empty($obj->paymentmodeid)){
			$error="Payment Mode should be provided";
		}
		else if(empty($obj->paidon)){
			$error="Paid On should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
