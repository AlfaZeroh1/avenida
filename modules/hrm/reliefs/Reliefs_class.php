<?php 
require_once("ReliefsDBO.php");
class Reliefs
{				
	var $id;			
	var $name;			
	var $amount;			
	var $overall;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $reliefsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->overall=str_replace("'","\'",$obj->overall);
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

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get overall
	function getOverall(){
		return $this->overall;
	}
	//set overall
	function setOverall($overall){
		$this->overall=$overall;
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
		$reliefsDBO = new ReliefsDBO();
		if($reliefsDBO->persist($obj)){
			$this->id=$reliefsDBO->id;
			$this->sql=$reliefsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$reliefsDBO = new ReliefsDBO();
		if($reliefsDBO->update($obj,$where)){
			$this->sql=$reliefsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$reliefsDBO = new ReliefsDBO();
		if($reliefsDBO->delete($obj,$where=""))		
			$this->sql=$reliefsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$reliefsDBO = new ReliefsDBO();
		$this->table=$reliefsDBO->table;
		$reliefsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$reliefsDBO->sql;
		$this->result=$reliefsDBO->result;
		$this->fetchObject=$reliefsDBO->fetchObject;
		$this->affectedRows=$reliefsDBO->affectedRows;
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
