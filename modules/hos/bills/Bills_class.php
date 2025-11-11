<?php 
require_once("BillsDBO.php");
class Bills
{				
	var $id;			
	var $name;			
	var $amount;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $billsDBO;
	var $fetchObject;
	var $result;
	var $table;
	var $affectedRows;

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
		$billsDBO = new BillsDBO();
		if($billsDBO->persist($obj))		
			return true;	
	}			
	function edit($obj){			
		$billsDBO = new BillsDBO();
		if($billsDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$billsDBO = new BillsDBO();
		if($billsDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$billsDBO = new BillsDBO();
		$this->table=$billsDBO->table;
		$billsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->result=$billsDBO->result;
		$this->fetchObject=$billsDBO->fetchObject;
		$this->affectedRows=$billsDBO->affectedRows;
	}			
}				
?>
