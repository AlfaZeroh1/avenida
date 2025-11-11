<?php 
require_once("SubareasDBO.php");
class Subareas
{				
	var $id;			
	var $name;			
	var $areaid;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $subareasDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->areaid=str_replace("'","\'",$obj->areaid);
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

	//get areaid
	function getAreaid(){
		return $this->areaid;
	}
	//set areaid
	function setAreaid($areaid){
		$this->areaid=$areaid;
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
		$subareasDBO = new SubareasDBO();
		if($subareasDBO->persist($obj)){
			$this->id=$subareasDBO->id;
			$this->sql=$subareasDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$subareasDBO = new SubareasDBO();
		if($subareasDBO->update($obj,$where)){
			$this->sql=$subareasDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$subareasDBO = new SubareasDBO();
		if($subareasDBO->delete($obj,$where=""))		
			$this->sql=$subareasDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$subareasDBO = new SubareasDBO();
		$this->table=$subareasDBO->table;
		$subareasDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$subareasDBO->sql;
		$this->result=$subareasDBO->result;
		$this->fetchObject=$subareasDBO->fetchObject;
		$this->affectedRows=$subareasDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Sub Area should be provided";
		}
		else if(empty($obj->areaid)){
			$error="Area should be provided";
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
