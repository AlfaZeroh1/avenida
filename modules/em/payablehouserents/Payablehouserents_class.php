<?php 
require_once("PayablehouserentsDBO.php");
class Payablehouserents
{				
	var $id;			
	var $documentno;			
	var $houseid;			
	var $tenantid;			
	var $month;			
	var $year;			
	var $invoicedon;			
	var $amount;			
	var $remarks;							
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;		
	var $payablehouserentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->tenantid=str_replace("'","\'",$obj->tenantid);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->invoicedon=str_replace("'","\'",$obj->invoicedon);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
	}

	//get tenantid
	function getTenantid(){
		return $this->tenantid;
	}
	//set tenantid
	function setTenantid($tenantid){
		$this->tenantid=$tenantid;
	}

	//get month
	function getMonth(){
		return $this->month;
	}
	//set month
	function setMonth($month){
		$this->month=$month;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get invoicedon
	function getInvoicedon(){
		return $this->invoicedon;
	}
	//set invoicedon
	function setInvoicedon($invoicedon){
		$this->invoicedon=$invoicedon;
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
		$payablehouserentsDBO = new PayablehouserentsDBO();
		if($payablehouserentsDBO->persist($obj)){
			$this->id=$payablehouserentsDBO->id;
			$this->sql=$payablehouserentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$payablehouserentsDBO = new PayablehouserentsDBO();
		if($payablehouserentsDBO->update($obj,$where)){
			$this->sql=$payablehouserentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$payablehouserentsDBO = new PayablehouserentsDBO();
		if($payablehouserentsDBO->delete($obj,$where=""))		
			$this->sql=$payablehouserentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$payablehouserentsDBO = new PayablehouserentsDBO();
		$this->table=$payablehouserentsDBO->table;
		$payablehouserentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$payablehouserentsDBO->sql;
		$this->result=$payablehouserentsDBO->result;
		$this->fetchObject=$payablehouserentsDBO->fetchObject;
		$this->affectedRows=$payablehouserentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Invoice No should be provided";
		}
		else if(empty($obj->houseid)){
			$error="House should be provided";
		}
		else if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
		else if(empty($obj->month)){
			$error="Month should be provided";
		}
		else if(empty($obj->year)){
			$error="Year should be provided";
		}
		else if(empty($obj->invoicedon)){
			$error="Invoiced On should be provided";
		}
		else if(empty($obj->amount)){
			$error="Amount should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Invoice No should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
