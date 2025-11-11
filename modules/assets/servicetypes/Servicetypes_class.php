<?php 
require_once("ServicetypesDBO.php");
class Servicetypes
{				
	var $id;			
	var $name;			
	var $duration;			
	var $durationtype;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $servicetypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->duration=str_replace("'","\'",$obj->duration);
		$this->durationtype=str_replace("'","\'",$obj->durationtype);
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

	//get duration
	function getDuration(){
		return $this->duration;
	}
	//set duration
	function setDuration($duration){
		$this->duration=$duration;
	}

	//get durationtype
	function getDurationtype(){
		return $this->durationtype;
	}
	//set durationtype
	function setDurationtype($durationtype){
		$this->durationtype=$durationtype;
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
		$servicetypesDBO = new ServicetypesDBO();
		if($servicetypesDBO->persist($obj)){
			$this->id=$servicetypesDBO->id;
			$this->sql=$servicetypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$servicetypesDBO = new ServicetypesDBO();
		if($servicetypesDBO->update($obj,$where)){
			$this->sql=$servicetypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$servicetypesDBO = new ServicetypesDBO();
		if($servicetypesDBO->delete($obj,$where=""))		
			$this->sql=$servicetypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$servicetypesDBO = new ServicetypesDBO();
		$this->table=$servicetypesDBO->table;
		$servicetypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$servicetypesDBO->sql;
		$this->result=$servicetypesDBO->result;
		$this->fetchObject=$servicetypesDBO->fetchObject;
		$this->affectedRows=$servicetypesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Service Type should be provided";
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
