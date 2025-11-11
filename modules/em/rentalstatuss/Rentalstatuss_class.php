<?php 
require_once("RentalstatussDBO.php");
class Rentalstatuss
{				
	var $id;			
	var $name;			
	var $remarks;							
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;		
	var $rentalstatussDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$rentalstatussDBO = new RentalstatussDBO();
		if($rentalstatussDBO->persist($obj)){
			$this->id=$rentalstatussDBO->id;
			$this->sql=$rentalstatussDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$rentalstatussDBO = new RentalstatussDBO();
		if($rentalstatussDBO->update($obj,$where)){
			$this->sql=$rentalstatussDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$rentalstatussDBO = new RentalstatussDBO();
		if($rentalstatussDBO->delete($obj,$where=""))		
			$this->sql=$rentalstatussDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$rentalstatussDBO = new RentalstatussDBO();
		$this->table=$rentalstatussDBO->table;
		$rentalstatussDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$rentalstatussDBO->sql;
		$this->result=$rentalstatussDBO->result;
		$this->fetchObject=$rentalstatussDBO->fetchObject;
		$this->affectedRows=$rentalstatussDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
