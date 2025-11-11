<?php 
require_once("TypesDBO.php");
class Types
{				
	var $id;			
	var $name;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $typesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
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
		$typesDBO = new TypesDBO();
		if($typesDBO->persist($obj)){
			$this->id=$typesDBO->id;
			$this->sql=$typesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$typesDBO = new TypesDBO();
		if($typesDBO->update($obj,$where)){
			$this->sql=$typesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$typesDBO = new TypesDBO();
		if($typesDBO->delete($obj,$where=""))		
			$this->sql=$typesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$typesDBO = new TypesDBO();
		$this->table=$typesDBO->table;
		$typesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$typesDBO->sql;
		$this->result=$typesDBO->result;
		$this->fetchObject=$typesDBO->fetchObject;
		$this->affectedRows=$typesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Type should be provided";
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
