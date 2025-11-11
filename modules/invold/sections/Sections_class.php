<?php 
require_once("SectionsDBO.php");
class Sections
{				
	var $id;			
	var $section;			
	var $code;			
	var $description;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $sectionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->section=str_replace("'","\'",$obj->section);
		$this->code=str_replace("'","\'",$obj->code);
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

	//get section
	function getSection(){
		return $this->section;
	}
	//set section
	function setSection($section){
		$this->section=$section;
	}

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
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
		$sectionsDBO = new SectionsDBO();
		if($sectionsDBO->persist($obj)){
			$this->id=$sectionsDBO->id;
			$this->sql=$sectionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$sectionsDBO = new SectionsDBO();
		if($sectionsDBO->update($obj,$where)){
			$this->sql=$sectionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$sectionsDBO = new SectionsDBO();
		if($sectionsDBO->delete($obj,$where=""))		
			$this->sql=$sectionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sectionsDBO = new SectionsDBO();
		$this->table=$sectionsDBO->table;
		$sectionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$sectionsDBO->sql;
		$this->result=$sectionsDBO->result;
		$this->fetchObject=$sectionsDBO->fetchObject;
		$this->affectedRows=$sectionsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
