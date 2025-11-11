<?php 
require_once("DeductiontypesDBO.php");
class Deductiontypes
{				
	var $id;			
	var $name;			
	var $repeatafter;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $deductiontypesDBO;
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
		$deductiontypesDBO = new DeductiontypesDBO();
		if($deductiontypesDBO->persist($obj)){
			$this->id=$deductiontypesDBO->id;
			$this->sql=$deductiontypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$deductiontypesDBO = new DeductiontypesDBO();
		if($deductiontypesDBO->update($obj,$where)){
			$this->sql=$deductiontypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$deductiontypesDBO = new DeductiontypesDBO();
		if($deductiontypesDBO->delete($obj,$where=""))		
			$this->sql=$deductiontypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$deductiontypesDBO = new DeductiontypesDBO();
		$this->table=$deductiontypesDBO->table;
		$deductiontypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$deductiontypesDBO->sql;
		$this->result=$deductiontypesDBO->result;
		$this->fetchObject=$deductiontypesDBO->fetchObject;
		$this->affectedRows=$deductiontypesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
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
