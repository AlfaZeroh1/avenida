<?php 
require_once("LaboursDBO.php");
class Labours
{				
	var $id;			
	var $name;			
	var $rate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $laboursDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->rate=str_replace("'","\'",$obj->rate);
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

	//get rate
	function getRate(){
		return $this->rate;
	}
	//set rate
	function setRate($rate){
		$this->rate=$rate;
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
		$laboursDBO = new LaboursDBO();
		if($laboursDBO->persist($obj)){
			$this->id=$laboursDBO->id;
			$this->sql=$laboursDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$laboursDBO = new LaboursDBO();
		if($laboursDBO->update($obj,$where)){
			$this->sql=$laboursDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$laboursDBO = new LaboursDBO();
		if($laboursDBO->delete($obj,$where=""))		
			$this->sql=$laboursDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$laboursDBO = new LaboursDBO();
		$this->table=$laboursDBO->table;
		$laboursDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$laboursDBO->sql;
		$this->result=$laboursDBO->result;
		$this->fetchObject=$laboursDBO->fetchObject;
		$this->affectedRows=$laboursDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Labour Name should be provided";
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
