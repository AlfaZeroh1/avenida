<?php 
require_once("TestsDBO.php");
class Tests
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $ipaddres;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $testsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddres=str_replace("'","\'",$obj->ipaddres);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get ipaddres
	function getIpaddres(){
		return $this->ipaddres;
	}
	//set ipaddres
	function setIpaddres($ipaddres){
		$this->ipaddres=$ipaddres;
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
		$testsDBO = new TestsDBO();
		if($testsDBO->persist($obj)){
			$this->id=$testsDBO->id;
			$this->sql=$testsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$testsDBO = new TestsDBO();
		if($testsDBO->update($obj,$where)){
			$this->sql=$testsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$testsDBO = new TestsDBO();
		if($testsDBO->delete($obj,$where=""))		
			$this->sql=$testsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$testsDBO = new TestsDBO();
		$this->table=$testsDBO->table;
		$testsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$testsDBO->sql;
		$this->result=$testsDBO->result;
		$this->fetchObject=$testsDBO->fetchObject;
		$this->affectedRows=$testsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
