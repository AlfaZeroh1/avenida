<?php 
require_once("AreasDBO.php");
class Areas
{				
	var $id;			
	var $name;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $areasDBO;
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
		$areasDBO = new AreasDBO();
		if($areasDBO->persist($obj)){
			$this->id=$areasDBO->id;
			$this->sql=$areasDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$areasDBO = new AreasDBO();
		if($areasDBO->update($obj,$where)){
			$this->sql=$areasDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$areasDBO = new AreasDBO();
		if($areasDBO->delete($obj,$where=""))		
			$this->sql=$areasDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$areasDBO = new AreasDBO();
		$this->table=$areasDBO->table;
		$areasDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$areasDBO->sql;
		$this->result=$areasDBO->result;
		$this->fetchObject=$areasDBO->fetchObject;
		$this->affectedRows=$areasDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
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
