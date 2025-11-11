<?php 
require_once("AllowancetypesDBO.php");
class Allowancetypes
{				
	var $id;			
	var $name;			
	var $repeatafter;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $allowancetypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->repeatafter=str_replace("'","\'",$obj->repeatafter);
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

	//get repeatafter
	function getRepeatafter(){
		return $this->repeatafter;
	}
	//set repeatafter
	function setRepeatafter($repeatafter){
		$this->repeatafter=$repeatafter;
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
		$allowancetypesDBO = new AllowancetypesDBO();
		if($allowancetypesDBO->persist($obj)){
			$this->id=$allowancetypesDBO->id;
			$this->sql=$allowancetypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$allowancetypesDBO = new AllowancetypesDBO();
		if($allowancetypesDBO->update($obj,$where)){
			$this->sql=$allowancetypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$allowancetypesDBO = new AllowancetypesDBO();
		if($allowancetypesDBO->delete($obj,$where=""))		
			$this->sql=$allowancetypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$allowancetypesDBO = new AllowancetypesDBO();
		$this->table=$allowancetypesDBO->table;
		$allowancetypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$allowancetypesDBO->sql;
		$this->result=$allowancetypesDBO->result;
		$this->fetchObject=$allowancetypesDBO->fetchObject;
		$this->affectedRows=$allowancetypesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Allowance Type should be provided";
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
