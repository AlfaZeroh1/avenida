<?php 
require_once("ReviewsDBO.php");
class Reviews
{				
	var $id;			
	var $name;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $reviewsDBO;
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
		$reviewsDBO = new ReviewsDBO();
		if($reviewsDBO->persist($obj)){
			$this->id=$reviewsDBO->id;
			$this->sql=$reviewsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$reviewsDBO = new ReviewsDBO();
		if($reviewsDBO->update($obj,$where)){
			$this->sql=$reviewsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$reviewsDBO = new ReviewsDBO();
		if($reviewsDBO->delete($obj,$where=""))		
			$this->sql=$reviewsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$reviewsDBO = new ReviewsDBO();
		$this->table=$reviewsDBO->table;
		$reviewsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$reviewsDBO->sql;
		$this->result=$reviewsDBO->result;
		$this->fetchObject=$reviewsDBO->fetchObject;
		$this->affectedRows=$reviewsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
