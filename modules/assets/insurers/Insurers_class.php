<?php 
require_once("InsurersDBO.php");
class Insurers
{				
	var $id;			
	var $name;			
	var $physicaladdress;			
	var $contactperson;			
	var $contacttel;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $insurersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->physicaladdress=str_replace("'","\'",$obj->physicaladdress);
		$this->contactperson=str_replace("'","\'",$obj->contactperson);
		$this->contacttel=str_replace("'","\'",$obj->contacttel);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get physicaladdress
	function getPhysicaladdress(){
		return $this->physicaladdress;
	}
	//set physicaladdress
	function setPhysicaladdress($physicaladdress){
		$this->physicaladdress=$physicaladdress;
	}

	//get contactperson
	function getContactperson(){
		return $this->contactperson;
	}
	//set contactperson
	function setContactperson($contactperson){
		$this->contactperson=$contactperson;
	}

	//get contacttel
	function getContacttel(){
		return $this->contacttel;
	}
	//set contacttel
	function setContacttel($contacttel){
		$this->contacttel=$contacttel;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
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
		$insurersDBO = new InsurersDBO();
		if($insurersDBO->persist($obj)){
			$this->id=$insurersDBO->id;
			$this->sql=$insurersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$insurersDBO = new InsurersDBO();
		if($insurersDBO->update($obj,$where)){
			$this->sql=$insurersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$insurersDBO = new InsurersDBO();
		if($insurersDBO->delete($obj,$where=""))		
			$this->sql=$insurersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$insurersDBO = new InsurersDBO();
		$this->table=$insurersDBO->table;
		$insurersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$insurersDBO->sql;
		$this->result=$insurersDBO->result;
		$this->fetchObject=$insurersDBO->fetchObject;
		$this->affectedRows=$insurersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Insurer should be provided";
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
