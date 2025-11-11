<?php 
require_once("SupplierpaidinvoicesDBO.php");
class Supplierpaidinvoices
{				
	var $id;			
	var $voucherno;			
	var $invoiceno;			
	var $amount;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $supplierpaidinvoicesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->voucherno=str_replace("'","\'",$obj->voucherno);
		$this->invoiceno=str_replace("'","\'",$obj->invoiceno);
		$this->amount=str_replace("'","\'",$obj->amount);
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

	//get voucherno
	function getVoucherno(){
		return $this->voucherno;
	}
	//set voucherno
	function setVoucherno($voucherno){
		$this->voucherno=$voucherno;
	}

	//get invoiceno
	function getInvoiceno(){
		return $this->invoiceno;
	}
	//set invoiceno
	function setInvoiceno($invoiceno){
		$this->invoiceno=$invoiceno;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
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
		$supplierpaidinvoicesDBO = new SupplierpaidinvoicesDBO();
		if($supplierpaidinvoicesDBO->persist($obj)){
			$this->id=$supplierpaidinvoicesDBO->id;
			$this->sql=$supplierpaidinvoicesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$supplierpaidinvoicesDBO = new SupplierpaidinvoicesDBO();
		if($supplierpaidinvoicesDBO->update($obj,$where)){
			$this->sql=$supplierpaidinvoicesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$supplierpaidinvoicesDBO = new SupplierpaidinvoicesDBO();
		if($supplierpaidinvoicesDBO->delete($obj,$where=""))		
			$this->sql=$supplierpaidinvoicesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$supplierpaidinvoicesDBO = new SupplierpaidinvoicesDBO();
		$this->table=$supplierpaidinvoicesDBO->table;
		$supplierpaidinvoicesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$supplierpaidinvoicesDBO->sql;
		$this->result=$supplierpaidinvoicesDBO->result;
		$this->fetchObject=$supplierpaidinvoicesDBO->fetchObject;
		$this->affectedRows=$supplierpaidinvoicesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
