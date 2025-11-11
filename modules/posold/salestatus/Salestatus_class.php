<?php 
require_once("SalestatusDBO.php");
class Salestatus
{				
	var $id;			
	var $name;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $salestatusDBO;
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
		$salestatusDBO = new SalestatusDBO();
		if($salestatusDBO->persist($obj)){
			$this->id=$salestatusDBO->id;
			$this->sql=$salestatusDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$salestatusDBO = new SalestatusDBO();
		if($salestatusDBO->update($obj,$where)){
			$this->sql=$salestatusDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$salestatusDBO = new SalestatusDBO();
		if($salestatusDBO->delete($obj,$where=""))		
			$this->sql=$salestatusDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$salestatusDBO = new SalestatusDBO();
		$this->table=$salestatusDBO->table;
		$salestatusDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$salestatusDBO->sql;
		$this->result=$salestatusDBO->result;
		$this->fetchObject=$salestatusDBO->fetchObject;
		$this->affectedRows=$salestatusDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
