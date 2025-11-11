<?php 
require_once("ValvesDBO.php");
class Valves
{				
	var $id;			
	var $name;			
	var $systemid;			
	var $greenhouseid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $valvesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->systemid))
			$obj->systemid='NULL';
		$this->systemid=$obj->systemid;
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
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

	//get systemid
	function getSystemid(){
		return $this->systemid;
	}
	//set systemid
	function setSystemid($systemid){
		$this->systemid=$systemid;
	}

	//get greenhouseid
	function getGreenhouseid(){
		return $this->greenhouseid;
	}
	//set greenhouseid
	function setGreenhouseid($greenhouseid){
		$this->greenhouseid=$greenhouseid;
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
		$valvesDBO = new ValvesDBO();
		if($valvesDBO->persist($obj)){
			$this->id=$valvesDBO->id;
			$this->sql=$valvesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$valvesDBO = new ValvesDBO();
		if($valvesDBO->update($obj,$where)){
			$this->sql=$valvesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$valvesDBO = new ValvesDBO();
		if($valvesDBO->delete($obj,$where=""))		
			$this->sql=$valvesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$valvesDBO = new ValvesDBO();
		$this->table=$valvesDBO->table;
		$valvesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$valvesDBO->sql;
		$this->result=$valvesDBO->result;
		$this->fetchObject=$valvesDBO->fetchObject;
		$this->affectedRows=$valvesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Irrigation Valve should be provided";
		}
		else if(empty($obj->systemid)){
			$error="Irrigation System should be provided";
		}
		else if(empty($obj->greenhouseid)){
			$error="Green House should be provided";
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
