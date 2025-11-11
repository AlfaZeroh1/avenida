<?php 
require_once("ProjectsDBO.php");
class Projects
{				
	var $id;			
	var $name;			
	var $locationid;			
	var $description;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $projectsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->locationid))
			$obj->locationid='NULL';
		$this->locationid=$obj->locationid;
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

	//get locationid
	function getLocationid(){
		return $this->locationid;
	}
	//set locationid
	function setLocationid($locationid){
		$this->locationid=$locationid;
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
		$projectsDBO = new ProjectsDBO();
		if($projectsDBO->persist($obj)){
			$this->id=$projectsDBO->id;
			$this->sql=$projectsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectsDBO = new ProjectsDBO();
		if($projectsDBO->update($obj,$where)){
			$this->sql=$projectsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectsDBO = new ProjectsDBO();
		if($projectsDBO->delete($obj,$where=""))		
			$this->sql=$projectsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectsDBO = new ProjectsDBO();
		$this->table=$projectsDBO->table;
		$projectsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectsDBO->sql;
		$this->result=$projectsDBO->result;
		$this->fetchObject=$projectsDBO->fetchObject;
		$this->affectedRows=$projectsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Project Name should be provided";
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
