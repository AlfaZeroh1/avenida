<?php 
require_once("BanksDBO.php");
class Banks
{				
	var $id;			
	var $name;			
	var $bankacc;			
	var $bankbranch;
	var $currencyid;
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $banksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->bankacc=str_replace("'","\'",$obj->bankacc);
		$this->bankbranch=str_replace("'","\'",$obj->bankbranch);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
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

	//get bankacc
	function getBankacc(){
		return $this->bankacc;
	}
	//set bankacc
	function setBankacc($bankacc){
		$this->bankacc=$bankacc;
	}

	//get bankbranch
	function getBankbranch(){
		return $this->bankbranch;
	}
	//set bankbranch
	function setBankbranch($bankbranch){
		$this->bankbranch=$bankbranch;
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
		$banksDBO = new BanksDBO();
		if($banksDBO->persist($obj)){
			$this->id=$banksDBO->id;
			$this->sql=$banksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$banksDBO = new BanksDBO();
		if($banksDBO->update($obj,$where)){
			$this->sql=$banksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$banksDBO = new BanksDBO();
		if($banksDBO->delete($obj,$where=""))		
			$this->sql=$banksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$banksDBO = new BanksDBO();
		$this->table=$banksDBO->table;
		$banksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$banksDBO->sql;
		$this->result=$banksDBO->result;
		$this->fetchObject=$banksDBO->fetchObject;
		$this->affectedRows=$banksDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
