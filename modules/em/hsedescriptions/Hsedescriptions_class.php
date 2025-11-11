<?php 
require_once("HsedescriptionsDBO.php");
class Hsedescriptions
{				
	var $id;			
	var $name;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $hsedescriptionsDBO;
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
		$hsedescriptionsDBO = new HsedescriptionsDBO();
		if($hsedescriptionsDBO->persist($obj)){
			$this->id=$hsedescriptionsDBO->id;
			$this->sql=$hsedescriptionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$hsedescriptionsDBO = new HsedescriptionsDBO();
		if($hsedescriptionsDBO->update($obj,$where)){
			$this->sql=$hsedescriptionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$hsedescriptionsDBO = new HsedescriptionsDBO();
		if($hsedescriptionsDBO->delete($obj,$where=""))		
			$this->sql=$hsedescriptionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$hsedescriptionsDBO = new HsedescriptionsDBO();
		$this->table=$hsedescriptionsDBO->table;
		$hsedescriptionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$hsedescriptionsDBO->sql;
		$this->result=$hsedescriptionsDBO->result;
		$this->fetchObject=$hsedescriptionsDBO->fetchObject;
		$this->affectedRows=$hsedescriptionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Description should be provided";
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
