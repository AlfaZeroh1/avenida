<?php 
require_once("PurchasepaymentsDBO.php");
class Purchasepayments
{				
	var $id;			
	var $supplierid;			
	var $amount;			
	var $paymentmodeid;			
	var $bank;			
	var $chequeno;			
	var $paymentdate;			
	var $offsetid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $documentno;			
	var $ipaddress;			
	var $purchasepaymentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->supplierid=str_replace("'","\'",$obj->supplierid);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->paymentmodeid=str_replace("'","\'",$obj->paymentmodeid);
		$this->bank=str_replace("'","\'",$obj->bank);
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->paymentdate=str_replace("'","\'",$obj->paymentdate);
		$this->offsetid=str_replace("'","\'",$obj->offsetid);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->documentno=str_replace("'","\'",$obj->documentno);
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

	//get bank
	function getBank(){
		return $this->bank;
	}
	//set bank
	function setBank($bank){
		$this->bank=$bank;
	}

	//get chequeno
	function getChequeno(){
		return $this->chequeno;
	}
	//set chequeno
	function setChequeno($chequeno){
		$this->chequeno=$chequeno;
	}

	//get paymentdate
	function getPaymentdate(){
		return $this->paymentdate;
	}
	//set paymentdate
	function setPaymentdate($paymentdate){
		$this->paymentdate=$paymentdate;
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
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
		if(empty($obj->paymentmodeid)){
			$error="Mode Of Payment should be provided";
		}
		else if(empty($obj->paymentdate)){
			$error="Payment Date should be provided";
		}
		else if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->paymentmodeid)){
			$error="Mode Of Payment should be provided";
		}
		else if(empty($obj->documentno)){
			$error="Document No. should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
