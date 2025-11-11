<?php 
require_once("ArrearsDBO.php");
class Arrears
{				
	var $id;			
	var $name;			
	var $taxable;			
	var $status;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $arrearsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->taxable=str_replace("'","\'",$obj->taxable);
		$this->status=str_replace("'","\'",$obj->status);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get taxable
	function getTaxable(){
		return $this->taxable;
	}
	//set taxable
	function setTaxable($taxable){
		$this->taxable=$taxable;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$arrearsDBO = new ArrearsDBO();
		if($arrearsDBO->persist($obj)){
			$this->id=$arrearsDBO->id;
			$this->sql=$arrearsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$arrearsDBO = new ArrearsDBO();
		if($arrearsDBO->update($obj,$where)){
			$this->sql=$arrearsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$arrearsDBO = new ArrearsDBO();
		if($arrearsDBO->delete($obj,$where=""))		
			$this->sql=$arrearsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$arrearsDBO = new ArrearsDBO();
		$this->table=$arrearsDBO->table;
		$arrearsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$arrearsDBO->sql;
		$this->result=$arrearsDBO->result;
		$this->fetchObject=$arrearsDBO->fetchObject;
		$this->affectedRows=$arrearsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Allowance should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
