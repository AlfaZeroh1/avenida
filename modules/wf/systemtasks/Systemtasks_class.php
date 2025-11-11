<?php 
require_once("SystemtasksDBO.php");
class Systemtasks
{				
	var $id;			
	var $name;			
	var $action;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $systemtasksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->action=str_replace("'","\'",$obj->action);
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

	//get action
	function getAction(){
		return $this->action;
	}
	//set action
	function setAction($action){
		$this->action=$action;
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
		$systemtasksDBO = new SystemtasksDBO();
		if($systemtasksDBO->persist($obj)){
			$this->id=$systemtasksDBO->id;
			$this->sql=$systemtasksDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$systemtasksDBO = new SystemtasksDBO();
		if($systemtasksDBO->update($obj,$where)){
			$this->sql=$systemtasksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$systemtasksDBO = new SystemtasksDBO();
		if($systemtasksDBO->delete($obj,$where=""))		
			$this->sql=$systemtasksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$systemtasksDBO = new SystemtasksDBO();
		$this->table=$systemtasksDBO->table;
		$systemtasksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$systemtasksDBO->sql;
		$this->result=$systemtasksDBO->result;
		$this->fetchObject=$systemtasksDBO->fetchObject;
		$this->affectedRows=$systemtasksDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="System Task Title should be provided";
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
