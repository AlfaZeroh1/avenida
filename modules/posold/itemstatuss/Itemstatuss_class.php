<?php 
require_once("ItemstatussDBO.php");
class Itemstatuss
{				
	var $id;			
	var $name;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $itemstatussDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
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
		$itemstatussDBO = new ItemstatussDBO();
		if($itemstatussDBO->persist($obj)){
			$this->id=$itemstatussDBO->id;
			$this->sql=$itemstatussDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$itemstatussDBO = new ItemstatussDBO();
		if($itemstatussDBO->update($obj,$where)){
			$this->sql=$itemstatussDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$itemstatussDBO = new ItemstatussDBO();
		if($itemstatussDBO->delete($obj,$where=""))		
			$this->sql=$itemstatussDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$itemstatussDBO = new ItemstatussDBO();
		$this->table=$itemstatussDBO->table;
		$itemstatussDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$itemstatussDBO->sql;
		$this->result=$itemstatussDBO->result;
		$this->fetchObject=$itemstatussDBO->fetchObject;
		$this->affectedRows=$itemstatussDBO->affectedRows;
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
