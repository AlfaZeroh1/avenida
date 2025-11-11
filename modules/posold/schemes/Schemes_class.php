<?php 
require_once("SchemesDBO.php");
class Schemes
{				
	var $id;			
	var $name;			
	var $location;			
	var $description;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $schemesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->location=str_replace("'","\'",$obj->location);
		$this->description=str_replace("'","\'",$obj->description);
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

	//get location
	function getLocation(){
		return $this->location;
	}
	//set location
	function setLocation($location){
		$this->location=$location;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
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
		$schemesDBO = new SchemesDBO();
		if($schemesDBO->persist($obj)){
			$this->id=$schemesDBO->id;
			$this->sql=$schemesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$schemesDBO = new SchemesDBO();
		if($schemesDBO->update($obj,$where)){
			$this->sql=$schemesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$schemesDBO = new SchemesDBO();
		if($schemesDBO->delete($obj,$where=""))		
			$this->sql=$schemesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$schemesDBO = new SchemesDBO();
		$this->table=$schemesDBO->table;
		$schemesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$schemesDBO->sql;
		$this->result=$schemesDBO->result;
		$this->fetchObject=$schemesDBO->fetchObject;
		$this->affectedRows=$schemesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
