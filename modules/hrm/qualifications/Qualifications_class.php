<?php 
require_once("QualificationsDBO.php");
class Qualifications
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $qualificationsDBO;
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
		$qualificationsDBO = new QualificationsDBO();
		if($qualificationsDBO->persist($obj)){
			$this->id=$qualificationsDBO->id;
			$this->sql=$qualificationsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$qualificationsDBO = new QualificationsDBO();
		if($qualificationsDBO->update($obj,$where)){
			$this->sql=$qualificationsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$qualificationsDBO = new QualificationsDBO();
		if($qualificationsDBO->delete($obj,$where=""))		
			$this->sql=$qualificationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$qualificationsDBO = new QualificationsDBO();
		$this->table=$qualificationsDBO->table;
		$qualificationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$qualificationsDBO->sql;
		$this->result=$qualificationsDBO->result;
		$this->fetchObject=$qualificationsDBO->fetchObject;
		$this->affectedRows=$qualificationsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Qualification should be provided";
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
